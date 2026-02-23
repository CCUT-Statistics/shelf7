<?php


!defined('DEBUG') and exit('Access Denied.');

$setting = setting_get('till_user_deprecated_setting');

$the_usergroups = arrlist_key_values($grouplist, 'gid', 'name');


function kumquat_form_checkbox($name, $value, $checked = 0, $txt = '') {
	$add = $checked ? ' checked="checked"' : '';
	$s = "<label class=\"custom-input custom-checkbox mr-4\"><input type=\"checkbox\" name=\"$name\" value=\"$value\" $add /> $txt</label>";
	return $s;
}

function kumquat_form_multi_checkbox($name, $arr, $checked = array()) {
	$s = '';
	foreach ($arr as $value => $text) {
		$ischecked = in_array($value, $checked);
		$s .= kumquat_form_checkbox($name, $value, $ischecked, $text);
	}
	return $s;
}

if ($method == 'GET') {

	$input = array();
	$input['usergroup_allowed'] = kumquat_form_multi_checkbox('usergroup_allowed[]', $the_usergroups, $setting['usergroup_allowed']);
	$input['display_posts_after_deprecate'] = form_radio_yes_no('display_posts_after_deprecate', $setting['display_posts_after_deprecate']);
	$input['delete_account_directly'] = form_radio_yes_no('delete_account_directly', $setting['delete_account_directly']);

	include _include(APP_PATH . 'plugin/till_user_deprecated/setting.htm');
} else {

	$setting['usergroup_allowed'] = param('usergroup_allowed', array());

	$setting['display_posts_after_deprecate'] = param('display_posts_after_deprecate', '', FALSE);
	$setting['delete_account_directly'] = param('delete_account_directly', '', FALSE);

	setting_set('till_user_deprecated_setting', $setting);

	message(0, '修改成功');
}