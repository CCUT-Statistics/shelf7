<?php

!defined('DEBUG') AND exit('Access Denied.');

$setting = setting_get('till_thread_cover_setting');

if($method == 'GET') {
	
	$input = array();
	$input['max_size_mb'] = form_text('max_size_mb', $setting['max_size_mb']);
	$input['show_on_thread_page'] = form_radio_yes_no('show_on_thread_page', $setting['show_on_thread_page']);
	$input['use_preset_css'] = form_radio_yes_no('use_preset_css', $setting['use_preset_css']);
	
	include _include(APP_PATH.'plugin/till_thread_cover/setting.htm');
	
} else {

	$setting['max_size_mb'] = intval(param('max_size_mb', 2));
	$setting['show_on_thread_page'] = param('show_on_thread_page', true);
	$setting['use_preset_css'] = param('use_preset_css', true);
	
	setting_set('till_thread_cover_setting', $setting);
	
	message(0, '修改成功');
}
	
?>