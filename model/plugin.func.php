<?php

 // 本地插件
//$plugin_srcfiles = array();
$plugin_paths = array();
$plugins = array(); // 跟官方插件合并

// 官方插件列表
$official_plugins = array();

// 官方插件市场已停用：保留常量避免第三方代码调用时报错。
define('PLUGIN_OFFICIAL_URL', '');

// todo: 对路径进行处理 include _include(APP_PATH.'view/htm/header.inc.htm');
$g_include_slot_kv = array();
function _include($srcfile) {
	global $conf;
	// 合并插件，存入 tmp_path
	$len = strlen(APP_PATH);
	$tmpfile = $conf['tmp_path'].substr(str_replace('/', '_', $srcfile), $len);
	if(!is_file($tmpfile) || DEBUG > 1) {
		// 开始编译
		$s = plugin_compile_srcfile($srcfile);
		
		// 支持 <template> <slot>
		$g_include_slot_kv = array();
		for($i = 0; $i < 10; $i++) {
			$s = preg_replace_callback('#<template\sinclude="(.*?)">(.*?)</template>#is', '_include_callback_1', $s);
			if(strpos($s, '<template') === FALSE) break;
		}
		file_put_contents_try($tmpfile, $s);
		
		$s = plugin_compile_srcfile($tmpfile);
		file_put_contents_try($tmpfile, $s);
		
	}
	return $tmpfile;
}

function _include_callback_1($m) {
	global $g_include_slot_kv;
	$r = file_get_contents($m[1]);
	preg_match_all('#<slot\sname="(.*?)">(.*?)</slot>#is', $m[2], $m2);
	if(!empty($m2[1])) {
		$kv = array_combine($m2[1], $m2[2]);
		$g_include_slot_kv += $kv;
		foreach($g_include_slot_kv as $slot=>$content) {
			$r = preg_replace('#<slot\sname="'.$slot.'"\s*/>#is', $content, $r);
		}
	}
	return $r;
}

// 在安装、卸载插件的时候，需要先初始化
function plugin_init() {
	global $plugin_srcfiles, $plugin_paths, $plugins, $official_plugins;
	/*$plugin_srcfiles = array_merge(
		glob(APP_PATH.'model/*.php'), 
		glob(APP_PATH.'route/*.php'), 
		glob(APP_PATH.'view/htm/*.*'), 
		glob(ADMIN_PATH.'route/*.php'), 
		glob(ADMIN_PATH.'view/htm/*.*'),
		glob(APP_PATH.'lang/en-us/*.*'),
		glob(APP_PATH.'lang/zh-cn/*.*'),
		glob(APP_PATH.'lang/zh-tw/*.*'),
		array(APP_PATH.'model.inc.php')
	);
	foreach($plugin_srcfiles as $k=>$file) {
		$filename = file_name($file);
		if(is_backfile($filename)) {
			unset($plugin_srcfiles[$k]);
		}
	}*/
	
//	$official_plugins = plugin_official_list_cache();
//	empty($official_plugins) AND $official_plugins = array();
	
	$plugin_paths = glob(APP_PATH.'plugin/*', GLOB_ONLYDIR);
	if(is_array($plugin_paths)) {
		foreach($plugin_paths as $path) {
			$dir = file_name($path);
			$conffile = $path."/conf.json";
			if(!is_file($conffile)) continue;
			$arr = xn_json_decode(file_get_contents($conffile));
			if(empty($arr)) continue;
			$plugins[$dir] = $arr;
			
			// 额外的信息
			$plugins[$dir]['hooks'] = array();
			$hookpaths = glob(APP_PATH."plugin/$dir/hook/*.*"); // path
			if(is_array($hookpaths)) {
				foreach($hookpaths as $hookpath) {
					$hookname = file_name($hookpath);
					$plugins[$dir]['hooks'][$hookname] = $hookpath;
				}
			}
			
			// 本地 + 线上数据
			$plugins[$dir] = plugin_read_by_dir($dir);
		}
	}
}

