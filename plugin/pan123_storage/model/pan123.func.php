<?php

/*
    pan123_storage

    参考：
    - 123盘 OpenAPI 接入、上传接口文档（社区整理版）
    - 直链/分享参数参考开源示例（wojiaoyishang/123pan）

    说明：
    - token 通过 kv 表缓存，避免频繁申请（token 有数量限制）
    - 图片/文字：优先使用单步上传（<=1GB）
    - 视频：<=1GB 用单步上传，>1GB 自动走分片上传
*/

// 获取插件配置
function pan123_storage_config() {
    $config = setting_get('pan123_storage');
    return is_array($config) ? $config : array();
}

if (!defined('PAN123_TASK_PENDING')) define('PAN123_TASK_PENDING', 'PENDING');
if (!defined('PAN123_TASK_RUNNING')) define('PAN123_TASK_RUNNING', 'RUNNING');
if (!defined('PAN123_TASK_SUCCESS')) define('PAN123_TASK_SUCCESS', 'SUCCESS');
if (!defined('PAN123_TASK_FAIL_RETRY')) define('PAN123_TASK_FAIL_RETRY', 'FAIL_RETRY');
if (!defined('PAN123_TASK_FAIL_FINAL')) define('PAN123_TASK_FAIL_FINAL', 'FAIL_FINAL');

function pan123_queue_log($message, $context = array()) {
    global $conf;

    $line = '[' . date('Y-m-d H:i:s') . '] ' . $message;
    if (!empty($context)) {
        $json = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json !== false) {
            $line .= ' | ' . $json;
        }
    }
    $line .= PHP_EOL;

    $target = isset($conf['upload_path']) ? $conf['upload_path'] . 'log/pan123_queue.log' : APP_PATH . 'upload/log/pan123_queue.log';
    $dir = dirname($target);
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    $sz = @filesize($target);
    if ($sz !== false && $sz > 10485760) {
        @rename($target, $target . '.1');
    }
    @file_put_contents($target, $line, FILE_APPEND);
}

function pan123_task_retry_delay($retries, $base_sec = 60) {
    $retries = max(0, intval($retries));
    $base_sec = max(1, intval($base_sec));
    $delay = $base_sec * pow(2, $retries);
    $max_delay = 86400;
    return intval(min($delay, $max_delay));
}

function pan123_storage_queue_ensure_schema() {
    static $inited = false;
    if ($inited) return;

    global $db;
    if (empty($db) || empty($db->tablepre)) return;

    $tablepre = $db->tablepre;
    $sql = "CREATE TABLE IF NOT EXISTS {$tablepre}pan123_task (
        task_id bigint(20) unsigned NOT NULL auto_increment,
        task_type varchar(16) NOT NULL default '',
        aid int(11) unsigned NOT NULL default '0',
        pid int(11) unsigned NOT NULL default '0',
        tid int(11) unsigned NOT NULL default '0',
        uid int(11) unsigned NOT NULL default '0',
        local_path varchar(255) NOT NULL default '',
        remote_name varchar(255) NOT NULL default '',
        parent_file_id bigint(20) unsigned NOT NULL default '0',
        duplicate tinyint(3) unsigned NOT NULL default '1',
        status varchar(16) NOT NULL default 'PENDING',
        progress tinyint(3) unsigned NOT NULL default '0',
        retries tinyint(3) unsigned NOT NULL default '0',
        max_retries tinyint(3) unsigned NOT NULL default '5',
        next_run_at int(11) unsigned NOT NULL default '0',
        last_error varchar(500) NOT NULL default '',
        result_json text NULL,
        locked_at int(11) unsigned NOT NULL default '0',
        created_at int(11) unsigned NOT NULL default '0',
        updated_at int(11) unsigned NOT NULL default '0',
        PRIMARY KEY (task_id),
        KEY idx_type_ref (task_type, aid, pid, tid),
        KEY idx_status_next (status, next_run_at),
        KEY idx_uid (uid),
        KEY idx_locked_at (locked_at)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
    db_exec($sql);

    $inited = true;
}

