<?php

!defined('DEBUG') AND exit('Access Denied.');

include XIUNOPHP_PATH.'xn_zip.func.php';

$action = param(1);

// 初始化插件变量 / init plugin var
plugin_init();

// 插件依赖的环境检查
plugin_env_check();

empty($action) AND $action = 'local';

if($action == 'local') {
	
	// 本地插件 local plugin list
	$pluginlist = $plugins;
	
	$pagination = '';
	$pugin_cate_html = '';
	
	$header['title']    = lang('local_plugin');
	$header['mobile_title'] = lang('local_plugin');
	
	
	include _include(ADMIN_PATH."view/htm/plugin_list.htm");

} elseif($action == 'official_fee' || $action == 'official_free' || $action == 'is_bought' || $action == 'download') {
	// 官方插件市场已停用，仅支持本地插件目录安装。
	message(-1, jump('官方插件市场已停用，请使用本地插件安装。', url('plugin-local'), 1));
	
} elseif($action == 'read') {

	$dir = param_word(2);
	plugin_check_exists($dir);
	$plugin = plugin_read_by_dir($dir);
	empty($plugin) AND message(-1, lang('plugin_not_exists'));
	
	$islocal = TRUE;
	$tab = 'local';
	$url = '';
	$download_url = '';
	$errmsg = '';
	
	$header['title']    = lang('plugin_detail').'-'.$plugin['name'];
	$header['mobile_title'] = $plugin['name'];
	include _include(ADMIN_PATH."view/htm/plugin_read.htm");
	
} elseif($action == 'install') {
	
	plugin_lock_start();
	
	$dir = param_word(2);
	plugin_check_exists($dir);
	$name = $plugins[$dir]['name'];
	$warnings = array();
	
	// 检查目录可写 / check directory writable
	//plugin_check_dir_is_writable();
	
	// 插件依赖检查 / check plugin dependency
	plugin_check_dependency($dir, 'install');
	
	$guard = plugin_guard_preflight($dir);
	if($guard['code'] != 0) {
		plugin_lock_end();
		message(-1, $guard['message']);
	}
	$warnings = array_merge($warnings, array_value($guard, 'warnings', array()));
	
	$backup_states = plugin_guard_snapshot_states(array($dir));
	
	// 安装插件 / install plugin
	$r = plugin_install($dir);
	if(!$r) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "插件安装失败，已回滚：$name");
	}
	
	$installfile = APP_PATH."plugin/$dir/install.php";
	$ir = plugin_guard_try_include($installfile);
	if($ir['code'] != 0) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "install.php 执行失败，已回滚：".$ir['message']);
	}
	
	$compile_errors = plugin_guard_compile_healthcheck();
	if(!empty($compile_errors)) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		$errtext = plugin_guard_compile_errors_to_text($compile_errors);
		message(-1, "插件启用后健康检查失败，已回滚：\n$errtext");
	}
	
	plugin_lock_end();

	// 只处理主题互斥，不再自动卸载“同后缀”插件，避免误伤。
	if(strpos($dir, '_theme_') !== FALSE) {
		foreach($plugins as $_dir => $_plugin) {
			if($dir == $_dir) continue;
			if(strpos($_dir, '_theme_') !== FALSE && !empty($_plugin['enable'])) {
				plugin_disable($_dir);
				$warnings[] = "已自动禁用主题插件：$_dir（主题互斥保护）";
			}
		}
	}
	
	$msg = lang('plugin_install_sucessfully', array('name'=>$name));
	if(!empty($warnings)) {
		$msg .= "\n风险提示：\n".implode("\n", $warnings);
	}
	message(0, jump($msg, http_referer(), 3));
	
} elseif($action == 'unstall') {
	
	plugin_lock_start();
	
	$dir = param_word(2);
	plugin_check_exists($dir);
	$name = $plugins[$dir]['name'];
	
	// 检查目录可写
	// plugin_check_dir_is_writable();
	
	// 插件依赖检查
	plugin_check_dependency($dir, 'unstall');
	$backup_states = plugin_guard_snapshot_states(array($dir));
	
	// 卸载插件
	$r = plugin_unstall($dir);
	if(!$r) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "插件卸载失败，已回滚：$name");
	}
	
	$unstallfile = APP_PATH."plugin/$dir/unstall.php";
	$ur = plugin_guard_try_include($unstallfile);
	if($ur['code'] != 0) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "unstall.php 执行失败，已回滚：".$ur['message']);
	}
	
	$compile_errors = plugin_guard_compile_healthcheck();
	if(!empty($compile_errors)) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		$errtext = plugin_guard_compile_errors_to_text($compile_errors);
		message(-1, "插件卸载后健康检查失败，已回滚：\n$errtext");
	}
	
	// 删除插件
	//!DEBUG && rmdir_recusive("../plugin/$dir");
	
	plugin_lock_end();
	
	$msg = lang('plugin_unstall_sucessfully', array('name'=>$name, 'dir'=>"plugin/$dir"));
	message(0, jump($msg, http_referer(), 5));
	
} elseif($action == 'enable') {
	
	plugin_lock_start();
	
	$dir = param_word(2);
	plugin_check_exists($dir);
	$name = $plugins[$dir]['name'];
	$warnings = array();
	
	// 检查目录可写
	//plugin_check_dir_is_writable();
	
	// 插件依赖检查
	plugin_check_dependency($dir, 'install');
	
	$guard = plugin_guard_preflight($dir);
	if($guard['code'] != 0) {
		plugin_lock_end();
		message(-1, $guard['message']);
	}
	$warnings = array_merge($warnings, array_value($guard, 'warnings', array()));
	$backup_states = plugin_guard_snapshot_states(array($dir));
	
	// 启用插件
	$r = plugin_enable($dir);
	if(!$r) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "插件启用失败，已回滚：$name");
	}
	
	$compile_errors = plugin_guard_compile_healthcheck();
	if(!empty($compile_errors)) {
		plugin_guard_restore_states($backup_states);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		$errtext = plugin_guard_compile_errors_to_text($compile_errors);
		message(-1, "插件启用后健康检查失败，已回滚：\n$errtext");
	}
	
	plugin_lock_end();
	
	$msg = lang('plugin_enable_sucessfully', array('name'=>$name));
	if(!empty($warnings)) {
		$msg .= "\n风险提示：\n".implode("\n", $warnings);
	}
	message(0, jump($msg, http_referer(), 1));
	
} elseif($action == 'disable') {
	
	plugin_lock_start();
	
	$dir = param_word(2);
	plugin_check_exists($dir);
	$name = $plugins[$dir]['name'];
	
	// 检查目录可写
	//plugin_check_dir_is_writable();
	
	// 插件依赖检查
	plugin_check_dependency($dir, 'unstall');
	
	// 禁用插件
	plugin_disable($dir);
	
	plugin_lock_end();
	
	$msg = lang('plugin_disable_sucessfully', array('name'=>$name));
	message(0, jump($msg, http_referer(), 3));
	
} elseif($action == 'upgrade') {
	
	plugin_lock_start();
	
	$dir = param_word(2);
	plugin_check_exists($dir);
	$name = $plugins[$dir]['name'];
	
	// 判断插件版本
	$plugin = plugin_read_by_dir($dir);
	//!$plugin['have_upgrade'] AND message(-1, lang('plugin_not_need_update'));
	
	// 检查目录可写
	//plugin_check_dir_is_writable();
	
	// 插件依赖检查
	plugin_check_dependency($dir, 'install');
	
	$guard = plugin_guard_preflight($dir);
	if($guard['code'] != 0) {
		plugin_disable($dir);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "升级包冲突，已自动禁用插件：\n".$guard['message']);
	}
	$backup_states = plugin_guard_snapshot_states(array($dir));
	
	// 安装插件
	$r = plugin_install($dir);
	if(!$r) {
		plugin_guard_restore_states($backup_states);
		plugin_disable($dir);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "升级安装失败，已自动禁用插件：$name");
	}

	$upgradefile = APP_PATH."plugin/$dir/upgrade.php";
	$ur = plugin_guard_try_include($upgradefile);
	if($ur['code'] != 0) {
		plugin_guard_restore_states($backup_states);
		plugin_disable($dir);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		message(-1, "upgrade.php 执行失败，已自动禁用插件：".$ur['message']);
	}
	
	$compile_errors = plugin_guard_compile_healthcheck();
	if(!empty($compile_errors)) {
		plugin_guard_restore_states($backup_states);
		plugin_disable($dir);
		plugin_clear_tmp_dir();
		plugin_lock_end();
		$errtext = plugin_guard_compile_errors_to_text($compile_errors);
		message(-1, "升级后健康检查失败，已自动禁用插件：\n$errtext");
	}
	
	plugin_lock_end();
	
	$msg = lang('plugin_upgrade_sucessfully', array('name'=>$name));
	if(!empty($guard['warnings'])) {
		$msg .= "\n风险提示：\n".implode("\n", $guard['warnings']);
	}
	message(0, jump($msg, http_referer(), 3));
	
} elseif($action == 'setting') {
	
	$dir = param_word(2);
	plugin_check_exists($dir);
	$name = $plugins[$dir]['name'];
	
	include _include(APP_PATH."plugin/$dir/setting.php");
}


	

