<?php

// 回帖文字：本地生成备份文件 + 123盘备份

include_once _include(APP_PATH.'plugin/pan123_storage/model/pan123.func.php');

$config = pan123_storage_config();

if (empty($config['enable_text_backup'])) return;
if (empty($config['parentFileID_text'])) return;

$backup_dir = $conf['upload_path'].'pan123_backup/';
!is_dir($backup_dir) AND mkdir($backup_dir, 0777, TRUE);

$payload = array(
    'type' => 'post',
    'pid' => $pid,
    'tid' => $tid,
    'uid' => $uid,
    'message' => $post['message'] ?? '',
    'doctype' => $post['doctype'] ?? 0,
    'time' => $time,
    'ip' => $longip,
);

$local_file = $backup_dir.'post_'.$pid.'.json';
file_put_contents($local_file, xn_json_encode($payload));

$remote_name = 'post_'.$pid.'.json';

$enqueue = pan123_task_enqueue('text', array(
    'aid' => 0,
    'pid' => intval($pid),
    'tid' => intval($tid),
    'uid' => intval($uid),
    'local_path' => $local_file,
    'remote_name' => $remote_name,
    'parent_file_id' => intval($config['parentFileID_text']),
    'duplicate' => intval($config['duplicate'] ?? 1),
    'max_retries' => intval($config['queue_max_retries'] ?? 5),
));
if (intval($enqueue['code']) !== 0) {
    pan123_queue_log('enqueue post text failed', array(
        'tid' => intval($tid),
        'pid' => intval($pid),
        'error' => $enqueue['message'] ?? '',
    ));
}

?>