function pan123_task_encode_result($arr) {
    if (function_exists('xn_json_encode')) {
        return xn_json_encode($arr);
    }
    return json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function pan123_task_decode_result($json) {
    if (!is_string($json) || $json === '') {
        return array();
    }
    $arr = json_decode($json, true);
    return is_array($arr) ? $arr : array();
}

function pan123_task_strcut($text, $len) {
    $text = strval($text);
    $len = max(1, intval($len));
    if (function_exists('mb_substr')) {
        return mb_substr($text, 0, $len);
    }
    return substr($text, 0, $len);
}

// 简单 curl 请求
function pan123_storage_curl($method, $url, $headers = array(), $postfields = NULL, $timeout = 60) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $method = strtoupper($method);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, TRUE);
        if ($postfields !== NULL) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }
    } elseif ($method === 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        if ($postfields !== NULL) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }
    } elseif ($method === 'GET') {
        // do nothing
    } else {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($postfields !== NULL) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }
    }

    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    $resp = curl_exec($ch);
    $errno = curl_errno($ch);
    $error = curl_error($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array($errno, $error, $httpcode, $resp);
}

// 获取 access_token（带缓存）
function pan123_storage_access_token() {
    $config = pan123_storage_config();

    $clientID = $config['clientID'] ?? '';
    $clientSecret = $config['clientSecret'] ?? '';

    if (empty($clientID) || empty($clientSecret)) {
        return array('code' => -1, 'message' => '请先在后台配置 clientID/clientSecret');
    }

    $token = kv_get('pan123_storage_access_token');
    $expiredAt = kv_get('pan123_storage_access_token_expiredAt');

    if (!empty($token) && !empty($expiredAt)) {
        $expired_ts = strtotime($expiredAt);
        // 提前 1 小时刷新
        if ($expired_ts && time() < ($expired_ts - 3600)) {
            return array('code' => 0, 'accessToken' => $token, 'expiredAt' => $expiredAt);
        }
    }

    $lock_path = (isset($conf['upload_path']) ? $conf['upload_path'] : APP_PATH . 'upload/') . 'log/pan123_token.lock';
    $lock_dir = dirname($lock_path);
    if (!is_dir($lock_dir)) @mkdir($lock_dir, 0777, true);
    $lock_fp = @fopen($lock_path, 'c+');
    if ($lock_fp) @flock($lock_fp, LOCK_EX);

    $token2 = kv_get('pan123_storage_access_token');
    $exp2 = kv_get('pan123_storage_access_token_expiredAt');
    if (!empty($token2) && !empty($exp2)) {
        $ts2 = strtotime($exp2);
        if ($ts2 && time() < ($ts2 - 3600)) {
            if ($lock_fp) { @flock($lock_fp, LOCK_UN); @fclose($lock_fp); }
            return array('code' => 0, 'accessToken' => $token2, 'expiredAt' => $exp2);
        }
    }

    $url = 'https://open-api.123pan.com/api/v1/access_token';
    $headers = array('Platform: open_platform');

    $postfields = array(
        'clientID' => $clientID,
        'clientSecret' => $clientSecret,
    );

    list($errno, $error, $httpcode, $resp) = pan123_storage_curl('POST', $url, $headers, $postfields, 30);

    if ($errno) {
        if ($lock_fp) { @flock($lock_fp, LOCK_UN); @fclose($lock_fp); }
        return array('code' => -2, 'message' => 'curl error: '.$error);
    }

    $json = json_decode($resp, TRUE);
    if (!is_array($json)) {
        if ($lock_fp) { @flock($lock_fp, LOCK_UN); @fclose($lock_fp); }
        return array('code' => -3, 'message' => 'token 接口返回非 JSON: '.$resp);
    }

    if (intval($json['code'] ?? -999) !== 0) {
        if ($lock_fp) { @flock($lock_fp, LOCK_UN); @fclose($lock_fp); }
        return array('code' => intval($json['code'] ?? -999), 'message' => $json['message'] ?? '获取 token 失败');
    }

    $data = $json['data'] ?? array();
    $accessToken = $data['accessToken'] ?? '';
    $expiredAt = $data['expiredAt'] ?? '';

    if (empty($accessToken) || empty($expiredAt)) {
        if ($lock_fp) { @flock($lock_fp, LOCK_UN); @fclose($lock_fp); }
        return array('code' => -4, 'message' => 'token 接口返回缺少 accessToken/expiredAt');
    }

    kv_set('pan123_storage_access_token', $accessToken);
    kv_set('pan123_storage_access_token_expiredAt', $expiredAt);

    if ($lock_fp) { @flock($lock_fp, LOCK_UN); @fclose($lock_fp); }
    return array('code' => 0, 'accessToken' => $accessToken, 'expiredAt' => $expiredAt);
}