// 检查目录是否可写，插件要求 model view admin 目录文件可写。
/*
function plugin_check_dir_is_writable() {
	// 检测目录和文件可写
	$dirs = array(
		APP_PATH.'model', 
		APP_PATH.'plugin', 
		APP_PATH.'view', 
		APP_PATH.'route', 
		APP_PATH.'view/js', 
		APP_PATH.'view/htm', 
		APP_PATH.'view/css', 
		APP_PATH.'plugin', 
		ADMIN_PATH.'route', 
		ADMIN_PATH.'view/htm');
	$dirarr = array();
	foreach($dirs as $dir) {
		if(!xn_is_writable($dir)) {
			$dirarr[] = $dir;
		}
	}
	$msg = lang('plugin_set_relatied_dir_writable', array('dir'=>implode(', ', $dirarr)));
	!empty($dirarr) AND message(-1, $msg);
}*/

function plugin_check_dependency($dir, $action = 'install') {
	global $plugins;
	$name = $plugins[$dir]['name'];
	if($action == 'install') {
		$arr = plugin_dependencies($dir);
		if(!empty($arr)) {
			$s = plugin_dependency_arr_to_links($arr);
			$msg = lang('plugin_dependency_following', array('name'=>$name, 's'=>$s));
			message(-1, $msg);
		}
	} else {
		$arr = plugin_by_dependencies($dir);
		if(!empty($arr)) {
			$s = plugin_dependency_arr_to_links($arr);
			$msg = lang('plugin_being_dependent_cant_delete', array('name'=>$name, 's'=>$s));
			message(-1, $msg);
		}
	}
}

