<?php
header('Content-Type:application/manifest+json');
define('APP_PATH', dirname('../../../') . '/'); // __DIR__
!defined('XIUNOPHP_PATH') and define('XIUNOPHP_PATH', APP_PATH . 'xiunophp/');
$conf = (@include APP_PATH . 'conf/conf.php') or exit('<script>window.location="install/"</script>');
include_once XIUNOPHP_PATH . 'xiunophp.php';
include_once APP_PATH . 'model/kv.func.php';
$abs_theme_stately_setting = setting_get('abs_theme_stately_setting');

$the_manifest = [
    "name" => $conf['sitename'],
    "short_name" => $conf['sitename'],
    "description" => $conf['sitebrief'],
    "start_url" => "/", // 启动入口地址
    "display" => "standalone", // 显示模式
    "theme_color" => $abs_theme_stately_setting['ui']['color']['theme'], // 主题色，应用窗口顶标题栏的背景色
    "background_color" => $abs_theme_stately_setting['ui']['background']['color'], // 样式加载前的页面背景色
    "lang" => $conf['lang'],
    "prefer_related_applications" => true,
    "icons" => [
        // 图标
        [
            "src" => $abs_theme_stately_setting['global']['icon']['favicon'],
            "sizes" => "192x192"
        ]
    ]

];
//echo json_encode($conf, JSON_UNESCAPED_UNICODE);
echo json_encode($the_manifest, JSON_UNESCAPED_UNICODE);
unset($abs_theme_stately_setting, $the_manifest);
