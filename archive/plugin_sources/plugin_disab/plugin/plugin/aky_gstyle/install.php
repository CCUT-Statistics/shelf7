<?php
!defined('DEBUG') AND exit('Forbidden');
$tablepre = $db->tablepre;
$sql="ALTER TABLE `{$tablepre}group` ADD `colour` VARCHAR(20) NOT NULL DEFAULT 'secondary' COMMENT '背景颜色';";
db_exec($sql);
$sql="ALTER TABLE `{$tablepre}group` ADD `fcolour` VARCHAR(20) NOT NULL DEFAULT 'white' COMMENT '字体颜色';";
db_exec($sql);
$sql="ALTER TABLE `{$tablepre}group` ADD `size` int NOT NULL DEFAULT '12' COMMENT '字体大小';";\
db_exec($sql);
// 20210328 允许自定义用户名的颜色与大小
setting_set('aky_gstyle',array('usize'=>12,'ucolor'=>'grey'))
?>