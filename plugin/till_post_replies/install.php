<?php

!defined('DEBUG') and exit('Forbidden');

$tablepre = $db->tablepre;

if (!function_exists('till_post_replies_column_exists')) {
	function till_post_replies_column_exists($table, $column)
	{
		$r = db_sql_find_one("SHOW COLUMNS FROM `$table` LIKE '$column'");
		return !empty($r);
	}
}

$post_table = $tablepre . 'post';
$alter_parts = array();

if (!till_post_replies_column_exists($post_table, 'repeat_follow')) {
	$alter_parts[] = "ADD COLUMN `repeat_follow` LONGTEXT NOT NULL";
}
if (!till_post_replies_column_exists($post_table, 'r_f_c')) {
	$alter_parts[] = "ADD COLUMN `r_f_c` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0";
}
if (!till_post_replies_column_exists($post_table, 'r_f_a')) {
	$alter_parts[] = "ADD COLUMN `r_f_a` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0";
}

if (!empty($alter_parts)) {
	$sql = "ALTER TABLE `$post_table` " . implode(', ', $alter_parts);
	$r = db_exec($sql);
	$r === FALSE and message(-1, '创建表结构失败');
}

$setting = setting_get('till_post_replies_setting');
if (empty($setting)) {
	$setting = array(
		'replies_per_page' => 10,
		'max_reply_length' => 4096,
		'collapse_open_by_default' => true,
	);
	setting_set('till_post_replies_setting', $setting);
}
