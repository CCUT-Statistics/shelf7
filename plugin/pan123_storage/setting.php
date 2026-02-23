<?php

!defined('DEBUG') and exit('Access Denied.');

$header['title'] = '123盘存储/备份 - 运维设置';
include_once _include(APP_PATH.'plugin/pan123_storage/model/pan123.func.php');

function pan123_admin_human_size($bytes) {
    $bytes = intval($bytes);
    if ($bytes <= 0) return '0 B';
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes = $bytes / 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

function pan123_admin_error_group($error) {
    $e = strtolower(trim(strval($error)));
    if ($e === '') return 'unknown';

    if (strpos($e, 'token') !== false || strpos($e, 'auth') !== false || strpos($e, '401') !== false || strpos($e, '403') !== false || strpos($e, '鉴权') !== false) {
        return 'auth';
    }
    if (strpos($e, 'curl') !== false || strpos($e, 'timeout') !== false || strpos($e, 'network') !== false || strpos($e, '连接') !== false || strpos($e, '超时') !== false) {
        return 'network';
    }
    if (strpos($e, '本地文件不存在') !== false || strpos($e, 'no such file') !== false || strpos($e, 'local file') !== false) {
        return 'local_file';
    }
    if (strpos($e, 'quota') !== false || strpos($e, '空间') !== false || strpos($e, '容量') !== false || strpos($e, 'size') !== false) {
        return 'quota';
    }
    return 'other';
}

function pan123_admin_group_advice($group) {
    if ($group === 'auth') return '检查 clientID/clientSecret 或 token 是否过期，必要时重新保存配置';
    if ($group === 'network') return '检查服务器网络、DNS、防火墙；确认 123 API 可访问';
    if ($group === 'local_file') return '检查本地文件是否仍存在，确认 upload 目录权限';
    if ($group === 'quota') return '检查 123 盘容量/配额，必要时清理空间或调整上传策略';
    if ($group === 'other') return '查看 last_error 细节，按错误码排查';
    return '先查看 last_error，优先重试并观察';
}

if ($method == 'GET') {
    $config = setting_get('pan123_storage');
    pan123_storage_queue_ensure_schema();
    $now = time();

    $queue_status = param('queue_status', '', FALSE);
    $failed_24h = intval(param('failed_24h', 0));
    $failed_24h = $failed_24h ? 1 : 0;
    $queue_allow = array('', PAN123_TASK_PENDING, PAN123_TASK_RUNNING, PAN123_TASK_SUCCESS, PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL);
    if (!in_array($queue_status, $queue_allow, true)) {
        $queue_status = '';
    }

    $queue_status_manual = isset($_GET['queue_status']);
    if (!$queue_status_manual && !$failed_24h && $queue_status === '') {
        $final_cnt = intval(db_count('pan123_task', array('status' => PAN123_TASK_FAIL_FINAL)));
        $retry_cnt = intval(db_count('pan123_task', array('status' => PAN123_TASK_FAIL_RETRY)));
        if ($final_cnt > 0) {
            $queue_status = PAN123_TASK_FAIL_FINAL;
        } elseif ($retry_cnt > 0) {
            $queue_status = PAN123_TASK_FAIL_RETRY;
        }
    }

    $queue_cond = array();
    if ($queue_status !== '') {
        $queue_cond['status'] = $queue_status;
    }
    if ($failed_24h) {
        $queue_cond['status'] = array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL);
        $queue_cond['updated_at'] = array('>=' => ($now - 86400));
    }

    $queue_tasklist = db_find('pan123_task', $queue_cond, array('task_id' => -1), 1, 50);
    if (!empty($queue_tasklist)) {
        foreach ($queue_tasklist as $k => $qt) {
            $status = strval($qt['status'] ?? '');
            if ($status === PAN123_TASK_FAIL_RETRY || $status === PAN123_TASK_FAIL_FINAL) {
                $group = pan123_admin_error_group($qt['last_error'] ?? '');
                $queue_tasklist[$k]['error_group'] = $group;
                $queue_tasklist[$k]['advice'] = pan123_admin_group_advice($group);
            } else {
                $queue_tasklist[$k]['error_group'] = '';
                $queue_tasklist[$k]['advice'] = '';
            }
        }
    }

    $queue_status_counts = array(
        PAN123_TASK_PENDING => intval(db_count('pan123_task', array('status' => PAN123_TASK_PENDING))),
        PAN123_TASK_RUNNING => intval(db_count('pan123_task', array('status' => PAN123_TASK_RUNNING))),
        PAN123_TASK_SUCCESS => intval(db_count('pan123_task', array('status' => PAN123_TASK_SUCCESS))),
        PAN123_TASK_FAIL_RETRY => intval(db_count('pan123_task', array('status' => PAN123_TASK_FAIL_RETRY))),
        PAN123_TASK_FAIL_FINAL => intval(db_count('pan123_task', array('status' => PAN123_TASK_FAIL_FINAL))),
    );
    $failed_24h_count = intval(db_count('pan123_task', array(
        'status' => array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL),
        'updated_at' => array('>=' => ($now - 86400)),
    )));

    $export = param('export', '', FALSE);
    if ($export === 'failed_csv') {
        $export_cond = array(
            'status' => array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL),
        );
        if ($failed_24h) {
            $export_cond['updated_at'] = array('>=' => ($now - 86400));
        }
        $rows = db_find('pan123_task', $export_cond, array('task_id' => -1), 1, 5000);

        header('Content-Type: text/csv; charset=UTF-8');
        $filename = 'pan123_failed_' . ($failed_24h ? '24h_' : '') . date('Ymd_His') . '.csv';
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        $out = fopen('php://output', 'w');
        fputcsv($out, array('task_id', 'task_type', 'status', 'retries', 'max_retries', 'error_group', 'advice', 'last_error', 'updated_at'));
        if (!empty($rows)) {
            foreach ($rows as $r) {
                $group = pan123_admin_error_group($r['last_error'] ?? '');
                $advice = pan123_admin_group_advice($group);
                $updated_at = !empty($r['updated_at']) ? date('Y-m-d H:i:s', intval($r['updated_at'])) : '';
                fputcsv($out, array(
                    intval($r['task_id'] ?? 0),
                    strval($r['task_type'] ?? ''),
                    strval($r['status'] ?? ''),
                    intval($r['retries'] ?? 0),
                    intval($r['max_retries'] ?? 0),
                    $group,
                    $advice,
                    strval($r['last_error'] ?? ''),
                    $updated_at,
                ));
            }
        }
        fclose($out);
        exit;
    }

    $running_timeout = max(60, intval($config['queue_running_timeout'] ?? 900));
    $stale_running_count = intval(db_count('pan123_task', array(
        'status' => PAN123_TASK_RUNNING,
        'locked_at' => array('<' => ($now - $running_timeout)),
    )));

    $upload_path = isset($conf['upload_path']) ? rtrim(strval($conf['upload_path']), '/\\') . '/' : APP_PATH . 'upload/';
    $worker_lock_path = $upload_path . 'log/pan123_worker.lock';
    $queue_log_path = $upload_path . 'log/pan123_queue.log';
    $queue_log_rotated_path = $queue_log_path . '.1';

    $worker_lock_exists = is_file($worker_lock_path);
    $worker_lock_mtime = $worker_lock_exists ? intval(@filemtime($worker_lock_path)) : 0;
    $worker_heartbeat_age = $worker_lock_mtime > 0 ? ($now - $worker_lock_mtime) : -1;
    $worker_alive = $worker_heartbeat_age >= 0 && $worker_heartbeat_age <= 180;
    $worker_lock_text = $worker_lock_exists ? trim(strval(@file_get_contents($worker_lock_path))) : '';

    $queue_log_exists = is_file($queue_log_path);
    $queue_log_size = $queue_log_exists ? intval(@filesize($queue_log_path)) : 0;
    $queue_log_rotated_exists = is_file($queue_log_rotated_path);
    $queue_log_rotated_size = $queue_log_rotated_exists ? intval(@filesize($queue_log_rotated_path)) : 0;

    $ops_alerts = array();
    if (empty($config['queue_enable'])) {
        $ops_alerts[] = array('type' => 'danger', 'text' => '异步队列已关闭：发帖可能卡顿，建议立即开启。');
    }
    if (!$worker_alive) {
        $ops_alerts[] = array('type' => 'warning', 'text' => '未检测到 worker 最近心跳：请检查计划任务或常驻进程。');
    }
    if (!empty($queue_status_counts[PAN123_TASK_FAIL_FINAL])) {
        $ops_alerts[] = array('type' => 'danger', 'text' => '存在最终失败任务：建议先点“一键重试失败任务”，再观察 3-5 分钟。');
    }
    if ($stale_running_count > 0) {
        $ops_alerts[] = array('type' => 'warning', 'text' => '存在可能卡死的 RUNNING 任务：worker 会自动超时回收，请观察是否持续增长。');
    }
    if (empty($ops_alerts)) {
        $ops_alerts[] = array('type' => 'success', 'text' => '当前队列运行稳定，未发现明显风险。');
    }

    $task_table = (isset($db) && !empty($db->tablepre) ? $db->tablepre : 'bbs_') . 'pan123_task';
    $failed_group_counts = array(
        'auth' => 0,
        'network' => 0,
        'local_file' => 0,
        'quota' => 0,
        'other' => 0,
        'unknown' => 0,
    );
    $failed_sample = db_find('pan123_task', array(
        'status' => array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL),
    ), array('task_id' => -1), 1, 500);
    if (!empty($failed_sample)) {
        foreach ($failed_sample as $fs) {
            $g = pan123_admin_error_group($fs['last_error'] ?? '');
            $failed_group_counts[$g] = intval($failed_group_counts[$g] ?? 0) + 1;
        }
    }

    include _include(APP_PATH.'plugin/pan123_storage/view/htm/setting.htm');
} else {
    $config = setting_get('pan123_storage');
    $action = param('action', 'save', FALSE);

    if ($action === 'retry_failed') {
        $task_id = intval(param('task_id', 0));
        $retry_recent_24h = intval(param('retry_recent_24h', 0)) ? 1 : 0;
        $now = time();
        $updated = 0;

        if ($task_id > 0) {
            $task = db_find_one('pan123_task', array('task_id' => $task_id));
            if (empty($task)) {
                message(-1, '任务不存在');
            }

            $status = strval($task['status'] ?? '');
            if (!in_array($status, array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL), true)) {
                message(-1, '仅失败任务可重试');
            }

            $last_updated = intval($task['updated_at'] ?? 0);
            if ($now - $last_updated < 30) {
                message(-1, '操作过于频繁，请 30 秒后再试');
            }

            $old_retries = intval($task['retries'] ?? 0);
            $keep_retries = ($old_retries > 0) ? max(0, $old_retries - 1) : 0;
            $updated = db_update('pan123_task', array('task_id' => $task_id), array(
                'status' => PAN123_TASK_PENDING,
                'progress' => 0,
                'retries' => $keep_retries,
                'next_run_at' => $now,
                'last_error' => '',
                'updated_at' => $now,
                'locked_at' => 0,
            ));
            pan123_queue_log('manual retry single', array('task_id' => $task_id, 'uid' => intval($uid ?? 0)));
            message(0, jump($updated ? '任务已重试入队（已保留部分重试计数）' : '任务状态未变更', url('plugin-setting-pan123_storage')));
        }

        $batch_limit = 500;
        $failed_cond = array(
            'status' => array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL),
        );
        if ($retry_recent_24h) {
            $failed_cond['updated_at'] = array('>=' => ($now - 86400));
        }
        $failed_tasks = db_find('pan123_task', $failed_cond, array('task_id' => -1), 1, $batch_limit);
        if (empty($failed_tasks)) {
            $empty_msg = $retry_recent_24h ? '当前最近24小时没有失败任务需要重试' : '当前没有失败任务需要重试';
            message(0, jump($empty_msg, url('plugin-setting-pan123_storage')));
        }

        $count_retry = 0;
        $count_final = 0;
        $updated = 0;
        foreach ($failed_tasks as $ft) {
            $tid = intval($ft['task_id'] ?? 0);
            if ($tid <= 0) continue;

            $status = strval($ft['status'] ?? '');
            if ($status === PAN123_TASK_FAIL_RETRY) {
                $count_retry++;
            } elseif ($status === PAN123_TASK_FAIL_FINAL) {
                $count_final++;
            }

            $old_retries = intval($ft['retries'] ?? 0);
            $keep_retries = ($old_retries > 0) ? max(0, $old_retries - 1) : 0;
            $ok = db_update('pan123_task', array(
                'task_id' => $tid,
                'status' => $status,
            ), array(
                'status' => PAN123_TASK_PENDING,
                'progress' => 0,
                'retries' => $keep_retries,
                'next_run_at' => $now,
                'last_error' => '',
                'updated_at' => $now,
                'locked_at' => 0,
            ));
            if ($ok) {
                $updated += intval($ok);
            }
        }

        $remaining_failed_all = intval(db_count('pan123_task', array(
            'status' => array(PAN123_TASK_FAIL_RETRY, PAN123_TASK_FAIL_FINAL),
        )));
        $remaining_failed_scope = intval(db_count('pan123_task', $failed_cond));
        pan123_queue_log('manual retry all failed', array(
            'updated' => $updated,
            'picked' => count($failed_tasks),
            'remaining_failed_all' => $remaining_failed_all,
            'remaining_failed_scope' => $remaining_failed_scope,
            'retry_recent_24h' => $retry_recent_24h,
            'uid' => intval($uid ?? 0),
        ));

        $scope_text = $retry_recent_24h ? '最近24小时失败任务' : '失败任务';
        $msg = '已重试' . $scope_text . '：' . $updated . ' 条（本次可重试失败 ' . $count_retry . ' 条，最终失败 ' . $count_final . ' 条）';
        if ($remaining_failed_scope > 0) {
            $msg .= '。当前范围内仍有 ' . $remaining_failed_scope . ' 条失败任务，可再次点击重试。';
        } elseif ($retry_recent_24h && $remaining_failed_all > 0) {
            $msg .= '。最近24小时失败已处理完，历史仍有 ' . $remaining_failed_all . ' 条失败任务。';
        } elseif ($remaining_failed_all > 0) {
            $msg .= '。仍有 ' . $remaining_failed_all . ' 条失败任务，可再次点击重试。';
        }
        message(0, jump($msg, url('plugin-setting-pan123_storage')));
    }

    $config['clientID'] = param('clientID', '', FALSE);
    $config['clientSecret'] = param('clientSecret', '', FALSE);

    $config['parentFileID_image'] = param('parentFileID_image', 0);
    $config['parentFileID_text'] = param('parentFileID_text', 0);
    $config['parentFileID_video'] = param('parentFileID_video', 0);

    $config['duplicate'] = param('duplicate', 1);

    $config['enable_image_backup'] = param('enable_image_backup', 0);
    $config['enable_text_backup'] = param('enable_text_backup', 0);
    $config['enable_video_upload'] = param('enable_video_upload', 0);

    $config['auto_share_video'] = param('auto_share_video', 0);
    $config['shareExpire'] = param('shareExpire', 0);
    $config['sharePwd'] = param('sharePwd', '', FALSE);

    $config['enable_direct_link'] = param('enable_direct_link', 0);
    $config['direct_link_uid'] = param('direct_link_uid', 0);
    $config['direct_link_primary_key'] = param('direct_link_primary_key', '', FALSE);
    $config['direct_link_expire_sec'] = param('direct_link_expire_sec', 300);

    $config['queue_enable'] = param('queue_enable', 1);
    $config['queue_max_retries'] = max(1, min(20, intval(param('queue_max_retries', 5))));
    $config['queue_retry_base_sec'] = max(10, intval(param('queue_retry_base_sec', 60)));
    $config['queue_running_timeout'] = max(60, intval(param('queue_running_timeout', 900)));

    setting_set('pan123_storage', $config);

    // 保存设置时不主动刷新 token，避免误触发 token 限制。
    message(0, jump('保存成功', url('plugin-setting-pan123_storage')));
}

?>
