<?php

/*
	Xiuno BBS 4.0 插件实例：TAG 插件安装
	admin/plugin-install-xn_tag.htm
*/

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;


$sql = "ALTER TABLE {$tablepre}post ADD COLUMN 
`rob_anonymous` bool NOT NULL";
$r = db_exec($sql);
//$r === FALSE AND message(-1, '创建表结构失败');
?>