// 获取上传域名（单步上传）
function pan123_storage_upload_domain($accessToken) {
    $url = 'https://open-api.123pan.com/upload/v2/file/domain';
    $headers = array(
        'Platform: open_platform',
        'Authorization: Bearer '.$accessToken,
    );

    list($errno, $error, $httpcode, $resp) = pan123_storage_curl('GET', $url, $headers, NULL, 30);

    if ($errno) {
        return array('code' => -1, 'message' => 'curl error: '.$error);
    }

    $json = json_decode($resp, TRUE);
    if (!is_array($json)) {
        return array('code' => -2, 'message' => 'upload domain 返回非 JSON: '.$resp);
    }

    if (intval($json['code'] ?? -999) !== 0) {
        return array('code' => intval($json['code'] ?? -999), 'message' => $json['message'] ?? '获取上传域名失败');
    }

    $data = $json['data'] ?? array();
    if (is_array($data) && !empty($data)) {
        return array('code' => 0, 'domain' => $data[0]);
    }

    return array('code' => -3, 'message' => 'upload domain 数据为空');
}

// 单步上传（<=1GB）
function pan123_storage_single_upload($filepath, $filename, $parentFileID, $duplicate = 1) {
    if (!is_file($filepath)) {
        return array('code' => -1, 'message' => '本地文件不存在: '.$filepath);
    }

    $tokenInfo = pan123_storage_access_token();
    if (intval($tokenInfo['code']) !== 0) {
        return $tokenInfo;
    }

    $accessToken = $tokenInfo['accessToken'];

    $domainInfo = pan123_storage_upload_domain($accessToken);
    if (intval($domainInfo['code']) !== 0) {
        return $domainInfo;
    }

    $domain = rtrim($domainInfo['domain'], '/');
    $url = $domain.'/upload/v2/file/single/create';

    $size = filesize($filepath);
    $etag = md5_file($filepath);

    $headers = array(
        'Platform: open_platform',
        'Authorization: Bearer '.$accessToken,
    );

    $postfields = array(
        'parentFileID' => intval($parentFileID),
        'filename' => $filename,
        'etag' => $etag,
        'size' => intval($size),
        'duplicate' => intval($duplicate),
        'file' => curl_file_create($filepath)
    );

    list($errno, $error, $httpcode, $resp) = pan123_storage_curl('POST', $url, $headers, $postfields, 600);

    if ($errno) {
        return array('code' => -2, 'message' => 'curl error: '.$error);
    }

    $json = json_decode($resp, TRUE);
    if (!is_array($json)) {
        return array('code' => -3, 'message' => 'single upload 返回非 JSON: '.$resp);
    }

    if (intval($json['code'] ?? -999) !== 0) {
        return array('code' => intval($json['code'] ?? -999), 'message' => $json['message'] ?? '上传失败', 'raw' => $json);
    }

    $data = $json['data'] ?? array();

    return array(
        'code' => 0,
        'fileID' => $data['fileID'] ?? 0,
        'etag' => $etag,
        'size' => $size,
        'raw' => $json
    );
}

