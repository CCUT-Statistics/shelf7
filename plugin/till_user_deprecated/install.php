<?php
!defined('DEBUG') and exit('Forbidden');
$tablepre = $db->tablepre;
$sql = "ALTER TABLE {$tablepre}user ADD COLUMN deprecated TINYINT(1) DEFAULT '0' COMMENT '账户停用状态'";
db_exec($sql);

$setting = setting_get('till_user_deprecated_setting');
if (empty($setting)) {
    $setting = array(
        'usergroup_allowed' => array(101, 102, 103, 104, 105),
        'display_posts_after_deprecate' => true,
        'delete_account_directly' => false
    );
    setting_set('till_user_deprecated_setting', $setting);
}