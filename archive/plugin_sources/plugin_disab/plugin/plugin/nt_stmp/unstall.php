<?php
/*
 * STMP修复 卸载文件
 * QQ:1509744847
 */

!defined('DEBUG') AND exit('Forbidden');

$modelfilepath = APP_PATH . 'xiunophp/xn_send_mail.func.php';
$modelbackname = file_backname($modelfilepath);

// 还原备份
if(is_file($modelbackname)){
    $r = file_backup_restore($modelfilepath);
    $r == FALSE AND message(-1, '还原model文件失败');
}

//清空缓存
cache_truncate();
$runtime = NULL;
rmdir_recusive($conf['tmp_path'], 1);
?>