// 分片上传（>1GB）
function pan123_storage_slice_upload($filepath, $filename, $parentFileID, $duplicate = 1) {
    if (!is_file($filepath)) {
        return array('code' => -1, 'message' => '本地文件不存在: '.$filepath);
    }

    $tokenInfo = pan123_storage_access_token();
    if (intval($tokenInfo['code']) !== 0) {
        return $tokenInfo;
    }

    $accessToken = $tokenInfo['accessToken'];

    $size = filesize($filepath);
    $etag = md5_file($filepath);

    $headers = array(
        'Platform: open_platform',
        'Authorization: Bearer '.$accessToken,
        'Content-Type: application/json'
    );

    $create_url = 'https://open-api.123pan.com/upload/v2/file/create';
    $create_body = json_encode(array(
        'parentFileID' => intval($parentFileID),
        'filename' => $filename,
        'etag' => $etag,
        'size' => intval($size),
        'duplicate' => intval($duplicate)
    ));

    list($errno, $error, $httpcode, $resp) = pan123_storage_curl('POST', $create_url, $headers, $create_body, 60);

    if ($errno) {
        return array('code' => -2, 'message' => 'curl error: '.$error);
    }

    $json = json_decode($resp, TRUE);
    if (!is_array($json)) {
        return array('code' => -3, 'message' => 'slice create 返回非 JSON: '.$resp);
    }

    if (intval($json['code'] ?? -999) !== 0) {
        return array('code' => intval($json['code'] ?? -999), 'message' => $json['message'] ?? '分片初始化失败', 'raw' => $json);
    }

    $data = $json['data'] ?? array();
    if (!empty($data['reuse'])) {
        // 秒传
        return array(
            'code' => 0,
            'fileID' => $data['fileID'] ?? 0,
            'etag' => $etag,
            'size' => $size,
            'raw' => $json,
            'reuse' => 1
        );
    }

    $preuploadID = $data['preuploadID'] ?? '';
    $sliceSize = intval($data['sliceSize'] ?? 0);
    $servers = $data['servers'] ?? array();

    if (empty($preuploadID) || $sliceSize <= 0 || empty($servers)) {
        return array('code' => -4, 'message' => '分片初始化返回缺少 preuploadID/sliceSize/servers', 'raw' => $json);
    }

    $upload_server = rtrim($servers[0], '/');

    $fp = fopen($filepath, 'rb');
    if (!$fp) {
        return array('code' => -5, 'message' => '无法读取文件');
    }

    $sliceNo = 1;
    $uploaded = 0;

    while (!feof($fp)) {
        $chunk = fread($fp, $sliceSize);
        if ($chunk === '' || $chunk === FALSE) {
            break;
        }

        $tmp = sys_get_temp_dir().'/pan123_'.$preuploadID.'_'.$sliceNo;
        file_put_contents($tmp, $chunk);
        $sliceMD5 = md5($chunk);

        $slice_url = $upload_server.'/upload/v2/file/slice';
        $slice_headers = array(
            'Platform: open_platform',
            'Authorization: Bearer '.$accessToken,
        );

        $slice_post = array(
            'preuploadID' => $preuploadID,
            'sliceNo' => $sliceNo,
            'sliceMD5' => $sliceMD5,
            'slice' => curl_file_create($tmp)
        );

        list($e2, $err2, $hc2, $resp2) = pan123_storage_curl('POST', $slice_url, $slice_headers, $slice_post, 600);

        @unlink($tmp);

        if ($e2) {
            fclose($fp);
            return array('code' => -6, 'message' => '上传分片失败: '.$err2);
        }

        $j2 = json_decode($resp2, TRUE);
        if (!is_array($j2) || intval($j2['code'] ?? -999) !== 0) {
            fclose($fp);
            return array('code' => intval($j2['code'] ?? -999), 'message' => $j2['message'] ?? '分片上传失败', 'raw' => $j2);
        }

        $uploaded += strlen($chunk);
        $sliceNo++;

        // 可考虑在这里写入日志/进度
    }

    fclose($fp);

    // 完成上传
    $complete_url = 'https://open-api.123pan.com/upload/v2/file/upload_complete';
    $complete_body = json_encode(array('preuploadID' => $preuploadID));

    list($e3, $err3, $hc3, $resp3) = pan123_storage_curl('POST', $complete_url, $headers, $complete_body, 60);

    if ($e3) {
        return array('code' => -7, 'message' => 'upload_complete curl error: '.$err3);
    }

    $j3 = json_decode($resp3, TRUE);
    if (!is_array($j3) || intval($j3['code'] ?? -999) !== 0) {
        return array('code' => intval($j3['code'] ?? -999), 'message' => $j3['message'] ?? 'upload_complete 失败', 'raw' => $j3);
    }

    $d3 = $j3['data'] ?? array();

    // 可能异步，需要轮询
    if (!empty($d3['async'])) {
        $async_url = 'https://open-api.123pan.com/upload/v2/file/upload_async_result';
        $wait = 0;
        while ($wait < 600) {
            sleep(1);
            $wait++;
            $async_body = json_encode(array('preuploadID' => $preuploadID));
            list($e4, $err4, $hc4, $resp4) = pan123_storage_curl('POST', $async_url, $headers, $async_body, 30);
            if ($e4) continue;
            $j4 = json_decode($resp4, TRUE);
            if (!is_array($j4) || intval($j4['code'] ?? -999) !== 0) continue;
            $d4 = $j4['data'] ?? array();
            if (!empty($d4['completed'])) {
                return array(
                    'code' => 0,
                    'fileID' => $d4['fileID'] ?? 0,
                    'etag' => $etag,
                    'size' => $size,
                    'raw' => $j4,
                    'reuse' => 0
                );
            }
        }
        return array('code' => -8, 'message' => '异步上传超时');
    }

    if (!empty($d3['completed'])) {
        return array(
            'code' => 0,
            'fileID' => $d3['fileID'] ?? 0,
            'etag' => $etag,
            'size' => $size,
            'raw' => $j3,
            'reuse' => 0
        );
    }

    return array('code' => -9, 'message' => '上传完成状态未知', 'raw' => $j3);
}