// 插件依赖检测，返回依赖的插件列表，如果返回为空则表示不依赖
/*
	返回依赖的插件数组：
	array(
		'xn_ad'=>'1.0',
		'xn_umeditor'=>'1.0',
	);
*/
function plugin_dependencies($dir) {
	global $plugin_srcfiles, $plugin_paths, $plugins;
	$plugin = $plugins[$dir];
	$dependencies = $plugin['dependencies'];
	
	// 检查插件依赖关系
	$arr = array();
	foreach($dependencies as $_dir=>$version) {
		if(!isset($plugins[$_dir]) || !$plugins[$_dir]['enable']) {
			$arr[$_dir] = $version;
		}
	}
	return $arr;
}

/*
	返回被依赖的插件数组：
	array(
		'xn_ad'=>'1.0',
		'xn_umeditor'=>'1.0',
	);
*/
function plugin_by_dependencies($dir) {
	global $plugins;
	
	$arr = array();
	foreach($plugins as $_dir=>$plugin) {
		if(isset($plugin['dependencies'][$dir]) && $plugin['enable']) {
			$arr[$_dir] = $plugin['version'];
		}
	}
	return $arr;
}

function plugin_guard_snapshot_states($dirs) {
	global $plugins;
	
	$states = array();
	foreach($dirs as $dir) {
		$conffile = APP_PATH."plugin/$dir/conf.json";
		if(!is_file($conffile)) continue;
		$conf = isset($plugins[$dir]) ? $plugins[$dir] : plugin_read_by_dir($dir);
		$states[$dir] = array(
			'installed'=>!empty($conf['installed']) ? 1 : 0,
			'enable'=>!empty($conf['enable']) ? 1 : 0
		);
	}
	return $states;
}

function plugin_guard_restore_states($states) {
	global $plugins;
	
	foreach($states as $dir=>$state) {
		$conffile = APP_PATH."plugin/$dir/conf.json";
		if(!is_file($conffile)) continue;
		$installed = intval(array_value($state, 'installed', 0));
		$enable = intval(array_value($state, 'enable', 0));
		file_replace_var($conffile, array('installed'=>$installed, 'enable'=>$enable), TRUE);
		if(isset($plugins[$dir])) {
			$plugins[$dir]['installed'] = $installed;
			$plugins[$dir]['enable'] = $enable;
		}
	}
}

function plugin_guard_enabled_dirs($include_dir = '') {
	$dirs = array();
	$plugin_paths = glob(APP_PATH.'plugin/*', GLOB_ONLYDIR);
	if(!empty($plugin_paths)) {
		foreach($plugin_paths as $path) {
			$dir = file_name($path);
			$conffile = $path.'/conf.json';
			if(!is_file($conffile)) continue;
			$pconf = xn_json_decode(file_get_contents($conffile));
			if(empty($pconf)) continue;
			if(empty($pconf['installed']) || empty($pconf['enable'])) continue;
			$dirs[] = $dir;
		}
	}
	if($include_dir && !in_array($include_dir, $dirs)) {
		$dirs[] = $include_dir;
	}
	return $dirs;
}

function plugin_guard_min_core_requirements($dir) {
	global $conf, $plugins;
	$ret = array('ok'=>TRUE, 'message'=>'');
	$plugin = isset($plugins[$dir]) ? $plugins[$dir] : plugin_read_by_dir($dir);
	$need = trim(strval(array_value($plugin, 'bbs_version', '')));
	if($need === '') return $ret;
	
	if(version_compare($conf['version'], $need, '<')) {
		$ret['ok'] = FALSE;
		$ret['message'] = "插件 $dir 需要 Xiuno >= $need，当前版本 ".$conf['version']."。";
	}
	return $ret;
}

function plugin_guard_known_order_dependencies($dir) {
	$map = array(
		'abs_theme_stately'=>array('abs_menu'),
		'abs_themeacp_stately'=>array('abs_menu', 'abs_theme_stately'),
	);
	return array_value($map, $dir, array());
}

