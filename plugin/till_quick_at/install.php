<?php


!defined('DEBUG') AND exit('Forbidden');

$till_quick_at_setting = setting_get('till_quick_at_setting');
if(empty($setting)) {
	$till_quick_at_setting = array(
		'compatible_with_haya_post_info'=>false,
		'use_cache' => true,
	);
	setting_set('till_quick_at_setting', $till_quick_at_setting);
}

?>