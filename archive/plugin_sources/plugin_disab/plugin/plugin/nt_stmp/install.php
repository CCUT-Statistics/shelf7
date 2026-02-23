<?php
/*
 * STMP修复 安装文件
 * QQ:1509744847
 */

!defined('DEBUG') AND exit('Forbidden');

$modelfilepath = APP_PATH . 'xiunophp/xn_send_mail.func.php';
$modelbackname = file_backname($modelfilepath);

if(!is_file($modelbackname)){
    // 备份文件
    $r = file_backup($modelfilepath);
    $r == FALSE AND message(-1, '备份文件失败');
    
    // 替换xn_send_mail.func.php
    $fox_modelfilepath = APP_PATH . 'plugin/nt_stmp/model/xn_send_mail.func.php';
    $r = xn_copy($fox_modelfilepath, $modelfilepath);
    $r == FALSE AND message(-1, '替换model文件失败');
}

//清空缓存
cache_truncate();
$runtime = NULL;
rmdir_recusive($conf['tmp_path'], 1);
?>