function plugin_guard_missing_known_dependencies($dir) {
	global $plugins;
	$deps = plugin_guard_known_order_dependencies($dir);
	if(empty($deps)) return array();
	
	$missing = array();
	foreach($deps as $dep) {
		$conffile = APP_PATH."plugin/$dep/conf.json";
		if(!is_file($conffile)) {
			$missing[] = $dep;
			continue;
		}
		$p = isset($plugins[$dep]) ? $plugins[$dep] : plugin_read_by_dir($dep);
		if(empty($p['installed']) || empty($p['enable'])) {
			$missing[] = $dep;
		}
	}
	return $missing;
}

function plugin_guard_route_case_labels($dir) {
	$file = APP_PATH."plugin/$dir/hook/index_route_case_end.php";
	if(!is_file($file)) return array();
	$txt = file_get_contents($file);
	if($txt === FALSE || $txt === '') return array();
	
	$matches = array();
	preg_match_all('/\bcase\s+[\'"]([^\'"]+)[\'"]\s*:/i', $txt, $matches);
	return !empty($matches[1]) ? $matches[1] : array();
}

function plugin_guard_route_case_conflicts($dir) {
	$dirs = plugin_guard_enabled_dirs($dir);
	if(empty($dirs)) return array();
	
	$owners = array();
	foreach($dirs as $_dir) {
		$labels = plugin_guard_route_case_labels($_dir);
		foreach($labels as $label) {
			!isset($owners[$label]) && $owners[$label] = array();
			if(!in_array($_dir, $owners[$label])) {
				$owners[$label][] = $_dir;
			}
		}
	}
	
	$dup = array();
	foreach($owners as $label=>$arr) {
		if(count($arr) > 1 && in_array($dir, $arr)) {
			$dup[$label] = $arr;
		}
	}
	return $dup;
}

function plugin_guard_hook_dom_ids($dir, $hookname) {
	$file = APP_PATH."plugin/$dir/hook/$hookname";
	if(!is_file($file)) return array();
	$txt = file_get_contents($file);
	if($txt === FALSE || $txt === '') return array();
	
	$matches = array();
	preg_match_all('/\bid\s*=\s*[\'"]([A-Za-z0-9_\-:]+)[\'"]/i', $txt, $matches);
	if(empty($matches[1])) return array();
	return array_values(array_unique($matches[1]));
}

function plugin_guard_dom_id_conflicts($dir, $hooknames = array('post_js.htm', 'thread_js.htm')) {
	$dirs = plugin_guard_enabled_dirs($dir);
	if(empty($dirs)) return array();
	
	$ret = array();
	foreach($hooknames as $hookname) {
		$owners = array();
		foreach($dirs as $_dir) {
			$ids = plugin_guard_hook_dom_ids($_dir, $hookname);
			foreach($ids as $id) {
				!isset($owners[$id]) && $owners[$id] = array();
				if(!in_array($_dir, $owners[$id])) {
					$owners[$id][] = $_dir;
				}
			}
		}
		$dup = array();
		foreach($owners as $id=>$arr) {
			if(count($arr) > 1 && in_array($dir, $arr)) {
				$dup[$id] = $arr;
			}
		}
		if(!empty($dup)) {
			$ret[$hookname] = $dup;
		}
	}
	return $ret;
}

function plugin_guard_recursive_files($dir) {
	$files = array();
	if(!is_dir($dir)) return $files;
	$arr = scandir($dir);
	if(empty($arr)) return $files;
	foreach($arr as $name) {
		if($name == '.' || $name == '..') continue;
		$path = "$dir/$name";
		if(is_dir($path)) {
			$files = array_merge($files, plugin_guard_recursive_files($path));
		} elseif(is_file($path)) {
			$files[] = $path;
		}
	}
	return $files;
}

function plugin_guard_overwrite_targets($dir) {
	global $plugins;
	$targets = array();
	$root = APP_PATH."plugin/$dir/overwrite";
	if(!is_dir($root)) return $targets;
	
	$conf = isset($plugins[$dir]) ? $plugins[$dir] : plugin_read_by_dir($dir);
	$ranks = !empty($conf['overwrites_rank']) ? $conf['overwrites_rank'] : array();
	$files = plugin_guard_recursive_files($root);
	$root = str_replace('\\', '/', $root);
	$rootlen = strlen($root) + 1;
	foreach($files as $file) {
		$file = str_replace('\\', '/', $file);
		if(strlen($file) <= $rootlen) continue;
		$target = substr($file, $rootlen);
		$targets[$target] = intval(array_value($ranks, $target, 0));
	}
	return $targets;
}

