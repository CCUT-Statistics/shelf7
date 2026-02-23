<?php

defined('DEBUG') OR exit('Forbidden');
$tablepre = $db->tablepre;
db_exec("ALTER TABLE `{$tablepre}thread` ADD COLUMN `cover` varchar(2048) NOT NULL DEFAULT '' COMMENT '封面图网址'");
$setting = array(
    'max_size_mb' => 2,
    'show_on_thread_page' => true,
    'use_preset_css' => true,
);
setting_set('till_thread_cover_setting', $setting);
?>