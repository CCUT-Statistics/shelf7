<?php
/*
    Xiuno BBS 4.0.x
    123盘存储/备份 (pan123_storage)

    - 图片附件：本地保存 + 123盘备份
    - 文字内容：本地生成备份文件 + 123盘备份
    - 视频：通过插件接口上传到 123盘，返回分享/直链
*/

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;

// 记录附件/文本在 123盘的映射关系
$sql = "CREATE TABLE IF NOT EXISTS {$tablepre}pan123_map (
    id int(11) unsigned NOT NULL auto_increment,
    type tinyint(3) unsigned NOT NULL default '0',
    aid int(11) unsigned NOT NULL default '0',
    tid int(11) unsigned NOT NULL default '0',
    pid int(11) unsigned NOT NULL default '0',
    fileID bigint(20) unsigned NOT NULL default '0',
    filename varchar(255) NOT NULL default '',
    etag char(32) NOT NULL default '',
    size bigint(20) unsigned NOT NULL default '0',
    create_date int(11) unsigned NOT NULL default '0',
    update_date int(11) unsigned NOT NULL default '0',
    PRIMARY KEY (id),
    KEY (aid),
    KEY (tid),
    KEY (pid),
    KEY (fileID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

db_exec($sql);

// 异步任务队列
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

// 默认配置
$default = array(
    'clientID' => '',
    'clientSecret' => '',
    'parentFileID_image' => 0,
    'parentFileID_text' => 0,
    'parentFileID_video' => 0,
    'duplicate' => 1,
    'enable_image_backup' => 1,
    'enable_text_backup' => 0,
    'enable_video_upload' => 1,
    'auto_share_video' => 1,
    'shareExpire' => 0,
    'sharePwd' => '',
    'enable_direct_link' => 0,
    'direct_link_uid' => 0,
    'direct_link_primary_key' => '',
    'direct_link_expire_sec' => 300,
    'queue_enable' => 1,
    'queue_max_retries' => 5,
    'queue_retry_base_sec' => 60,
    'queue_running_timeout' => 900
);

setting_set('pan123_storage', $default);

?>
