<?php

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;

function xn_mod_enhance_upgrade_column_exists($table, $column) {
	$table = addslashes($table);
	$column = addslashes($column);
	$r = db_sql_find_one("SHOW COLUMNS FROM `$table` LIKE '$column'");
	return !empty($r);
}

function xn_mod_enhance_upgrade_table_exists($table) {
	$table = addslashes($table);
	$r = db_sql_find_one("SHOW TABLES LIKE '$table'");
	return !empty($r);
}

$post_table = "{$tablepre}post";
$log_table = "{$tablepre}post_update_log";

if(!xn_mod_enhance_upgrade_column_exists($post_table, 'last_update_date')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN last_update_date int(10) unsigned NOT NULL default '0'");
}
if(!xn_mod_enhance_upgrade_column_exists($post_table, 'last_update_uid')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN last_update_uid int(10) unsigned NOT NULL default '0'");
}
if(!xn_mod_enhance_upgrade_column_exists($post_table, 'last_update_reason')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN last_update_reason varchar(128) NOT NULL default ''");
}
if(!xn_mod_enhance_upgrade_column_exists($post_table, 'updates')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN updates int(10) unsigned NOT NULL default '0'");
}

if(xn_mod_enhance_upgrade_table_exists($log_table) && !xn_mod_enhance_upgrade_column_exists($log_table, 'reason')) {
	db_exec("ALTER TABLE `$log_table` ADD COLUMN reason varchar(128) NOT NULL DEFAULT ''");
}

?>