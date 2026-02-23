<?php

// 123盘存储/备份 - 路由

!defined('DEBUG') AND exit('Forbidden');

include _include(APP_PATH.'plugin/pan123_storage/model/pan123.func.php');

$action = param(1, '');

// 默认：简单健康检查
if ($action == '' || $action == 'ping') {
    user_login_check();

    $tokenInfo = pan123_storage_access_token();
    if (intval($tokenInfo['code']) !== 0) {
        message(-1, $tokenInfo['message'] ?? 'token 获取失败');
    }

    message(0, 'OK', array('expiredAt' => $tokenInfo['expiredAt']));
}

// 上传视频：先落盘再入队，不阻塞发帖
if ($action == 'video_upload') {
    user_login_check();

    $config = pan123_storage_config();
    if (empty($config['enable_video_upload'])) {
        message(1, '视频上传功能未开启');
    }

    if (empty($config['parentFileID_video'])) {
        message(1, '请先在后台配置 视频目录ID(parentFileID_video)');
    }

    if (empty($_FILES['file']) || !isset($_FILES['file']['tmp_name'])) {
        message(1, '未收到文件');
    }

    $file = $_FILES['file'];

    if (!empty($file['error'])) {
        message(1, '上传失败，错误码: '.$file['error']);
    }

    $tmp = $file['tmp_name'];
    $orgname = $file['name'] ?? 'video.mp4';
    $orgname = preg_replace('#[\\/\:\*\?"<>\|]#', '_', $orgname);

    // 简单类型校验（不严格）
    $ext = strtolower(pathinfo($orgname, PATHINFO_EXTENSION));
    $allow_ext = array('mp4','mov','m4v','mkv','webm','avi');
    if (!in_array($ext, $allow_ext)) {
        // 不强制拦截，给提示
        // message(1, '仅允许上传视频文件: '.implode(',', $allow_ext));
    }

    if ($ext === '') $ext = 'mp4';
    $remote_name = 'video_'.date('Ymd_His').'_'.substr(md5($orgname.microtime(TRUE)), 0, 8).'.'.$ext;
    $local_name = 'tmp_'.$remote_name;

    $queue_dir = $conf['upload_path'].'pan123_queue/';
    !is_dir($queue_dir) AND mkdir($queue_dir, 0777, TRUE);
    $local_path = $queue_dir.$local_name;

    $moved = @move_uploaded_file($tmp, $local_path);
    if (!$moved) {
        $moved = @copy($tmp, $local_path);
    }
    if (!$moved || !is_file($local_path)) {
        message(-1, '写入本地暂存失败');
    }

    $surrogate_aid = intval(hexdec(substr(md5($local_name . $uid . microtime(true)), 0, 8)));
    $enqueue = pan123_task_enqueue('video', array(
        'aid' => $surrogate_aid,
        'pid' => intval(param('pid', 0)),
        'tid' => intval(param('tid', 0)),
        'uid' => intval($uid),
        'local_path' => $local_path,
        'remote_name' => $remote_name,
        'parent_file_id' => intval($config['parentFileID_video']),
        'duplicate' => intval($config['duplicate'] ?? 1),
        'max_retries' => intval($config['queue_max_retries'] ?? 5),
    ));
    if (intval($enqueue['code']) !== 0) {
        @unlink($local_path);
        message(-1, $enqueue['message'] ?? '任务入队失败');
    }

    message(0, '已入队，等待后台处理', array(
        'task_id' => intval($enqueue['task_id']),
        'status' => $enqueue['status'] ?? PAN123_TASK_PENDING,
        'progress' => 0,
    ));
}

// 查询任务状态
if ($action == 'task_status') {
    user_login_check();

    $task_id = intval(param('task_id', 0));
    if ($task_id <= 0) {
        message(-1, '缺少 task_id');
    }

    $task = pan123_task_get($task_id);
    if (empty($task)) {
        message(-1, '任务不存在');
    }

    $is_owner = intval($task['uid'] ?? 0) === intval($uid);
    $is_admin = !empty($group['allowbanuser']);
    if (!$is_owner && !$is_admin) {
        message(-1, '无权查看该任务');
    }

    $result = pan123_task_decode_result($task['result_json'] ?? '');
    message(0, 'ok', array(
        'task_id' => intval($task['task_id']),
        'status' => strval($task['status'] ?? PAN123_TASK_PENDING),
        'progress' => intval($task['progress'] ?? 0),
        'error' => strval($task['last_error'] ?? ''),
        'retries' => intval($task['retries'] ?? 0),
        'max_retries' => intval($task['max_retries'] ?? 0),
        'next_run_at' => intval($task['next_run_at'] ?? 0),
        'result' => $result,
        'shareUrl' => strval($result['shareUrl'] ?? ''),
        'directUrl' => strval($result['directUrl'] ?? ''),
        'embed' => strval($result['embed'] ?? ''),
    ));
}

// 手动重试失败任务（前台视频上传失败时可直接重试）
if ($action == 'task_retry') {
    user_login_check();

    $task_id = intval(param('task_id', 0));
    if ($task_id <= 0) {
        message(-1, '缺少 task_id');
    }

    $task = pan123_task_get($task_id);
    if (empty($task)) {
        message(-1, '任务不存在');
    }

    $is_owner = intval($task['uid'] ?? 0) === intval($uid);
    $is_admin = !empty($group['allowbanuser']);
    if (!$is_owner && !$is_admin) {
        message(-1, '无权重试该任务');
    }

    $status = strval($task['status'] ?? '');
    if (!in_array($status, array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL), true)) {
        message(-1, '当前任务状态不可重试：' . $status);
    }

    $now = time();
    $last_updated = intval($task['updated_at'] ?? 0);
    if ($now - $last_updated < 30) {
        message(-1, '操作过于频繁，请 30 秒后再试');
    }

    $old_retries = intval($task['retries'] ?? 0);
    $keep_retries = ($old_retries > 0) ? max(0, $old_retries - 1) : 0;

    $updated = pan123_task_update($task_id, array(
        'status' => PAN123_TASK_PENDING,
        'progress' => 0,
        'retries' => $keep_retries,
        'next_run_at' => $now,
        'last_error' => '',
        'updated_at' => $now,
        'locked_at' => 0,
    ));
    if ($updated === false) {
        message(-1, '重试失败，请稍后再试');
    }

    pan123_queue_log('task retry via route', array(
        'task_id' => $task_id,
        'uid' => intval($uid),
        'from_status' => $status,
    ));

    message(0, '任务已重新入队', array(
        'task_id' => $task_id,
        'status' => PAN123_TASK_PENDING,
        'progress' => 0,
    ));
}

message(1, '未知 action');

?>
