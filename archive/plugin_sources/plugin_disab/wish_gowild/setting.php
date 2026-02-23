<?php
/*
	唯诚网络出品91wc.net
	技术维护QQ：1198845956
*/
!defined('DEBUG') AND exit('Access Denied.');
if($method == 'GET') {
    //展示配置数据
	$setting['wish_gowild'] = setting_get('wish_gowild');
	include _include(APP_PATH.'plugin/wish_gowild/setting.htm');
} else {
    //保存配置
    $data['main_title'] = param('wish_gowild_main_title', '', FALSE);
    $data['sub_title'] = param('wish_gowild_sub_title', '', FALSE);
    $data['btn_text'] = param('wish_gowild_btn_text', '', FALSE);
    $data['blank'] = param('wish_gowild_blank', 'no', FALSE);
    $data['safe_tips'] = param('wish_gowild_safe_tips', 'no', FALSE);
    $data['is_count'] = param('wish_gowild_is_count', 'no', FALSE);
    $data['is_count_detail'] = param('wish_gowild_is_count_detail', 'no', FALSE);
    $data['jump_now'] = param('wish_gowild_jump_now', 'no', FALSE);
    $data['add_nofollow'] = param('wish_gowild_add_nofollow', 'no', FALSE);
    $data['group'] = param('wish_gowild_group', '', FALSE);
	setting_set('wish_gowild', $data);

	message(0, '修改成功');
}
