<?php
!defined('DEBUG') and exit('Access Denied.');
/* 【开始】金桔框架——常量定义 */
//如果网站在子目录下，这个很有必要
$BASE_URL = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$BASE_URL = empty($BASE_URL) ? '/' : '/' . trim($BASE_URL, '/') . '/';
$HTTP_TYPE = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
//网站的URL
define('WEBSITE_DIR', $_SERVER["HTTP_HOST"] . $BASE_URL);
//这个插件的文件夹URL
define('PLUGIN_DIR', 'plugin/' . param(2) . '/');
//这个插件的view文件夹URL
define('PLUGIN_VIEW_DIR', WEBSITE_DIR . PLUGIN_DIR . "view/");
//插件ID
define('PLUGIN_NAME', param(2));
//插件的conf.json文件
$plugin_profile_file = file_get_contents(APP_PATH . PLUGIN_DIR . 'conf.json');
if (substr($plugin_profile_file, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
    $plugin_profile_file = substr($plugin_profile_file, 3);
}
//插件的conf
$PLUGIN_PROFILE = json_decode($plugin_profile_file, true);
//插件设置
$PLUGIN_SETTING = setting_get(PLUGIN_NAME . '_setting');
//金桔框架的位置
$kumquat_location = APP_PATH . PLUGIN_DIR . '/inc/';
//导入框架所需文件
include_once($kumquat_location . 'kumquat_utility.func.php');
include_once($kumquat_location . 'kumquat_core.func.php');
include_once($kumquat_location . 'kumquat_form.func.php');
include_once(APP_PATH . PLUGIN_DIR . 'conf.php');
//kumquat_init(PLUGIN_NAME);
/* 【结束】金桔框架——常量定义 */
$extra_message = '';
ini_set('memory_limit', '512M');
if ($method == 'GET') {
	//var_dump($data);
	//var_dump($PLUGIN_SETTING);
	//var_dump(group_list_cache());
	if (empty($PLUGIN_SETTING['THIS_LOCATION_FRONTEND'])) {
		$PLUGIN_SETTING['THIS_LOCATION_FRONTEND'] = 'plugin/abs_theme_stately/';
	}
	if (empty($PLUGIN_SETTING['THIS_LOCATION'])) {
		$PLUGIN_SETTING['THIS_LOCATION'] = 'plugin/abs_theme_stately/';
	}
	//echo serialize($PLUGIN_SETTING);
	include _include(APP_PATH . PLUGIN_DIR . 'setting.htm');
} else {
	if (function_exists("xn_nav_menu_slot_add")) {
		if (!xn_nav_menu_get('bbspage')) {
			xn_nav_menu_slot_add('bbspage', array(
				array('lid' => 1, 'icon' => 'la la-comments', 'name' => '全部板块', 'desc' => '', 'href' => '__forumlist_section__', 'order' => 0, 'class' => '', 'submenu' => '',),
				array('lid' => 2, 'icon' => 'la la-comments-o', 'name' => '默认分类|1,2,3', 'desc' => '默认分类介绍', 'href' => '__forumlist_section__', 'order' => 0, 'class' => '', 'submenu' => '',),
			));
			$extra_message .= '【Stately】BBS主页 菜单栏位创建成功 ';
		}
		if (!xn_nav_menu_get('portalpage')) {
			xn_nav_menu_slot_add('portalpage', array(
				array('lid' => 1, 'icon' => 'la la-comments', 'name' => '0', 'desc' => '', 'href' => '__portal_section__', 'order' => 0, 'class' => '', 'attr' => '1', 'submenu' => '',),
				array('lid' => 2, 'icon' => 'la la-comments-o', 'name' => '1', 'desc' => '默认分类介绍', 'href' => '__portal_section__', 'order' => 0, 'class' => '', 'attr' => '2', 'submenu' => '',),
				array('lid' => 3, 'icon' => 'la la-comments-o', 'name' => '2', 'desc' => '', 'href' => '__portal_section__', 'order' => 0, 'class' => '', 'attr' => '2', 'submenu' => '',),
			));
			$extra_message .= '【Stately】门户主页 菜单栏位创建成功 ';
		}
		if (!xn_nav_menu_get('appbar_menu')) {
			xn_nav_menu_slot_add('appbar_menu', array(
				array('lid' => 1, 'icon' => 'la la-home', 'name' => '首页', 'title' => '', 'href' => '.', 'order' => 10, 'class' => '', 'attr' => 'data-active=fid-0', 'submenu' => ''),
				array('lid' => 2, 'icon' => 'la la-comments-o', 'name' => '分类', 'title' => '', 'href' => 'bbs.htm', 'order' => 20, 'class' => '', 'attr' => "data-toggle='modal' data-target='#forum'", 'submenu' => ''),
				array('lid' => 3, 'icon' => 'la la-plus', 'name' => '', 'title' => '发帖', 'href' => '__btn_thread_new__', 'order' => 30, 'class' => ' px-3 py-1 rounded-3 bg-gradient', 'submenu' => ''),
				array('lid' => 4, 'icon' => 'la la-plus', 'name' => '', 'title' => '登录', 'href' => '__stately_login_modal__', 'order' => 19, 'class' => ' px-3 py-1 rounded-3 bg-gradient', 'submenu' => ''),
				array('lid' => 5, 'icon' => 'la la-bell-o', 'name' => '消息', 'title' => '', 'href' => '__stately_notice_modal__', 'order' => 40, 'class' => '', 'submenu' => ''),
				array('lid' => 6, 'icon' => 'la la-user', 'name' => '我', 'title' => '', 'href' => 'my.htm', 'order' => 50, 'class' => '', 'attr' => 'data-active=menu-my', 'submenu' => ''),
			));
			$extra_message .= '【Stately】App底部栏 菜单栏位创建成功 ';
		}
		if (!xn_nav_menu_get('stately_contextmenu__normal')) {
			xn_nav_menu_slot_add('stately_contextmenu__normal', array(
				array('lid' => 1, 'icon' => 'las la-file', 'name' => '关于本站', 'desc' => '', 'href' => url('about_us'), 'order' => 10, 'class' => '', 'attr' => '', 'submenu' => '',),
				array('lid' => 2, 'icon' => 'las la-file', 'name' => '本站规则', 'desc' => '', 'href' => url('terms'), 'order' => 20, 'class' => '', 'attr' => '', 'submenu' => '',),
				array('lid' => 3, 'icon' => 'las la-file', 'name' => '隐私政策', 'desc' => '', 'href' => url('privacy'), 'order' => 30, 'class' => '', 'attr' => '', 'submenu' => '',),
				array('lid' => 4, 'icon' => 'las la-file', 'name' => '联系我们', 'desc' => '', 'href' => url('contact_us'), 'order' => 40, 'class' => '', 'attr' => '', 'submenu' => '',),
			));
			$extra_message .= '【Stately】右键菜单自定义链接 菜单栏位创建成功 ';
		}
	}



	($data['kumquat_config']['allow_reset_settings'] && param('kumquat_flag/reset_settings'))
		? setting_set(PLUGIN_NAME . '_setting', kumquat_reset_setting($data))
		: setting_set(PLUGIN_NAME . '_setting', kumquat_save_setting($data));
	message(0, lang('modify_successfully') . $extra_message);
}
