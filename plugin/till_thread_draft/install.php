<?php

!defined('DEBUG') and exit('Forbidden');

$setting = setting_get('till_thread_draft_setting');
if (empty($setting)) {
	$setting = array(
		'thread_draft_slot_count' => 5, //草稿栏位数量
		'auto_save_draft_interval' => 30, //自动保存时间
		'draft_shelf_life' => 604800, //草稿保质期，单位为秒

		'plugin_compatibility' => true, //插件兼容性；开启会保存更多数据
		'need_toast' => true, //使用吐司框提示

		'delete_all_settings_and_drafts_after_uninst' => false,
	);
	setting_set('till_thread_draft_setting', $setting);
} else {
	if (!isset($setting['draft_shelf_life'])) {
		$setting['draft_shelf_life'] = 604800;
	}
	setting_set('till_thread_draft_setting', $setting);
}