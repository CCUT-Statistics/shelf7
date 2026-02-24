<?php

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;

function xn_mod_enhance_unstall_column_exists($table, $column) {
	$table = addslashes($table);
	$column = addslashes($column);
	$r = db_sql_find_one("SHOW COLUMNS FROM `$table` LIKE '$column'");
	return !empty($r);
}

$post_table = "{$tablepre}post";
$drop_columns = array();
foreach(array('updates', 'last_update_date', 'last_update_uid', 'last_update_reason') as $column) {
	if(xn_mod_enhance_unstall_column_exists($post_table, $column)) {
		$drop_columns[] = "DROP COLUMN `$column`";
	}
}
if(!empty($drop_columns)) {
	db_exec("ALTER TABLE `$post_table` ".implode(', ', $drop_columns));
}

db_exec("DROP TABLE IF EXISTS `{$tablepre}post_update_log`");


?>