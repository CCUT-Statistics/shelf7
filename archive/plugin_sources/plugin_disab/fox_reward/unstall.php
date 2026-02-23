<?php
/*
 * 奇狐插件 卸载文件
 * QQ:77798085
 */

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;

$sql = "ALTER TABLE `{$tablepre}forum` DROP COLUMN `is_reward`;";
db_exec($sql);

$sql = "DROP TABLE `{$tablepre}fox_rewardlog`;";
db_exec($sql);

kv_cache_delete('fox_reward');
?>