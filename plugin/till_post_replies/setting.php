<?php

!defined('DEBUG') AND exit('Access Denied.');

$setting = setting_get('till_post_replies_setting');

if($method == 'GET') {

	$input = array(
		'collapse_open_by_default' => form_radio_yes_no('collapse_open_by_default',$setting['collapse_open_by_default']),
	);

	include _include(APP_PATH.'plugin/till_post_replies/setting.htm');
	
} else {

	$setting['replies_per_page'] = param('replies_per_page', 1);
	$setting['max_reply_length'] = param('max_reply_length', 1);
	$setting['collapse_open_by_default'] = param('collapse_open_by_default', false);
	setting_set('till_post_replies_setting', $setting);

	message(0, '修改成功');
}
	
?>