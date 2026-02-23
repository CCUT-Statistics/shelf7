<?php exit;
plugin_init();
$pluginlist = !empty($plugins) ? $plugins : array();
$fox_shortcut_kv = kv_get('fox_shortcut');
$odd_shortcut = !empty($fox_shortcut_kv['odd_shortcut']) ? $fox_shortcut_kv['odd_shortcut'] : array();
$odd_shortcut_checked = array();
foreach ($pluginlist as $dir => $plugin) {
    if (in_array($dir, $odd_shortcut)) {
        $odd_shortcut_checked[$dir] = $plugin;
    }
}
?>