function plugin_guard_overwrite_conflicts($dir) {
	$ret = array('hard'=>array(), 'warn'=>array());
	$self_targets = plugin_guard_overwrite_targets($dir);
	if(empty($self_targets)) return $ret;
	
	$dirs = plugin_guard_enabled_dirs();
	foreach($dirs as $_dir) {
		if($_dir == $dir) continue;
		$peer_targets = plugin_guard_overwrite_targets($_dir);
		if(empty($peer_targets)) continue;
		foreach($self_targets as $target=>$self_rank) {
			if(!isset($peer_targets[$target])) continue;
			$peer_rank = intval($peer_targets[$target]);
			$line = "$target: $dir(rank:$self_rank) vs $_dir(rank:$peer_rank)";
			if($self_rank == $peer_rank) {
				$ret['hard'][] = $line;
			} else {
				$ret['warn'][] = $line;
			}
		}
	}
	$ret['hard'] = array_values(array_unique($ret['hard']));
	$ret['warn'] = array_values(array_unique($ret['warn']));
	return $ret;
}

function plugin_guard_php_syntax_check($php, &$errstr = '') {
	if($php === FALSE || $php === '') {
		$errstr = 'empty source';
		return FALSE;
	}
	try {
		defined('TOKEN_PARSE') ? token_get_all($php, TOKEN_PARSE) : token_get_all($php);
		return TRUE;
	} catch(Throwable $e) {
		$errstr = $e->getMessage();
		return FALSE;
	}
}

function plugin_guard_compile_healthcheck($srcfiles = array()) {
	if(empty($srcfiles)) {
		$srcfiles = array(
			APP_PATH.'model.inc.php',
			APP_PATH.'index.inc.php',
			APP_PATH.'route/index.php',
			APP_PATH.'route/thread.php',
			APP_PATH.'route/post.php',
			ADMIN_PATH.'index.inc.php'
		);
	}
	
	$errors = array();
	foreach($srcfiles as $srcfile) {
		if(!is_file($srcfile)) continue;
		$compiled = _include($srcfile);
		if(!is_file($compiled)) {
			$errors[] = array('srcfile'=>$srcfile, 'error'=>'compiled file missing');
			continue;
		}
		$php = file_get_contents($compiled);
		$errstr = '';
		if(!plugin_guard_php_syntax_check($php, $errstr)) {
			$errors[] = array('srcfile'=>$srcfile, 'compiled'=>$compiled, 'error'=>$errstr);
		}
	}
	return $errors;
}

function plugin_guard_compile_errors_to_text($errors) {
	$lines = array();
	foreach($errors as $err) {
		$srcfile = array_value($err, 'srcfile', '');
		$errmsg = array_value($err, 'error', 'unknown error');
		$lines[] = basename($srcfile).': '.$errmsg;
	}
	return implode("\n", $lines);
}

function plugin_guard_try_include($srcfile) {
	$ret = array('code'=>0, 'message'=>'');
	if(!is_file($srcfile)) return $ret;
	
	try {
		include _include($srcfile);
	} catch(Throwable $e) {
		$ret['code'] = -1;
		$ret['message'] = $e->getMessage();
	}
	return $ret;
}

