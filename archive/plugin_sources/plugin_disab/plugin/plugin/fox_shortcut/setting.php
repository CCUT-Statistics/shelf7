<?php
/*
 * 奇狐插件 配置文件
 * QQ:77798085
 */
!defined('DEBUG') AND exit('Access Denied.');
if ($method == 'GET') {
    plugin_init();
    $pluginlist = !empty($plugins) ? $plugins : array();
    $fox_shortcut_kv = kv_get('fox_shortcut');
    $odd_shortcut = !empty($fox_shortcut_kv['odd_shortcut']) ? $fox_shortcut_kv['odd_shortcut'] : array();
    $odd_shortcut_checked = array();
    foreach ($odd_shortcut as $dir) {
        $odd_shortcut_checked[$dir] = $dir;
    }
    include _include(APP_PATH . 'plugin/fox_shortcut/fox/fox_setting.php');
} else {
    $output = array();
    $output['odd_shortcut'] = param('odd_shortcut', array());
    kv_cache_set('fox_shortcut', $output);
    message(0, '设置成功');
}?>