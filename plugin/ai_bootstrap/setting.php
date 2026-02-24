<?php

!defined('DEBUG') and exit('Access Denied.');

$header['title'] = '站点启动器';

if (!function_exists('ai_bootstrap_build_state_row')) {
    function ai_bootstrap_build_state_row($dir)
    {
        global $plugins;

        $exists = isset($plugins[$dir]);
        $installed = $exists ? !empty($plugins[$dir]['installed']) : false;
        $enabled = $exists ? !empty($plugins[$dir]['enable']) : false;
        $name = $exists ? $plugins[$dir]['name'] : $dir;

        return array(
            'dir' => $dir,
            'name' => $name,
            'exists' => $exists,
            'installed' => $installed,
            'enabled' => $enabled,
        );
    }
}

if (!function_exists('ai_bootstrap_include_install_file')) {
    function ai_bootstrap_include_install_file($dir, &$errors)
    {
        $install_file = APP_PATH . "plugin/$dir/install.php";
        if (!is_file($install_file)) {
            return;
        }

        if (function_exists('plugin_guard_try_include')) {
            $ret = plugin_guard_try_include($install_file);
            if (!empty($ret['code'])) {
                $errors[] = "$dir install.php 执行失败：" . strval($ret['message']);
            }
            return;
        }

        include _include($install_file);
    }
}

if (!function_exists('ai_bootstrap_install_and_enable')) {
    function ai_bootstrap_install_and_enable($dir, &$logs, &$errors)
    {
        global $plugins;

        if (!isset($plugins[$dir])) {
            $errors[] = "缺少插件目录：$dir";
            return;
        }

        $plugin_name = $plugins[$dir]['name'];

        if (empty($plugins[$dir]['installed'])) {
            $r = plugin_install($dir);
            if (!$r) {
                $errors[] = "安装失败：$plugin_name ($dir)";
                return;
            }

            ai_bootstrap_include_install_file($dir, $errors);
            if (!empty($errors)) {
                return;
            }

            $logs[] = "已安装 $plugin_name ($dir)";
        }

        if (empty($plugins[$dir]['enable'])) {
            $r = plugin_enable($dir);
            if (!$r) {
                $errors[] = "启用失败：$plugin_name ($dir)";
                return;
            }
            $logs[] = "已启用 $plugin_name ($dir)";
        }
    }
}

$preset_groups = array(
    '基础前置（主题/菜单/通知）' => array('abs_menu', 'abs_theme_stately', 'abs_themeacp_stately', 'huux_notice'),
    '123 盘与楼中楼' => array('pan123_storage', 'till_post_replies'),
);

if ($method == 'POST') {
    $action = param('action', '');
    $confirm_word = trim(param('confirm_word', ''));
    if ($confirm_word !== 'ENABLE') {
        message(-1, jump('请输入 ENABLE 进行确认。', url('plugin-setting-ai_bootstrap'), 2));
    }

    $targets = array();
    if ($action === 'repair_prerequisites') {
        $targets = $preset_groups['基础前置（主题/菜单/通知）'];
    } elseif ($action === 'repair_pan123_stack') {
        // huux_notice 放在前面，避免后续插件潜在依赖未满足。
        $targets = array('huux_notice', 'pan123_storage', 'till_post_replies');
    } else {
        message(-1, jump('未知操作。', url('plugin-setting-ai_bootstrap'), 2));
    }

    $logs = array();
    $errors = array();

    foreach ($targets as $dir) {
        ai_bootstrap_install_and_enable($dir, $logs, $errors);
    }

    if (empty($errors) && function_exists('plugin_guard_compile_healthcheck')) {
        $compile_errors = plugin_guard_compile_healthcheck();
        if (!empty($compile_errors)) {
            if (function_exists('plugin_guard_compile_errors_to_text')) {
                $errors[] = "健康检查失败：\n" . plugin_guard_compile_errors_to_text($compile_errors);
            } else {
                $errors[] = '健康检查失败，请查看站点日志。';
            }
        }
    }

    $done_text = empty($logs) ? '无变更（目标插件已处于已安装+已启用状态）' : implode('；', $logs);
    if (!empty($errors)) {
        message(-1, jump("执行失败：\n" . implode("\n", $errors) . "\n\n已执行：$done_text", url('plugin-setting-ai_bootstrap'), 5));
    }

    message(0, jump("执行完成：$done_text", url('plugin-setting-ai_bootstrap'), 2));
}

$state_groups = array();
foreach ($preset_groups as $group_name => $dirs) {
    $rows = array();
    foreach ($dirs as $dir) {
        $rows[] = ai_bootstrap_build_state_row($dir);
    }
    $state_groups[$group_name] = $rows;
}

include _include(APP_PATH . 'plugin/ai_bootstrap/setting.htm');