// 根据大小自动选择上传方式
function pan123_storage_upload_auto($filepath, $filename, $parentFileID, $duplicate = 1) {
    $size = @filesize($filepath);
    if ($size === FALSE) {
        return array('code' => -1, 'message' => '无法读取文件大小');
    }

    // 单步上传限制：<= 1GB
    if ($size <= 1073741824) {
        return pan123_storage_single_upload($filepath, $filename, $parentFileID, $duplicate);
    }

    return pan123_storage_slice_upload($filepath, $filename, $parentFileID, $duplicate);
}

// 创建分享链接
function pan123_storage_share_create($fileID, $shareName, $shareExpire = 0, $sharePwd = '') {
    $tokenInfo = pan123_storage_access_token();
    if (intval($tokenInfo['code']) !== 0) {
        return $tokenInfo;
    }

    $accessToken = $tokenInfo['accessToken'];

    $url = 'https://open-api.123pan.com/api/v1/share/create';
    $headers = array(
        'Platform: open_platform',
        'Authorization: Bearer '.$accessToken,
    );

    $post = array(
        'shareName' => $shareName,
        'shareExpire' => intval($shareExpire),
        'fileIDList' => strval($fileID),
    );
    if (!empty($sharePwd)) {
        $post['sharePwd'] = $sharePwd;
    }

    list($errno, $error, $httpcode, $resp) = pan123_storage_curl('POST', $url, $headers, $post, 30);

    if ($errno) {
        return array('code' => -1, 'message' => 'curl error: '.$error);
    }

    $json = json_decode($resp, TRUE);
    if (!is_array($json)) {
        return array('code' => -2, 'message' => 'share create 返回非 JSON: '.$resp);
    }

    if (intval($json['code'] ?? -999) !== 0) {
        return array('code' => intval($json['code'] ?? -999), 'message' => $json['message'] ?? '创建分享失败', 'raw' => $json);
    }

    $data = $json['data'] ?? array();
    $shareKey = $data['shareKey'] ?? '';

    if (empty($shareKey)) {
        return array('code' => -3, 'message' => 'share create 缺少 shareKey', 'raw' => $json);
    }

    $shareUrl = 'https://www.123pan.com/s/'.$shareKey;

    return array(
        'code' => 0,
        'shareKey' => $shareKey,
        'shareUrl' => $shareUrl,
        'raw' => $json
    );
}

// 获取直链（可能需要付费）
function pan123_storage_direct_link_url($fileID) {
    $tokenInfo = pan123_storage_access_token();
    if (intval($tokenInfo['code']) !== 0) {
        return $tokenInfo;
    }

    $accessToken = $tokenInfo['accessToken'];

    // 参考开源示例：GET /api/v1/direct-link/url?fileID=xxx
    $url = 'https://open-api.123pan.com/api/v1/direct-link/url?fileID='.intval($fileID);

    $headers = array(
        'Platform: open_platform',
        'Authorization: Bearer '.$accessToken,
    );

    list($errno, $error, $httpcode, $resp) = pan123_storage_curl('GET', $url, $headers, NULL, 30);

    if ($errno) {
        return array('code' => -1, 'message' => 'curl error: '.$error);
    }

    $json = json_decode($resp, TRUE);
    if (!is_array($json)) {
        return array('code' => -2, 'message' => 'direct link 返回非 JSON: '.$resp);
    }

    if (intval($json['code'] ?? -999) !== 0) {
        return array('code' => intval($json['code'] ?? -999), 'message' => $json['message'] ?? '获取直链失败', 'raw' => $json);
    }

    $data = $json['data'] ?? array();
    $url = $data['url'] ?? '';

    return array('code' => 0, 'url' => $url, 'raw' => $json);
}