function plugin_guard_preflight($dir) {
	$ret = array('code'=>0, 'message'=>'', 'warnings'=>array());
	$errors = array();
	
	$ver = plugin_guard_min_core_requirements($dir);
	if(!$ver['ok']) {
		$errors[] = $ver['message'];
	}
	
	$missing_known = plugin_guard_missing_known_dependencies($dir);
	if(!empty($missing_known)) {
		$errors[] = "安装顺序不满足：".implode(', ', $missing_known)." 需先安装并启用。";
	}
	
	$route_dup = plugin_guard_route_case_conflicts($dir);
	if(!empty($route_dup)) {
		$lines = array();
		foreach($route_dup as $case=>$arr) {
			$lines[] = "case '$case' => ".implode(', ', $arr);
		}
		$errors[] = "路由 hook 冲突（index_route_case_end.php）：\n".implode("\n", $lines);
	}
	
	$dom_dup = plugin_guard_dom_id_conflicts($dir);
	if(!empty($dom_dup)) {
		$lines = array();
		foreach($dom_dup as $hookname=>$map) {
			foreach($map as $id=>$arr) {
				$lines[] = "$hookname: #$id => ".implode(', ', $arr);
			}
		}
		$errors[] = "前端 DOM id 冲突（可能导致按钮/显示异常）：\n".implode("\n", $lines);
	}
	
	$overwrite_conflicts = plugin_guard_overwrite_conflicts($dir);
	if(!empty($overwrite_conflicts['hard'])) {
		$errors[] = "overwrite 同 rank 冲突（不可自动判定覆盖顺序）：\n".implode("\n", $overwrite_conflicts['hard']);
	}
	if(!empty($overwrite_conflicts['warn'])) {
		$ret['warnings'][] = "overwrite 覆盖风险：\n".implode("\n", $overwrite_conflicts['warn']);
	}
	
	if(!empty($errors)) {
		$ret['code'] = -1;
		$ret['message'] = implode("\n\n", $errors);
	}
	return $ret;
}

function plugin_enable($dir) {
	global $plugins;
	
	if(!isset($plugins[$dir])) {
		return FALSE;
	}
	
	$plugins[$dir]['enable'] = 1;
	
	//plugin_overwrite($dir, 'install');
	//plugin_hook($dir, 'install');
	
	file_replace_var(APP_PATH."plugin/$dir/conf.json", array('enable'=>1), TRUE);
	
	plugin_clear_tmp_dir();
	
	return TRUE;
}

// 清空插件的临时目录
function plugin_clear_tmp_dir() {
	global $conf;
	rmdir_recusive($conf['tmp_path'], TRUE);
	xn_unlink($conf['tmp_path'].'model.min.php');
}

function plugin_disable($dir) {
	global $plugins;
	
	if(!isset($plugins[$dir])) {
		return FALSE;
	}
	
	$plugins[$dir]['enable'] = 0;
	
	//plugin_overwrite($dir, 'unstall');
	//plugin_hook($dir, 'unstall');
	
	file_replace_var(APP_PATH."plugin/$dir/conf.json", array('enable'=>0), TRUE);
	
	plugin_clear_tmp_dir();
	
	return TRUE;
}

// 安装所有的本地插件
function plugin_install_all() {
	global $plugins;
	
	// 检查文件更新
	foreach ($plugins as $dir=>$plugin) {
		plugin_install($dir);
	}
}

// 卸载所有的本地插件
function plugin_unstall_all() {
	global $plugins;
	
	// 检查文件更新
	foreach ($plugins as $dir=>$plugin) {
		plugin_unstall($dir);
	}
}
/*
	插件安装：
		把所有的插件点合并，重新写入文件。如果没有备份文件，则备份一份。
		插件名可以为源文件名：view/header.htm
*/
function plugin_install($dir) {
	global $plugins, $conf;
	
	if(!isset($plugins[$dir])) {
		return FALSE;
	}
	
	$plugins[$dir]['installed'] = 1;
	$plugins[$dir]['enable'] = 1;
	
	// 1. 直接覆盖的方式
	//plugin_overwrite($dir, 'install');
	
	// 2. 钩子的方式
	//plugin_hook($dir, 'install');
	
	// 写入配置文件
	file_replace_var(APP_PATH."plugin/$dir/conf.json", array('installed'=>1, 'enable'=>1), TRUE);
	
	plugin_clear_tmp_dir();
	
	return TRUE;
}

// copy from plugin_install 修改
function plugin_unstall($dir) {
	global $plugins;
	
	if(!isset($plugins[$dir])) {
		return TRUE;
	}
	
	$plugins[$dir]['installed'] = 0;
	$plugins[$dir]['enable'] = 0;
	
	// 1. 直接覆盖的方式
	//plugin_overwrite($dir, 'unstall');
	
	// 2. 钩子的方式
	//plugin_hook($dir, 'unstall');
	
	// 写入配置文件
	file_replace_var(APP_PATH."plugin/$dir/conf.json", array('installed'=>0, 'enable'=>0), TRUE);
	
	plugin_clear_tmp_dir();
	
	return TRUE;
}

