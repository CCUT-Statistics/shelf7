<?php
!defined('DEBUG') AND exit('Access Denied.');

$till_quick_at_setting = setting_get('till_quick_at_setting');

if($method == 'GET') {
	
	$input = array();
	$input['compatible_with_haya_post_info'] = form_radio_yes_no('compatible_with_haya_post_info', $till_quick_at_setting['compatible_with_haya_post_info']);
	$input['use_cache'] = form_radio_yes_no('use_cache', $till_quick_at_setting['use_cache']);

	
	include _include(APP_PATH.'plugin/till_quick_at/setting.htm');
	
} else {

	$till_quick_at_setting['compatible_with_haya_post_info'] = param('compatible_with_haya_post_info', false);
	$till_quick_at_setting['use_cache'] = param('use_cache', true);
	
	setting_set('till_quick_at_setting', $till_quick_at_setting);
	
	message(0, '修改成功');
}
	
?>