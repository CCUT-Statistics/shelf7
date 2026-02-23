<?php

/*
	Xiuno BBS 4.0 插件实例：广告插件设置
	admin/plugin-setting-till_user_cover.htm
*/

!defined('DEBUG') and exit('Access Denied.');

$setting = setting_get('till_user_cover_setting');

if ($method == 'GET') {

	$input = array();
	$input['allow_frontend_update'] = form_radio_yes_no('allow_frontend_update', $setting['allow_frontend_update']);
	$input['allow_custom_cover_url'] = form_radio_yes_no('allow_custom_cover_url', $setting['allow_custom_cover_url']);

	include _include(APP_PATH . 'plugin/till_user_cover/setting.htm');
} else {

	$setting['allow_frontend_update'] = param('allow_frontend_update', false);
	$setting['allow_custom_cover_url'] = param('allow_custom_cover_url', false);

	setting_set('till_user_cover_setting', $setting);

	message(0, '修改成功');
}