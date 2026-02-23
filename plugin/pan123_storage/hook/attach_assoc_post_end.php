<?php

// 图片附件：本地保存 + 123盘备份

include_once _include(APP_PATH.'plugin/pan123_storage/model/pan123.func.php');

$config = pan123_storage_config();

if (empty($config['enable_image_backup'])) return;
if (empty($config['parentFileID_image'])) return;

// 只处理图片
$ext = strtolower($attach['filetype'] ?? '');
$is_image = (!empty($attach['width']) && !empty($attach['height'])) || in_array($ext, array('jpg','jpeg','png','gif','webp','bmp'));
if (!$is_image) return;

// 避免重复上传
$exists = db_find_one('pan123_map', array('aid' => $aid, 'type' => 1));
if ($exists) return;

// 构造上传文件名
$remote_name = 'img_'.$aid.'_'.$attach['dateline'].'.'.$ext;

$duplicate = intval($config['duplicate'] ?? 1);
$parentFileID = intval($config['parentFileID_image']);

$enqueue = pan123_task_enqueue('image', array(
    'aid' => intval($aid),
    'pid' => intval($attach['pid'] ?? 0),
    'tid' => intval($attach['tid'] ?? 0),
    'uid' => intval($uid ?? 0),
    'local_path' => $attachpath,
    'remote_name' => $remote_name,
    'parent_file_id' => $parentFileID,
    'duplicate' => $duplicate,
    'max_retries' => intval($config['queue_max_retries'] ?? 5),
));
if (intval($enqueue['code']) !== 0) {
    // 失败不影响发帖主流程，只记录日志
    pan123_queue_log('enqueue image failed', array(
        'aid' => intval($aid),
        'pid' => intval($attach['pid'] ?? 0),
        'tid' => intval($attach['tid'] ?? 0),
        'error' => $enqueue['message'] ?? '',
    ));
}

?>