function plugin_paths_enabled() {
	static $return_paths;
	if(empty($return_paths)) {
		$return_paths = array();
		$plugin_paths = glob(APP_PATH.'plugin/*', GLOB_ONLYDIR);
		if(empty($plugin_paths)) return array();
		foreach($plugin_paths as $path) {
			$conffile = $path."/conf.json";
			if(!is_file($conffile)) continue;
			$pconf = xn_json_decode(file_get_contents($conffile));
			if(empty($pconf)) continue;
			if(empty($pconf['enable']) || empty($pconf['installed'])) continue;
			$return_paths[$path] = $pconf;
		}
	}
	return $return_paths;
}

// 编译源文件，把插件合并到该文件，不需要递归，执行的过程中 include _include() 自动会递归。
function plugin_compile_srcfile($srcfile) {
	global $conf;
	// 判断是否开启插件
	if(!empty($conf['disabled_plugin'])) {
		$s = file_get_contents($srcfile);
		return $s;
	}
	
	// 如果有 overwrite，则用 overwrite 替换掉
	$srcfile = plugin_find_overwrite($srcfile);
	$s = file_get_contents($srcfile);
	
	// 最多支持 10 层
	for($i = 0; $i < 10; $i++) {
		if(strpos($s, '<!--{hook') !== FALSE || strpos($s, '// hook') !== FALSE) {
			$s = preg_replace('#<!--{hook\s+(.*?)}-->#', '// hook \\1', $s);
			$s = preg_replace_callback('#//\s*hook\s+(\S+)#is', 'plugin_compile_srcfile_callback', $s);
		} else {
			break;
		}
	}
	return $s;
}


// 只返回一个权重最高的文件名
function plugin_find_overwrite($srcfile) {
	//$plugin_paths = glob(APP_PATH.'plugin/*', GLOB_ONLYDIR);
	
	$plugin_paths = plugin_paths_enabled();
	
	$len = strlen(APP_PATH);
	/*
	// 如果发现插件目录，则尝试去掉插件目录前缀，避免新建的 overwrite 目录过深。
	if(strpos($srcfile, '/plugin/') !== FALSE) {
		preg_match('#'.preg_quote(APP_PATH).'plugin/\w+/#i', $srcfile, $m);
		if(!empty($m[0])) {
			$len = strlen($m[0]);
		}
	}*/
	
	$returnfile = $srcfile;
	$maxrank = 0;
	foreach($plugin_paths as $path=>$pconf) {
		
		// 文件路径后半部分
		$dir = file_name($path);
		$filepath_half = substr($srcfile, $len);
		$overwrite_file = APP_PATH."plugin/$dir/overwrite/$filepath_half";
		if(is_file($overwrite_file)) {
			$rank = isset($pconf['overwrites_rank'][$filepath_half]) ? $pconf['overwrites_rank'][$filepath_half] : 0;
			if($rank >= $maxrank) {
				$returnfile = $overwrite_file;
				$maxrank = $rank;
			}
		}
	}
	return $returnfile;
}