function pan123_task_enqueue($task_type, $args = array()) {
    global $time;
    pan123_storage_queue_ensure_schema();

    $allow = array('text', 'image', 'video');
    if (!in_array($task_type, $allow, true)) {
        return array('code' => -1, 'message' => '未知任务类型: ' . $task_type);
    }

    $now = !empty($time) ? intval($time) : time();
    $config = pan123_storage_config();

    $aid = intval($args['aid'] ?? 0);
    $pid = intval($args['pid'] ?? 0);
    $tid = intval($args['tid'] ?? 0);
    $uid = intval($args['uid'] ?? 0);

    $local_path = strval($args['local_path'] ?? '');
    $remote_name = strval($args['remote_name'] ?? '');
    $parent_file_id = intval($args['parent_file_id'] ?? 0);
    $duplicate = intval($args['duplicate'] ?? ($config['duplicate'] ?? 1));
    $max_retries = intval($args['max_retries'] ?? ($config['queue_max_retries'] ?? 5));
    if ($max_retries < 1) $max_retries = 1;

    if ($local_path === '' || !is_file($local_path)) {
        return array('code' => -2, 'message' => '本地文件不存在: ' . $local_path);
    }
    if ($remote_name === '') {
        return array('code' => -3, 'message' => 'remote_name 不能为空');
    }
    if ($parent_file_id <= 0) {
        return array('code' => -4, 'message' => 'parent_file_id 不能为空');
    }

    $cond = array(
        'task_type' => $task_type,
        'aid' => $aid,
        'pid' => $pid,
        'tid' => $tid,
    );
    $exists = db_find_one('pan123_task', $cond, array('task_id' => -1));

    if (!empty($exists)) {
        $status = strval($exists['status'] ?? '');
        if (in_array($status, array(PAN123_TASK_PENDING, PAN123_TASK_RUNNING, PAN123_TASK_FAIL_RETRY, PAN123_TASK_SUCCESS), true)) {
            return array(
                'code' => 0,
                'task_id' => intval($exists['task_id']),
                'queued' => 0,
                'status' => $status,
                'message' => '任务已存在，跳过重复入队',
            );
        }

        $update = array(
            'uid' => $uid,
            'local_path' => $local_path,
            'remote_name' => $remote_name,
            'parent_file_id' => $parent_file_id,
            'duplicate' => $duplicate,
            'status' => PAN123_TASK_PENDING,
            'progress' => 0,
            'retries' => 0,
            'max_retries' => $max_retries,
            'next_run_at' => $now,
            'last_error' => '',
            'result_json' => '',
            'locked_at' => 0,
            'updated_at' => $now,
        );
        db_update('pan123_task', array('task_id' => intval($exists['task_id'])), $update);

        return array(
            'code' => 0,
            'task_id' => intval($exists['task_id']),
            'queued' => 1,
            'status' => PAN123_TASK_PENDING,
            'message' => '旧任务已重置并重新入队',
        );
    }

    $insert = array(
        'task_type' => $task_type,
        'aid' => $aid,
        'pid' => $pid,
        'tid' => $tid,
        'uid' => $uid,
        'local_path' => $local_path,
        'remote_name' => $remote_name,
        'parent_file_id' => $parent_file_id,
        'duplicate' => $duplicate,
        'status' => PAN123_TASK_PENDING,
        'progress' => 0,
        'retries' => 0,
        'max_retries' => $max_retries,
        'next_run_at' => $now,
        'last_error' => '',
        'result_json' => '',
        'locked_at' => 0,
        'created_at' => $now,
        'updated_at' => $now,
    );
    $task_id = db_insert('pan123_task', $insert);
    if ($task_id === false) {
        return array('code' => -5, 'message' => '写入任务队列失败');
    }

    return array(
        'code' => 0,
        'task_id' => intval($task_id),
        'queued' => 1,
        'status' => PAN123_TASK_PENDING,
        'message' => '已入队',
    );
}

function pan123_task_get($task_id) {
    pan123_storage_queue_ensure_schema();
    return db_find_one('pan123_task', array('task_id' => intval($task_id)));
}

