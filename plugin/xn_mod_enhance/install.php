<?php

/*
	Xiuno BBS 4.0 插件实例：编辑增强
	admin/plugin-install-xn_mod_enhance.htm
*/

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;

function xn_mod_enhance_table_exists($table) {
	$table = addslashes($table);
	$r = db_sql_find_one("SHOW TABLES LIKE '$table'");
	return !empty($r);
}

function xn_mod_enhance_column_exists($table, $column) {
	$table = addslashes($table);
	$column = addslashes($column);
	$r = db_sql_find_one("SHOW COLUMNS FROM `$table` LIKE '$column'");
	return !empty($r);
}

$post_table = "{$tablepre}post";
$log_table = "{$tablepre}post_update_log";

if(!xn_mod_enhance_column_exists($post_table, 'updates')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN updates int(10) unsigned NOT NULL default '0'");
}
if(!xn_mod_enhance_column_exists($post_table, 'last_update_date')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN last_update_date int(10) unsigned NOT NULL default '0'");
}
if(!xn_mod_enhance_column_exists($post_table, 'last_update_uid')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN last_update_uid int(10) unsigned NOT NULL default '0'");
}
if(!xn_mod_enhance_column_exists($post_table, 'last_update_reason')) {
	db_exec("ALTER TABLE `$post_table` ADD COLUMN last_update_reason varchar(128) NOT NULL default ''");
}

if(!xn_mod_enhance_table_exists($log_table)) {
	$sql = "CREATE TABLE `$log_table` (
		logid int(10) unsigned NOT NULL auto_increment,
		pid int(10) unsigned NOT NULL default '0',
		reason varchar(128) NOT NULL DEFAULT '',
		message text NOT NULL,
		create_date int(10) unsigned NOT NULL default '0',
		uid int(10) unsigned NOT NULL default '0',
		PRIMARY KEY (logid),
		KEY (pid),
		KEY (uid)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
	db_exec($sql);
} else {
	if(!xn_mod_enhance_column_exists($log_table, 'reason')) {
		db_exec("ALTER TABLE `$log_table` ADD COLUMN reason varchar(128) NOT NULL DEFAULT ''");
	}
}

?>