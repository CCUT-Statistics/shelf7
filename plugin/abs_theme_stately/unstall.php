<?php

/*
	金桔框架——插件卸载
	admin/plugin-unstall-PLUGIN_NAME.htm
*/

!defined('DEBUG') and exit('Forbidden');

/* 【开始】金桔框架——常量定义 */
define('PLUGIN_DIR', 'plugin/' . param(2) . '/');
define('PLUGIN_NAME', param(2));

$PLUGIN_SETTING = setting_get(PLUGIN_NAME . '_setting');

/* 【结束】金桔框架——常量定义 */

setting_delete(PLUGIN_NAME . '_setting');

message(0,'感谢您的使用，我们以后再见！');
/*
if ($PLUGIN_SETTING['kumquat_flag']['delete_plugin_settings']) {
	if (function_exists("xn_nav_menu_slot_del")) {
		xn_nav_menu_slot_del("bbspage");
		xn_nav_menu_slot_del("portalpage");
		xn_nav_menu_slot_del("appbar_menu");
	}
}
//*/