function pan123_task_update($task_id, $update) {
    pan123_storage_queue_ensure_schema();
    return db_update('pan123_task', array('task_id' => intval($task_id)), $update);
}

function pan123_task_upsert_map($task, $upload_result, $now) {
    $task_type = strval($task['task_type'] ?? '');
    $aid = intval($task['aid'] ?? 0);
    $pid = intval($task['pid'] ?? 0);
    $tid = intval($task['tid'] ?? 0);

    $fileID = intval($upload_result['fileID'] ?? 0);
    $etag = strval($upload_result['etag'] ?? '');
    $size = intval($upload_result['size'] ?? 0);
    $filename = strval($task['remote_name'] ?? '');

    $type = 0;
    if ($task_type === 'image') {
        $type = 1;
    } elseif ($task_type === 'text') {
        $type = (strpos($filename, 'thread_') === 0) ? 2 : 3;
    } elseif ($task_type === 'video') {
        $type = 4;
    }

    $row = array(
        'type' => $type,
        'aid' => $aid,
        'tid' => $tid,
        'pid' => $pid,
        'fileID' => $fileID,
        'filename' => $filename,
        'etag' => $etag,
        'size' => $size,
        'create_date' => $now,
        'update_date' => $now,
    );

    $cond = array('type' => $type, 'aid' => $aid, 'pid' => $pid, 'tid' => $tid);
    $exists = db_find_one('pan123_map', $cond);
    if (!empty($exists)) {
        db_update('pan123_map', array('id' => intval($exists['id'])), array(
            'fileID' => $fileID,
            'filename' => $filename,
            'etag' => $etag,
            'size' => $size,
            'update_date' => $now,
        ));
    } else {
        db_insert('pan123_map', $row);
    }
}

function pan123_task_process($task, $config = array()) {
    $task_id = intval($task['task_id'] ?? 0);
    $task_type = strval($task['task_type'] ?? '');
    $local_path = strval($task['local_path'] ?? '');
    $remote_name = strval($task['remote_name'] ?? '');
    $parent_file_id = intval($task['parent_file_id'] ?? 0);
    $duplicate = intval($task['duplicate'] ?? 1);

    $prev_checkpoint = pan123_task_decode_result($task['result_json'] ?? '');
    $recovered = false;

    if (!empty($prev_checkpoint['fileID']) && intval($prev_checkpoint['fileID']) > 0) {
        $upload = array(
            'code' => 0,
            'fileID' => intval($prev_checkpoint['fileID']),
            'etag' => strval($prev_checkpoint['etag'] ?? ''),
            'size' => intval($prev_checkpoint['size'] ?? 0),
        );
        $fileID = intval($prev_checkpoint['fileID']);
        $recovered = true;
        pan123_queue_log('process recovered from checkpoint', array('task_id' => $task_id, 'fileID' => $fileID));
    } else {
        if (!is_file($local_path)) {
            return array('code' => -101, 'message' => '本地文件不存在: ' . $local_path);
        }

        pan123_task_update($task_id, array(
            'progress' => 20,
            'updated_at' => time(),
            'last_error' => '',
        ));

        $upload = pan123_storage_upload_auto($local_path, $remote_name, $parent_file_id, $duplicate);
        if (intval($upload['code']) !== 0) {
            return array('code' => intval($upload['code']), 'message' => strval($upload['message'] ?? '上传失败'));
        }

        $fileID = intval($upload['fileID'] ?? 0);

        pan123_task_update($task_id, array(
            'progress' => 60,
            'result_json' => pan123_task_encode_result(array(
                'fileID' => $fileID,
                'etag' => strval($upload['etag'] ?? ''),
                'size' => intval($upload['size'] ?? 0),
            )),
            'updated_at' => time(),
        ));
    }
    $result = array(
        'task_id' => $task_id,
        'task_type' => $task_type,
        'fileID' => $fileID,
        'remote_name' => $remote_name,
        'shareUrl' => '',
        'directUrl' => '',
        'embed' => '',
    );

    if ($task_type === 'video' && $fileID > 0) {
        pan123_task_update($task_id, array('progress' => 70, 'updated_at' => time()));

        if (!empty($config['auto_share_video'])) {
            $share = pan123_storage_share_create($fileID, $remote_name, intval($config['shareExpire'] ?? 0), strval($config['sharePwd'] ?? ''));
            if (intval($share['code'] ?? -1) === 0) {
                $result['shareUrl'] = strval($share['shareUrl'] ?? '');
            }
        }

        if (!empty($config['enable_direct_link'])) {
            $direct = pan123_storage_direct_link_url($fileID);
            if (intval($direct['code'] ?? -1) === 0) {
                $direct_url = strval($direct['url'] ?? '');
                if ($direct_url !== '' && !empty($config['direct_link_primary_key']) && !empty($config['direct_link_uid'])) {
                    $direct_url = pan123_storage_direct_signed_link(
                        $direct_url,
                        intval($config['direct_link_uid']),
                        strval($config['direct_link_primary_key']),
                        intval($config['direct_link_expire_sec'] ?? 300)
                    );
                }
                $result['directUrl'] = $direct_url;
            }
        }

        if (!empty($result['directUrl'])) {
            $result['embed'] = '<video controls src="' . htmlspecialchars($result['directUrl']) . '" style="max-width:100%;"></video>';
        } elseif (!empty($result['shareUrl'])) {
            $result['embed'] = '<p><a href="' . htmlspecialchars($result['shareUrl']) . '" target="_blank" rel="nofollow">[123盘视频] 点击打开</a></p>';
        } else {
            $result['embed'] = '<p>[123盘视频] fileID: ' . $fileID . '</p>';
        }
    }

    return array(
        'code' => 0,
        'message' => 'ok',
        'upload' => $upload,
        'result' => $result,
    );
}