function plugin_compile_srcfile_callback($m) {
	static $hooks;
	if(empty($hooks)) {
		$hooks = array();
		$plugin_paths = plugin_paths_enabled();
		
		//$plugin_paths = glob(APP_PATH.'plugin/*', GLOB_ONLYDIR);
		foreach($plugin_paths as $path=>$pconf) {
			$dir = file_name($path);
			$hookpaths = glob(APP_PATH."plugin/$dir/hook/*.*"); // path
			if(is_array($hookpaths)) {
				foreach($hookpaths as $hookpath) {
					$hookname = file_name($hookpath);
					$rank = isset($pconf['hooks_rank']["$hookname"]) ? $pconf['hooks_rank']["$hookname"] : 0;
					$hooks[$hookname][] = array('hookpath'=>$hookpath, 'rank'=>$rank);
				}
			}
		}
		foreach ($hooks as $hookname=>$arrlist) {
			$arrlist = arrlist_multisort($arrlist, 'rank', FALSE);
			$hooks[$hookname] = arrlist_values($arrlist, 'hookpath');
		}
		
	}
	
	$s = '';
	$hookname = $m[1];
	if(!empty($hooks[$hookname])) {
		$fileext = file_ext($hookname);
		foreach($hooks[$hookname] as $path) {
			$t = file_get_contents($path);
			if($fileext == 'php' && preg_match('#^\s*<\?php\s+exit;#is', $t)) {
				// 正则表达式去除兼容性比较好。
				$t = preg_replace('#^\s*<\?php\s*exit;(.*?)(?:\?>)?\s*$#is', '\\1', $t);
				
				/* 去掉首尾标签
				if(substr($t, 0, 5) == '<?php' && substr($t, -2, 2) == '?>') {
					$t = substr($t, 5, -2);		
				}
				// 去掉 exit;
				$t = preg_replace('#\s*exit;\s*#', "\r\n", $t);
				*/
			}
			$s .= $t;
		}
	}
	return $s;
}

// 先下载，购买，付费，再安装
function plugin_online_install($dir) {

}



// -------------------> 官方插件市场已停用（仅保留本地插件模式）。

// 条件满足的总数
function plugin_official_total($cond = array()) {
	return 0;
}

// 远程插件列表已关闭
function plugin_official_list($cond = array(), $orderby = array('pluginid'=>-1), $page = 1, $pagesize = 20) {
	return array();
}

function plugin_official_list_cache() {
	return array();
}

function plugin_official_read($dir) {
	return array();
}

// -------------------> 本地插件列表缓存到本地。
// 安装，卸载，禁用，更新
function plugin_read_by_dir($dir, $local_first = TRUE) {
	global $plugins;

	$local = array_value($plugins, $dir, array());
	if(empty($local)) return array();
	
	// 本地插件信息
	!isset($local['name']) && $local['name'] = '';
	!isset($local['price']) && $local['price'] = 0;
	!isset($local['brief']) && $local['brief'] = '';
	!isset($local['version']) && $local['version'] = '1.0';
	!isset($local['bbs_version']) && $local['bbs_version'] = '4.0';
	!isset($local['installed']) && $local['installed'] = 0;
	!isset($local['enable']) && $local['enable'] = 0;
	!isset($local['hooks']) && $local['hooks'] = array();
	!isset($local['hooks_rank']) && $local['hooks_rank'] = array();
	!isset($local['dependencies']) && $local['dependencies'] = array();
	
	$plugin = $local;
	
	// 关闭官方市场字段，统一写默认值，避免模板 undefined。
	$plugin['pluginid'] = 0;
	$plugin['official'] = array(
		'price'=>0,
		'version'=>$plugin['version'],
		'installs'=>0,
		'sells'=>0,
		'is_cert'=>0
	);
	$plugin['icon_url'] = "../plugin/$dir/icon.png";
	$plugin['setting_url'] = $plugin['installed'] && is_file("../plugin/$dir/setting.php") ? "plugin-setting-$dir.htm" : "";
	$plugin['downloaded'] = isset($plugins[$dir]);
	$plugin['stars_fmt'] = '';
	$plugin['user_stars_fmt'] = '';
	$plugin['is_cert_fmt'] = '<span class="text-danger">'.lang('no').'</span>';
	$plugin['have_upgrade'] = FALSE;
	$plugin['official_version'] = $plugin['version'];
	$plugin['img1_url'] = '';
	$plugin['img2_url'] = '';
	$plugin['img3_url'] = '';
	$plugin['img4_url'] = '';
	return $plugin;
}

function plugin_siteid() {
	global $conf;
	$auth_key = $conf['auth_key'];
	$siteip = _SERVER('SERVER_ADDR');
	$siteid = md5($auth_key.$siteip);
	return $siteid;
}

/*function plugin_outid($dir) {
	global $conf;
	$auth_key = $conf['auth_key'];
	$siteip = _SERVER('SERVER_ADDR')
	$outid = md5($auth_key.$siteip.$dir);
	return $outid;
}*/
?>