function plugin_dependency_arr_to_links($arr) {
	global $plugins;
	$s = '';
	foreach($arr as $dir=>$version) {
		//if(!isset($plugins[$dir])) continue;
		$name = isset($plugins[$dir]['name']) ? $plugins[$dir]['name'] : $dir;
		$url = url("plugin-read-$dir");
		$s .= " <a href=\"$url\">【{$name}】</a> ";
	}
	return $s;
}


// 下载插件、解压
function plugin_download_unzip($dir) {
	message(-1, '官方插件下载已停用，请手动上传插件目录后再安装。');
}

function plugin_is_bought($dir) {
	return FALSE;
}

function plugin_order_buy_qrcode_url($siteid, $dir, $app_url = '') {
	return xn_error(-1, '官方插件支付入口已停用。');
}

function plugin_is_local($dir) {
	global $plugins;
	return isset($plugins[$dir]) ? TRUE : FALSE;
}

function plugin_check_exists($dir, $local = TRUE) {
	global $plugins;
	!is_word($dir) AND message(-1, lang('plugin_name_error'));
	!isset($plugins[$dir]) AND message(-1, lang('plugin_not_exists'));
}

// bootstrap style
function plugin_cate_active($action, $plugin_cate, $cateid, $page) {
	$s = '';
	foreach ($plugin_cate as $_cateid=>$_catename) {
		$url = url("plugin-$action-$_cateid-$page");
		$s .= '<a role="button" class="btn btn btn-secondary'.($cateid == $_cateid ? ' active' : '').'" href="'.$url.'">'.$_catename.'</a>';
	}
	return $s;
}

function plugin_lock_start() {
	global $route, $action;
	!xn_lock_start($route.'_'.$action) AND message(-1, lang('plugin_task_locked'));
}

function plugin_lock_end() {
	global $route, $action;
	xn_lock_end($route.'_'.$action);
}

// 依赖
function plugin_env_check() {
	//!class_exists('ZipArchive') AND message(-1, 'ZipArchive does not exists! require PHP version > 5.2.0');
}

?>