function pan123_task_complete_success($task, $process_result) {
    global $time;
    $now = !empty($time) ? intval($time) : time();
    $task_id = intval($task['task_id'] ?? 0);
    $upload = $process_result['upload'] ?? array();
    $result = $process_result['result'] ?? array();

    pan123_task_upsert_map($task, $upload, $now);

    pan123_task_update($task_id, array(
        'status' => PAN123_TASK_SUCCESS,
        'progress' => 100,
        'last_error' => '',
        'result_json' => pan123_task_encode_result($result),
        'updated_at' => $now,
        'locked_at' => 0,
    ));
}

function pan123_task_complete_fail($task, $error_message, $config = array()) {
    global $time;
    $now = !empty($time) ? intval($time) : time();
    $task_id = intval($task['task_id'] ?? 0);

    $retries = intval($task['retries'] ?? 0) + 1;
    $max_retries = intval($task['max_retries'] ?? ($config['queue_max_retries'] ?? 5));
    if ($max_retries < 1) $max_retries = 1;
    $base_sec = intval($config['queue_retry_base_sec'] ?? 60);
    if ($base_sec < 1) $base_sec = 1;

    if ($retries >= $max_retries) {
        pan123_task_update($task_id, array(
            'status' => PAN123_TASK_FAIL_FINAL,
            'progress' => 0,
            'retries' => $retries,
            'last_error' => pan123_task_strcut($error_message, 500),
            'updated_at' => $now,
            'locked_at' => 0,
        ));
        return;
    }

    $delay = pan123_task_retry_delay($retries, $base_sec);
    pan123_task_update($task_id, array(
        'status' => PAN123_TASK_FAIL_RETRY,
        'progress' => 0,
        'retries' => $retries,
        'next_run_at' => $now + $delay,
        'last_error' => pan123_task_strcut($error_message, 500),
        'updated_at' => $now,
        'locked_at' => 0,
    ));
}

// 直链鉴权签名（auth_key）
function pan123_storage_direct_signed_link($url, $uid, $primary_key, $expired_time_sec = 300) {
    $path = parse_url($url, PHP_URL_PATH);
    if (empty($path)) return $url;

    $timestamp = time() + intval($expired_time_sec);

    // 生成随机串（32位 hex）
    $rand = md5(uniqid('', TRUE));

    $unsigned = $path.'-'.$timestamp.'-'.$rand.'-'.intval($uid).'-'.$primary_key;
    $auth_key = $timestamp.'-'.$rand.'-'.intval($uid).'-'.md5($unsigned);

    // 如果 URL 已经有参数，需要拼接 &
    return (strpos($url, '?') === FALSE) ? ($url.'?auth_key='.$auth_key) : ($url.'&auth_key='.$auth_key);
}

?>
