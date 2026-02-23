<?php
!defined('DEBUG') and exit('Forbidden');

//在用户表里创建一个新的字段
$tablepre = $db->tablepre;
$sql = "ALTER TABLE {$tablepre}user ADD COLUMN cover_url TEXT DEFAULT '' COMMENT '封面图网址'";
db_exec($sql);

$setting = setting_get('till_user_cover_setting');
if (empty($setting)) {
    $setting = array(
        'allow_frontend_update' => true,
        'allow_custom_cover_url' => true,
    );
    setting_set('till_user_cover_setting', $setting);
}