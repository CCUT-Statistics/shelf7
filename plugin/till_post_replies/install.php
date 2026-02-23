<?php

!defined('DEBUG') and exit('Forbidden');

$tablepre = $db->tablepre;

$sql = "ALTER TABLE {$tablepre}post ADD COLUMN `repeat_follow` LONGTEXT NOT NULL, ADD COLUMN `r_f_c` SMALLINT(6) UNSIGNED DEFAULT 0 NOT NULL, ADD COLUMN `r_f_a` SMALLINT(6) UNSIGNED DEFAULT 0 NOT NULL";
$r = db_exec($sql);
$r === FALSE and message(-1, '创建表结构失败');

$setting = setting_get('till_post_replies_setting');
if (empty($setting)) {
	$setting = array(
		'replies_per_page' => 10,
		'max_reply_length' => 4096,
		'collapse_open_by_default' => true,
	);
	setting_set('till_post_replies_setting', $setting);
}
