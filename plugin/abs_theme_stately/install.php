<?php
!defined('DEBUG') and exit('501 Not Implemented');

/* 【开始】安装配置 */

/**
 * @var bool $REPLACE_MENU_ITEMS 在安装时替换主菜单、副菜单、副副菜单栏位内容？
 * true = 替换
 * false = 不替换
 * （如果你已经编辑好了菜单，请选择false）
 */
$REPLACE_MENU_ITEMS = false;

/* 【结束】安装配置 */



















/* 【开始】金桔框架——常量定义 */

$BASE_URL = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$BASE_URL = empty($BASE_URL) ? '/' : '/' . trim($BASE_URL, '/') . '/';

define('WEBSITE_DIR', $_SERVER["HTTP_HOST"] . $BASE_URL);
define('PLUGIN_DIR', 'plugin/' . param(2) . '/');
define('PLUGIN_NAME', param(2));
$plugin_profile_file = file_get_contents(APP_PATH . PLUGIN_DIR . 'conf.json');
$PLUGIN_PROFILE = json_decode($plugin_profile_file, true);
$PLUGIN_SETTING = setting_get(PLUGIN_NAME . '_setting');
include_once(APP_PATH . PLUGIN_DIR . 'conf.php');

/* 【结束】金桔框架——常量定义 */

if (!function_exists('abs_theme_stately_probe_rewrite_local')) {
    function abs_theme_stately_probe_rewrite_local()
    {
        $htaccess = APP_PATH . '.htaccess';
        if (is_file($htaccess)) {
            $txt = @file_get_contents($htaccess);
            if (is_string($txt) && stripos($txt, 'RewriteEngine') !== false && stripos($txt, 'RewriteRule') !== false) {
                return array('ok' => true, 'source' => 'htaccess');
            }
        }

        if (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules())) {
            return array('ok' => true, 'source' => 'apache_mod');
        }

        $server_software = isset($_SERVER['SERVER_SOFTWARE']) ? strtolower($_SERVER['SERVER_SOFTWARE']) : '';
        if (strpos($server_software, 'nginx') !== false || strpos($server_software, 'openresty') !== false || strpos($server_software, 'caddy') !== false) {
            return array('ok' => true, 'source' => 'server_software');
        }

        return array('ok' => false, 'source' => 'none');
    }
}
if (!function_exists('abs_theme_stately_rewrite_state')) {
    function abs_theme_stately_rewrite_state()
    {
        global $conf;

        $raw = isset($conf['url_rewrite_on']) ? $conf['url_rewrite_on'] : null;
        $value = intval($raw);
        if ($value > 0) {
            return array('enabled' => true, 'value' => $value, 'source' => 'runtime_conf', 'probe' => array());
        }

        $conf_file = APP_PATH . 'conf/conf.php';
        $txt = @file_get_contents($conf_file);
        if (is_string($txt) && preg_match('/[\'"]url_rewrite_on[\'"]\s*=>\s*[\'"]?([0-9]+)[\'"]?/', $txt, $m)) {
            $file_value = intval($m[1]);
            if ($file_value > 0) {
                return array('enabled' => true, 'value' => $file_value, 'source' => 'conf_file', 'probe' => array());
            }
            $value = $file_value;
        }

        $probe = abs_theme_stately_probe_rewrite_local();
        if (!empty($probe['ok'])) {
            return array('enabled' => true, 'value' => $value, 'source' => 'local_probe', 'probe' => $probe);
        }

        return array('enabled' => false, 'value' => $value, 'source' => 'runtime_conf', 'probe' => $probe);
    }
}

/**
 * 金桔框架——初始化设置
 * @param array $data 要导入的设置数组。
 * @return array 每一个设置项
 */
function kumquat_setting_init($data) {
    $setting = array();
    if (!isset($data['panels'])) {
        return $setting;
    } else {
        foreach ($data['panels'] as $panel => $value) {
            foreach ($value['sections'] as $section => $value) {
                foreach ($value['options'] as $option => $control) {
                    if (isset($control['default'])) {
                        $setting[$panel][$section][$option] = $control['default'];
                    } else {
                        $setting[$panel][$section][$option] = 0;
                    }
                }
            }
        }
    }
    $setting['THIS_LOCATION_FRONTEND'] = /*WEBSITE_DIR . */PLUGIN_DIR;
	$setting['THIS_LOCATION'] = PLUGIN_DIR;
    foreach ($data['kumquat_flag'] as $key => $value) {
        $setting['kumquat_flag'][$key] = $value;
    }
    return $setting;
}
//*
if ($method == 'POST') {

    if (!empty($PLUGIN_SETTING)) {
        // 已有设置
        $setting = array_merge(kumquat_setting_init($data),$PLUGIN_SETTING);
    } else {
        // 没有设置，使用默认值
        $setting = kumquat_setting_init($data);
    }
    // 板式预设
    switch (param('layout_theme', 'community')) {
        case 'blog':
            // 博客风格
            $setting['ui_style']['forum']['layout'] = 'classic_1col';
            $setting['ui_style']['forum']['style_forum_info'] = 'top_compact';
            $setting['ui_style']['thread']['style_global'] = 'blog_v2';
            $setting['ui_style']['threadlist']['style_global'] = 'blog_v1';
            $setting['ui_style']['threadlist']['cols_count_global'] = 4;
            break;
        case 'blog2':
            // 图文风格
            $setting['ui_style']['forum']['layout'] = 'classic_1col';
            $setting['ui_style']['forum']['style_forum_info'] = 'top_compact';
            $setting['ui_style']['thread']['style_global'] = 'classic_v2';
            $setting['ui_style']['threadlist']['style_global'] = 'graphic-list_v2_right';
            $setting['ui_style']['thread']['style_global'] = 'blog_v2';
            break;
        case 'medias':
            // 自媒体风格
            $setting['ui']['global']['navbar_style'] = 'horizontal';
            $setting['ui']['global']['navbar_width_horizontal'] = 'normal';
            $setting['ui']['global']['navbar_logo_show'] = 'logo';
            $setting['ui']['global']['show_appbar'] = false;
            $setting['ui']['global']['show_navbar_page_title'] = false;
            $setting['ui']['global']['disable_widget_sidebar_on_mobile'] = 1;
            $setting['ui_style']['homepage']['layout'] = 'portal_v2';
            $setting['ui_style']['homepage']['still_show_threadlist'] = false;
            $setting['ui_style']['forum']['layout'] = 'classic_1col';
            $setting['ui_style']['forum']['style_forum_info'] = 'top_compact_v2';
            $setting['ui_style']['threadlist']['style_global'] = 'graphic-list_v2_left';
            $setting['ui_style']['threadlist']['cols_count_global'] = 12;
            $setting['ui_style']['thread']['style_global'] = 'blog';
            $setting['ui_tweek']['homepage']['show_alltopthreads'] = false;
            $setting['ui_tweek']['homepage_stats']['style'] = 'v5';
            $setting['ui_tweek']['bbs']['style'] = 'v3';
            $setting['ui_tweek']['threadlist']['show_thread_excerpt'] = true;
            $setting['ui_tweek']['threadlist']['thread_excerpt_length'] = 60;
            $setting['ui_tweek']['threadlist']['show_thread_thumbnail'] = true;
            $setting['ui_tweek']['threadlist']['use_waterfall'] = false;
            $setting['ui_tweek']['threadlist']['use_ajax_load'] = false;
            $setting['special']['thread_charcount_read_time']['enable'] = true;
            $setting['special']['thread_charcount_read_time']['template'] = "<p class='lead text-center text-muted'>本文共计%1\$s个字，预计阅读时长%2\$s分钟。</p>";
            $setting['special']['thread_reading_mode']['enable'] = true;
            break;
        case 'classic':
            // 经典风格
            $setting['ui']['global']['navbar_style'] = 'horizontal';
            $setting['ui']['global']['navbar_width_horizontal'] = 'fullwidth';
            $setting['ui_style']['threadlist']['style_global'] = 'classic_v2';
            $setting['ui_style']['forum']['layout'] = 'side_classic';
            $setting['ui_style']['user']['style'] = 'classic_v1';
            $setting['ui_tweek']['threadlist']['show_thread_excerpt'] = false;
            $setting['ui_tweek']['threadlist']['show_thread_thumbnail'] = false;
            $setting['custom_content']['homepage_cta']['enable'] = false;
            break;
        case 'vintage':
            // 传统风格
            $setting['ui']['global']['navbar_style'] = 'horizontal';
            $setting['ui_style']['homepage']['layout'] = 'bbs_v1';
            $setting['ui_style']['threadlist']['style_global'] = 'super-compact_v2';
            $setting['ui_style']['forum']['layout'] = 'classic_1col';
            $setting['ui_style']['thread']['style_global'] = 'vintage_v1';
            $setting['ui_tweek']['homepage_stats']['style'] = 'v4';
            break;
        case 'nwlight':
            // 轻鸿风格#409EFF
            $setting['global']['settings']['show_back_to_top'] = true;
            $setting['global']['settings']['show_pace'] = false;
            $setting['global']['settings']['show_read_progress'] = true;
            $setting['ui']['global']['show_navbar_page_title'] = true;
            $setting['ui']['global']['navbar_style'] = 'horizontal';
            $setting['ui']['global']['navbar_width_horizontal'] = 'fullwidth';
            $setting['ui']['color']['mode'] = 'light';
            $setting['ui_style']['threadlist']['style_global'] = 'compact_v1';
            $setting['ui_tweek']['threadlist']['show_user_vcard'] = true;
            $setting['ui_style']['thread']['style_global'] = 'classic_v2';
            $setting['ui_style']['post']['layout'] = 'v2';
            $setting['ui_style']['forum']['layout'] = 'classic_3col';
            $setting['ui_style']['forum']['style_forum_info'] = 'side_classic_v2';
            $setting['ui_tweek']['navbar_vertical']['replaces_sitename_with_user_info'] = 'auto';
            $setting['ui_tweek']['navbar_vertical']['show_user_cover'] = true;
            $setting['ui_tweek']['menu_magichref_user_avatar_submenu']['style'] = 'dropdown';
            $setting['ui_tweek']['menu_magichref_user_brief']['show_uid'] = true;
            $setting['ui_tweek']['menu_magichref_user_brief']['show_usergroup'] = true;
            $setting['ui_tweek']['menu_magichref_user_brief']['show_stats'] = false;
            $setting['ui_tweek']['menu_magichref_user_brief']['show_credits'] = true;
            $setting['ui_tweek']['menu_magichref_user_brief']['show_progress'] = false;
            $setting['ui_tweek']['homepage_sitebrief']['style'] = 'v2';
            $setting['ui_tweek']['homepage_userinfo']['enable'] = true;
            $setting['ui_tweek']['homepage_userinfo']['style'] = 'v2';
            $setting['ui_tweek']['homepage_stats']['style'] = 'v5';
            $setting['ui_tweek']['threadlist']['show_thread_excerpt'] = false;
            $setting['ui_tweek']['threadlist']['show_thread_thumbnail'] = false;
            $setting['ui_tweek']['thread']['show_fab'] = true;
            $setting['ui_tweek']['user']['show_customizer'] = false;
            $setting['custom_content']['homepage_cta']['enable'] = true;
            $setting['custom_content']['homepage_cta']['style'] = 'pos_side__img_bottom';
            $setting['custom_content']['homepage_cta']['visibility'] = 'only_guest';
            $setting['custom_content']['homepage_cta']['title'] = '你好！欢迎来访！';
            $setting['custom_content']['homepage_cta']['content'] = '<p>请登录后探索更多精彩内容！</p>';
            break;
        default:
            //社区风格
            // do nothing
            break;
    }

    switch (param('palette_theme', 'default')) {
        case 'default':
        case 'Default':
            // ikunkun.icu / gggmusic.com / xxedm.com / yunshimc.com style
            $setting['ui']['color']['theme'] = '#696cff';
            $setting['ui']['color']['color_body_light'] = '#697a8d';
            $setting['ui']['color']['color_body_bright_light'] = '#566a7f';
            $setting['ui']['color']['color_card_light'] = '#ffffff';
            $setting['ui']['color']['color_body_dark'] = '#a3a4cc';
            $setting['ui']['color']['color_body_bright_dark'] = '#cfcce6';
            $setting['ui']['color']['color_card_dark'] = '#2b2c40';
            $setting['ui']['background']['style'] = 'default';
            break;
        case 'Ocean':
            // duanao.com / lianghuaba.net style
            $setting['ui']['color']['theme'] = '#00BCD4';
            $setting['ui']['color']['color_body_light'] = '#546e7a';
            $setting['ui']['color']['color_body_bright_light'] = '#37474f';
            $setting['ui']['color']['color_card_light'] = '#ffffff';
            $setting['ui']['color']['color_body_dark'] = '#80cbc4';
            $setting['ui']['color']['color_body_bright_dark'] = '#b2dfdb';
            $setting['ui']['color']['color_card_dark'] = '#1a2327';
            $setting['ui']['background']['style'] = 'default';
            break;
        case 'Tangerine':
            // xxedm.com alternate warm style
            $setting['ui']['color']['theme'] = '#FF6F61';
            $setting['ui']['color']['color_body_light'] = '#667791';
            $setting['ui']['color']['color_body_bright_light'] = '#37474f';
            $setting['ui']['color']['color_card_light'] = '#fff8f6';
            $setting['ui']['color']['color_body_dark'] = '#ffab91';
            $setting['ui']['color']['color_body_bright_dark'] = '#ffccbc';
            $setting['ui']['color']['color_card_dark'] = '#2c1a14';
            $setting['ui']['background']['style'] = 'default';
            break;
        case 'Meadow':
            // 9ioldgame.com retro-green style
            $setting['ui']['color']['theme'] = '#00A968';
            $setting['ui']['color']['color_body_light'] = '#4a635a';
            $setting['ui']['color']['color_body_bright_light'] = '#2e473c';
            $setting['ui']['color']['color_card_light'] = '#f5faf7';
            $setting['ui']['color']['color_body_dark'] = '#81c784';
            $setting['ui']['color']['color_body_bright_dark'] = '#a5d6a7';
            $setting['ui']['color']['color_card_dark'] = '#1b2e1f';
            $setting['ui']['background']['style'] = 'default';
            break;
        case 'Twilight':
            // caigamer.cn gaming purple style
            $setting['ui']['color']['theme'] = '#7C4DFF';
            $setting['ui']['color']['color_body_light'] = '#667791';
            $setting['ui']['color']['color_body_bright_light'] = '#4a4a6a';
            $setting['ui']['color']['color_card_light'] = '#f8f7ff';
            $setting['ui']['color']['color_body_dark'] = '#b39ddb';
            $setting['ui']['color']['color_body_bright_dark'] = '#d1c4e9';
            $setting['ui']['color']['color_card_dark'] = '#1a1533';
            $setting['ui']['background']['style'] = 'default';
            break;
        case 'Autumn':
            // bbs.liguozheng.site blue professional style
            $setting['ui']['color']['theme'] = '#0078D7';
            $setting['ui']['color']['color_body_light'] = '#546e7a';
            $setting['ui']['color']['color_body_bright_light'] = '#263238';
            $setting['ui']['color']['color_card_light'] = '#ffffff';
            $setting['ui']['color']['color_body_dark'] = '#90caf9';
            $setting['ui']['color']['color_body_bright_dark'] = '#bbdefb';
            $setting['ui']['color']['color_card_dark'] = '#0d1b2a';
            $setting['ui']['background']['style'] = 'default';
            break;
        case 'Peach':
            // qz.lq.mba warm pink style
            $setting['ui']['color']['theme'] = '#ff8599';
            $setting['ui']['color']['color_body_light'] = '#78666b';
            $setting['ui']['color']['color_body_bright_light'] = '#5a4045';
            $setting['ui']['color']['color_card_light'] = '#fff5f7';
            $setting['ui']['color']['color_body_dark'] = '#f48fb1';
            $setting['ui']['color']['color_body_bright_dark'] = '#f8bbd0';
            $setting['ui']['color']['color_card_dark'] = '#2a1520';
            $setting['ui']['background']['style'] = 'default';
            break;
        case 'Garden':
            $setting['ui']['color']['theme'] = '#4A90E2';
            $setting['ui']['color']['color_body_light'] = '#667791';
            $setting['ui']['color']['color_body_bright_light'] = '#222222';
            $setting['ui']['color']['color_body_dark'] = '#8a94ad';
            $setting['ui']['color']['color_body_bright_dark'] = '#ffffff';
            $setting['ui']['color']['color_card_dark'] = '#1a0017';
            $setting['ui']['background']['style'] = 'gradient_Garden';
            $setting['ui']['global']['semitransparent_card'] = true;
            break;
        case 'Fairy':
            $setting['ui']['color']['theme'] = '#673AB7';
            $setting['ui']['color']['color_body_light'] = '#667791';
            $setting['ui']['color']['color_body_bright_light'] = '#222222';
            $setting['ui']['color']['color_body_dark'] = '#8a94ad';
            $setting['ui']['color']['color_body_bright_dark'] = '#ffffff';
            $setting['ui']['color']['color_card_dark'] = '#001d0d';
            $setting['ui']['background']['style'] = 'gradient_Fairy';
            $setting['ui']['global']['semitransparent_card'] = true;
            break;
        case 'Pastel':
            $setting['ui']['color']['theme'] = '#AB47BC';
            $setting['ui']['color']['color_body_light'] = '#667791';
            $setting['ui']['color']['color_body_bright_light'] = '#222222';
            $setting['ui']['color']['color_body_dark'] = '#8a94ad';
            $setting['ui']['color']['color_body_bright_dark'] = '#ffffff';
            $setting['ui']['color']['color_card_dark'] = '#002e2e';
            $setting['ui']['background']['style'] = 'gradient_Pastel';
            $setting['ui']['global']['semitransparent_card'] = true;
            break;
        case 'Book':
            $setting['ui']['color']['theme'] = '#EF5350';
            $setting['ui']['color']['color_body_light'] = '#667791';
            $setting['ui']['color']['color_body_bright_light'] = '#222222';
            $setting['ui']['color']['color_body_dark'] = '#8a94ad';
            $setting['ui']['color']['color_body_bright_dark'] = '#ffffff';
            $setting['ui']['color']['color_card_dark'] = '#140a00';
            $setting['ui']['background']['style'] = 'gradient_Book';
            $setting['ui']['global']['semitransparent_card'] = true;
            break;
    }


    // 进行设置
    setting_set(PLUGIN_NAME . '_setting', $setting);

    if (function_exists("xn_nav_menu_slot_add")) {
        xn_nav_menu_slot_add('bbspage', array(
            array('lid' => 1, 'icon' => 'la la-comments', 'name' => '全部板块', 'desc' => '', 'href' => '__forumlist_section__', 'order' => 0, 'class' => '', 'submenu' => '',),
            array('lid' => 2, 'icon' => 'la la-comments-o', 'name' => '默认分类|1,2,3', 'desc' => '默认分类介绍', 'href' => '__forumlist_section__', 'order' => 0, 'class' => '', 'submenu' => '',),
        ));
        xn_nav_menu_slot_add('portalpage', array(
            array('lid' => 1, 'icon' => 'la la-comments', 'name' => '0', 'desc' => '', 'href' => '__portal_section__', 'order' => 0, 'class' => '', 'attr' => '1', 'submenu' => '',),
            array('lid' => 2, 'icon' => 'la la-comments-o', 'name' => '1', 'desc' => '默认分类介绍', 'href' => '__portal_section__', 'order' => 0, 'class' => '', 'attr' => '2', 'submenu' => '',),
            array('lid' => 3, 'icon' => 'la la-comments-o', 'name' => '2', 'desc' => '', 'href' => '__portal_section__', 'order' => 0, 'class' => '', 'attr' => '2', 'submenu' => '',),
        ));
        xn_nav_menu_slot_add('appbar_menu', array(
            array('lid' => 1, 'icon' => 'la la-home', 'name' => '首页', 'title' => '', 'href' => '.', 'order' => 10, 'class' => '', 'attr' => 'data-active=fid-0', 'submenu' => ''),
            array('lid' => 2, 'icon' => 'la la-comments-o', 'name' => '分类', 'title' => '', 'href' => 'bbs.htm', 'order' => 20, 'class' => '', 'attr' => "data-toggle='modal' data-target='#forum'", 'submenu' => ''),
            array('lid' => 3, 'icon' => 'la la-plus', 'name' => '', 'title' => '发帖', 'href' => '__btn_thread_new__', 'order' => 30, 'class' => ' px-3 py-1 rounded-3 bg-gradient', 'submenu' => ''),
            array('lid' => 4, 'icon' => 'la la-plus', 'name' => '', 'title' => '登录', 'href' => '__stately_login_modal__', 'order' => 19, 'class' => ' px-3 py-1 rounded-3 bg-gradient', 'submenu' => ''),
            array('lid' => 5, 'icon' => 'la la-bell-o', 'name' => '消息', 'title' => '', 'href' => '__stately_notice_modal__', 'order' => 40, 'class' => '', 'submenu' => ''),
            array('lid' => 6, 'icon' => 'la la-user', 'name' => '我', 'title' => '', 'href' => 'my.htm', 'order' => 50, 'class' => '', 'attr' => 'data-active=menu-my', 'submenu' => ''),
        ));
        xn_nav_menu_slot_add('stately_contextmenu__normal', array(
            array('lid' => 1, 'icon' => 'las la-file', 'name' => '关于本站', 'desc' => '', 'href' => url('about_us'), 'order' => 10, 'class' => '', 'attr' => '', 'submenu' => '',),
            array('lid' => 2, 'icon' => 'las la-file', 'name' => '本站规则', 'desc' => '', 'href' => url('terms'), 'order' => 20, 'class' => '', 'attr' => '', 'submenu' => '',),
            array('lid' => 3, 'icon' => 'las la-file', 'name' => '隐私政策', 'desc' => '', 'href' => url('privacy'), 'order' => 30, 'class' => '', 'attr' => '', 'submenu' => '',),
            array('lid' => 4, 'icon' => 'las la-file', 'name' => '联系我们', 'desc' => '', 'href' => url('contact_us'), 'order' => 40, 'class' => '', 'attr' => '', 'submenu' => '',),
        ));
        if ($REPLACE_MENU_ITEMS || boolval(param('replace_menu_items', 0))) {
            xn_nav_menu_item_set('primary_menu', array(
                array('lid' => 1, 'icon' => 'la la-home', 'name' => '首页', 'title' => '', 'href' => '.', 'order' => 0, 'class' => '', 'attr' => 'data-active=\'fid-0\''),
                array('lid' => 2, 'icon' => 'la la-comments', 'name' => '话题', 'href' => '__divider_text__', 'order' => 10, 'class' => ''),
                array('lid' => 3, 'icon' => 'la la-comments', 'name' => '话题', 'href' => '__forumlist__', 'order' => 11, 'class' => ''),
                array('lid' => 4, 'icon' => 'la la-plus', 'name' => '发新帖', 'href' => '__btn_thread_new__', 'order' => 100, 'class' => 'menu-link mt-1'),
            ), true);
            xn_nav_menu_item_set('secondary_menu', array(
                array('lid' => 1, 'icon' => 'la la-user', 'name' => '用户', 'href' => '__user_avatar_submenu__', 'order' => 50, 'class' => ''),
                array('lid' => 2, 'icon' => 'la la-user', 'name' => '登录', 'href' => '__stately_login_modal__', 'order' => 100, 'class' => ''),
                array('lid' => 3, 'icon' => 'la la-search', 'name' => '搜索', 'href' => '__stately_search_modal__', 'order' => 10, 'class' => ''),
                array('lid' => 4, 'icon' => 'la la-bell', 'name' => '通知', 'href' => '__stately_notice_modal__', 'order' => 49, 'class' => ''),
                array('lid' => 5, 'icon' => 'la la-cog', 'name' => '颜色模式', 'href' => '__stately_btn_colormode__', 'order' => 9, 'class' => ''),
            ), true);
            xn_nav_menu_item_set('tertiary_menu', array(
                array('lid' => 1, 'icon' => 'la la-search', 'name' => '搜索', 'href' => '__stately_search__', 'order' => 0, 'class' => ''),
            ), true);
            xn_nav_menu_item_set('user_menu', array(
                array('lid' => 1, 'icon' => 'la la-home', 'name' => '我的主页', 'href' => '__user_brief__', 'order' => 0),
                array('lid' => 2, 'icon' => 'la la-comments', 'name' => '我的帖子', 'href' => url('my-thread'), 'order' => 0),
                array('lid' => 3, 'icon' => 'la la-cog', 'name' => '后台', 'href' => '__admin__', 'order' => 100),
                array('lid' => 4, 'icon' => 'la la-user', 'name' => '退出', 'href' => '__user_logout__', 'order' => 101),
                array('lid' => 5, 'icon' => 'la la-circle-o', 'name' => '——', 'href' => '__divider__', 'order' => 50),
            ), true);
            xn_nav_menu_item_set('appbar_menu', array(
                array('lid' => 1, 'icon' => 'la la-home', 'name' => '首页', 'title' => '', 'href' => '.', 'order' => 10, 'class' => '', 'attr' => 'data-active=fid-0', 'submenu' => ''),
                array('lid' => 2, 'icon' => 'la la-comments-o', 'name' => '分类', 'title' => '', 'href' => 'bbs.htm', 'order' => 20, 'class' => '', 'attr' => "data-toggle='modal' data-target='#forum'", 'submenu' => ''),
                array('lid' => 3, 'icon' => 'la la-plus', 'name' => '', 'title' => '发帖', 'href' => '__btn_thread_new__', 'order' => 30, 'class' => ' px-3 py-1 rounded-3 bg-gradient', 'submenu' => ''),
                array('lid' => 4, 'icon' => 'la la-plus', 'name' => '', 'title' => '登录', 'href' => '__stately_login_modal__', 'order' => 19, 'class' => ' px-3 py-1 rounded-3 bg-gradient', 'submenu' => ''),
                array('lid' => 5, 'icon' => 'la la-bell-o', 'name' => '消息', 'title' => '', 'href' => '__stately_notice_modal__', 'order' => 40, 'class' => '', 'submenu' => ''),
                array('lid' => 6, 'icon' => 'la la-user', 'name' => '我', 'title' => '', 'href' => 'my.htm', 'order' => 50, 'class' => '', 'attr' => 'data-active=menu-my', 'submenu' => ''),
            ), true);
        }
    }

    message(0,jump('安装成功，即将进入主题设置', url('plugin-setting-abs_theme_stately'), 3));
} else {
    //*/
    $rewrite_state = abs_theme_stately_rewrite_state();
    $rewrite_ok = !empty($rewrite_state['enabled']);
    $rewrite_note = '';
    if ($rewrite_ok && $rewrite_state['source'] === 'local_probe') {
        $rewrite_note = '<p><span class="badge badge-warning">!</span> 后台配置读取到 url_rewrite_on=0，但探测到伪静态可用，已按可用处理。建议到“后台 -> 设置 -> 站点设置”保存一次伪静态开关。</p>';
    } elseif ($rewrite_ok && $rewrite_state['source'] === 'conf_file') {
        $rewrite_note = '<p><span class="badge badge-warning">!</span> 运行时配置与 conf/conf.php 不一致，当前按 conf/conf.php 的伪静态配置继续。</p>';
    }

    $inst_page_init = '</h4></div></div></div></div><style>
    @import "../plugin/abs_theme_stately/view/css/core.css"; 
    @import "../plugin/abs_theme_stately/view/css/theme-default.css"; 
    @import "../plugin/abs_theme_stately/view/css/pages/page-auth.css"; 
    header#header,footer#footer,.col-lg-8.mx-auto>.card{display:none}.nav-pills .nav-link.active .badge.bg-label-primary{background-color:rgba(var(--bs-white-rgb),.1) !important;color:var(--bs-white) !important}.nav-pills .nav-link .badge.bg-label-primary{width:4.5rem;height:4.5rem;line-height:1.666}.btn-check:checked~label{border-color:var(--bs-primary,var(--primary)) !important;cursor:pointer}.btn-check:checked~label h4{color:var(--bs-primary,var(--primary))}.w-50{width:calc(50% - 1em) !important;margin: 0 .5em}.nav-align-top .nav-link {flex-direction: column;}</style>';
    $inst_page_steps = array(
        array(
            'title' => '环境检查与安装顺序',
            'icon' => 'icon-edit',
            'content' => '<section class="text-center">
        <h3>感谢您选择 Stately 主题!</h3>
        <p class="lead">先完成环境检查，再按推荐顺序安装，能显著降低冲突风险。</p>
    </section>
    <section>'
                . ( version_compare(PHP_VERSION, '7.2.0', '<') ? '<p><span class="badge badge-warning">ⓘ</span> 您的PHP版本：' . PHP_VERSION . '。请使用至少7.2版的PHP才能使用本主题。</p>'
                : (version_compare(PHP_VERSION, '8.0.0', '<') ? '<p><span class="badge badge-success">√</span> 您的PHP版本：' . PHP_VERSION . '，真棒！如果条件允许，可以使用8.0.0以上版本的PHP获得更大的性能提升。</p>' :
                ((ini_get('opcache.jit') !== false && ini_get('opcache.jit') !== '0' && ini_get('opcache.jit') !== '') ? '<p><span class="badge badge-success">√</span> 您的PHP版本：' . PHP_VERSION . '，并启用了JIT，太棒了！</p>' : '<p><span class="badge badge-success">√</span> 您的PHP版本：' . PHP_VERSION . '，真棒！如果条件允许，可以启用JIT功能获得更大的性能提升。</p>')) )
                . ($rewrite_ok == false
                    ? '<p><span class="badge badge-danger">×</span> 请启用伪静态功能，再使用本主题！<b>如遇到部分链接失灵，请在启用伪静态功能后卸载本主题，再重新安装。</b></p>'
                    : '<p><span class="badge badge-success">√</span> 伪静态功能已开启。</p>' . $rewrite_note)
                . (boolval($conf['cache']['enable']) == false
                    ? '<p><span class="badge badge-warning">×</span> 建议启用缓存功能！</p>'
                    : '<p><span class="badge badge-success">√</span> 缓存功能已开启。</p>')
                . (strtolower($conf['cache']['type']) == 'mysql'
                    ? '<p><span class="badge badge-info">×</span> 您目前在使用默认的MySQL缓存方式，其实还可以啦。如果你想的话，切换为其他缓存方式能获得更大的性能提升。</p>'
                    : '<p><span class="badge badge-success">√</span> 您目前在使用' . ucwords($conf['cache']['type']) . '缓存方式，真棒！</p>')
                . (function_exists('xn_nav_menu_slot_add') == false
                    ? '<p><span class="badge badge-warning">×</span> 推荐安装菜单插件，享受完整体验！</p>'
                    : '<p><span class="badge badge-success">√</span> 菜单插件已启用，真棒！</p>')
                . '<p><span class="badge badge-info">ⓘ</span> <strong>不要启用</strong>菜单插件附带的“默认头部（abs_nav_menu_1row）”、“双行导航头部（abs_nav_menu_2row）”、“APP底部栏（abs_nav_menu_appbar）”、“侧边菜单（abs_nav_menu_side）”定制菜单，启用任何一个都会导致排版故障。若已经启用了，请在安装完成后禁用或卸载它们。</p>'
                . '<p><span class="badge badge-info">ⓘ</span> 本主题<strong>不保证兼容</strong>您拥有的所有插件，可能会因为不兼容或冲突导致网站无法打开。若该情况发生了，请尝试逐个卸载插件来排查是哪个插件导致的问题。</p>'
                . '<div class="alert alert-info mb-2"><strong>推荐安装顺序（按官方原文）：</strong><ol class="mb-2 pl-3"><li>将菜单插件放在 <code>plugin/</code> 目录（建议：<code>abs_menu</code>）。</li><li>将 Stately 主题放在 <code>plugin/</code> 目录（<code>abs_theme_stately</code>）。</li><li>再放入其余需要的插件。</li><li>进入后台插件页，如发现已有启用项，先卸载到全部显示“安装”。</li><li>先安装菜单插件，再安装主题，最后安装其他插件。</li></ol><p class="mb-0">如果你使用一键启动器，它会按“菜单 → 主题 → 其他插件”的顺序执行，并在每个插件后等待 0.5 秒。</p></div>'
                .'</section>
    <section>
        <button type="button" class="btn btn-primary btn-block btnNext">下一步：选择风格</button> 
    </section>'
        ),
        array(
            'title' => '选择预设风格',
            'icon' => 'icon-magic',
            'content' => '<section class="text-center">
        <h3>选择风格与配色</h3>
        <p class="lead">这里只是初始化预设，安装完成后可在主题设置中随时调整。</p>
    </section>
    <section>
        <div class="btn-group d-flex flex-wrap" role="group" aria-label="Basic radio toggle button group">
            <div class="w-50">
                <input type="radio" class="btn-check" name="layout_theme" value="community" id="layout_theme1" checked="" >
                <label class="card border" for="layout_theme1">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_preset_community.png" alt="社区风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>社区风格（默认）</h4>
                                <p class="m-0">适合社区、论坛等众多用途，简约不失温馨。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="w-50">
                <input type="radio" class="btn-check" name="layout_theme" value="nwlight" id="layout_theme6" >
                <label class="card border" for="layout_theme6">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_preset_light.png" alt="轻简风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>轻简风格</h4>
                                <p class="m-0">经典的Xiuno BBS风格，但更上一层楼。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="w-50">
                <input type="radio" class="btn-check" name="layout_theme" value="medias" id="layout_theme7" >
                <label class="card border" for="layout_theme7">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_preset_medias.png" alt="资讯风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>资讯风格</h4>
                                <p class="m-0">类似新媒体/自媒体/博客风格的主页排版，和与之配套的内页风格，让读者舒适地感受网站中的丰富内容。<small>在安装完主题后，进入“主题设置→外观-板式微调→主页门户网站风格V2”进行各个区域的名称、图标修改。</small></p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="w-50">
                <input type="radio" class="btn-check" name="layout_theme" value="blog" id="layout_theme2" >
                <label class="card border" for="layout_theme2">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_preset_blog.png" alt="博客风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>博客风格</h4>
                                <p class="m-0">类似博客的排版，让读者聚焦于内容。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="w-50">
                <input type="radio" class="btn-check" name="layout_theme" value="blog2" id="layout_theme5" >
                <label class="card border" for="layout_theme5">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_preset_blog2.png" alt="图文风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>图文风格</h4>
                                <p class="m-0">（博客二号）类似博客的排版，让读者聚焦于内容。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

            <div class="w-50">
                <input type="radio" class="btn-check" name="layout_theme" value="classic" id="layout_theme3" >
                <label class="card border" for="layout_theme3">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_preset_classic.png" alt="经典风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>经典风格</h4>
                                <p class="m-0">经典的Xiuno BBS风格，给人“宾至如归”的体验。插件兼容性相对更好。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="w-50">
                <input type="radio" class="btn-check" name="layout_theme" value="vintage" id="layout_theme4" >
                <label class="card border" for="layout_theme4">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_preset_vintage.png" alt="传统风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>传统风格</h4>
                                <p class="m-0">类似Discuz等传统BBS风格的排版。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </section>
    <section class="text-center">
        <h4>选择配色风格</h4>
        <div class="btn-group d-flex flex-wrap" role="group" aria-label="Basic radio toggle button group">
            <div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="default" id="palette_theme1" checked="">
                <label class="card border" for="palette_theme1">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Default.png" alt="默认风格 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>默认风格</h4>
                                <p class="m-0">享受Stately主题的清爽外观。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

            <div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Garden" id="palette_theme2">
                <label class="card border" for="palette_theme2">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Garden.png" alt="春日花园 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>春日花园</h4>
                                <p class="m-0">柔和的颜色组合，让人联想到春天盛开的花朵。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Peach" id="palette_theme3">
                <label class="card border" for="palette_theme3">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Peach.png" alt="蜜桃苏打 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>蜜桃苏打</h4>
                                <p class="m-0">温暖而甜蜜的颜色，宛如一杯冰凉的蜜桃味苏打水。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Ocean" id="palette_theme4">
                <label class="card border" for="palette_theme4">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Ocean.png" alt="海边漫步 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>海边漫步</h4>
                                <p class="m-0">清爽的蓝色调，仿佛沿着海岸线散步时看到的海景。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Tangerine" id="palette_theme5">
                <label class="card border" for="palette_theme5">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Tangerine.png" alt="夏日柑橘 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>夏日柑橘</h4>
                                <p class="m-0">明亮且充满活力的色彩，像是夏日里新鲜的柑橘果肉。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Pastel" id="palette_theme6">
                <label class="card border" for="palette_theme6">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Pastel.png" alt="珊瑚礁影 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>珊瑚礁影</h4>
                                <p class="m-0">多种柔和色调混合，犹如海底世界中的珊瑚礁。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Autumn" id="palette_theme7">
                <label class="card border" for="palette_theme7">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Autumn.png" alt="秋意浓情 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>秋意浓情</h4>
                                <p class="m-0">暖色调渐变，传递出秋天丰收季节的温暖感觉。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Meadow" id="palette_theme8">
                <label class="card border" for="palette_theme8">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Meadow.png" alt="青葱岁月 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>青葱岁月</h4>
                                <p class="m-0">绿色系为主的清新配色，唤起青春活力的记忆。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Twilight" id="palette_theme9">
                <label class="card border" for="palette_theme9">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Twilight.png" alt="暮光之城 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>暮光之城</h4>
                                <p class="m-0">黄昏时分的柔和光线，带有一点神秘的气息。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Book" id="palette_theme10">
                <label class="card border" for="palette_theme10">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Book.png" alt="古朴书卷 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>古朴书卷</h4>
                                <p class="m-0">复古色调，仿佛翻阅古老书籍时的感受。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div><div class="w-25">
                <input type="radio" class="btn-check" name="palette_theme" value="Fairy" id="palette_theme11">
                <label class="card border" for="palette_theme11">
                    <img class="card-img-top" src="../plugin/abs_theme_stately/view/img/_admin/install_palette_Fairy.png" alt="梦幻彩虹 示意图">
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>梦幻彩虹</h4>
                                <p class="m-0">多色混合的渐变效果，如同雨后天晴出现的彩虹。</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

        </div>
    </section>
    '
    . ( function_exists('xn_nav_menu_slot_add') == false ? '' :
    '<section class="text-center mb-2">
        <h4>使用预置的菜单？</h4>
        <div class="form-check">
          <input name="replace_menu_items" class="form-check-input" type="radio" value="1" id="defaultRadio1">
          <label class="form-check-label" for="defaultRadio1">
          <b>是</b>，<b>请帮我</b>设置菜单项
          </label>
        </div>
        <div class="form-check">
          <input name="replace_menu_items" class="form-check-input" type="radio" value="0" id="defaultRadio2" checked="">
          <label class="form-check-label" for="defaultRadio2">
          <b>否</b>，我<b>稍后设置</b>菜单项
          </label>
        </div>
    </section>')
    . '<section> 
        <button type="button" class="btn btn-primary btn-block btnNext">下一步：确认并初始化</button> 
    </section>'
        ),
        array(
            'title' => '确认并初始化',
            'icon' => 'icon-check',
            'content' => '<section class="text-center">
        <h3>准备就绪</h3>
        <p class="lead">点击下方按钮开始初始化，完成后将自动进入主题设置页。</p>
    </section>
    <section>
        <button type="submit" class="btn btn-block btn-primary bg-gradient" id="stately_continue">确认并开始初始化</button>
    </section>
    <hr>
    <section>
        <div class="row">
        <div class="col-lg-6">
        <p>接下来,建议您设置这些选项:</p>
        <h4>Logo设置</h4>
        <p> 请将Logo上传到服务器或图床中，然后在 </p>
        <ul>
            <li>全局→标志→网站标志（Logo）</li>
            <li>全局→标志→浏览器图标（Favicon）</li>
        </ul>
        <p> 中填写图片的网址。 </p>
        <div class="accordion">
            <details class="card accordion-item">
                <summary class="accordion-button collapsed">我上传了Logo图片,然后怎么填写?(点击查看)</summary>
                <h4>Logo在服务器中</h4>
                <p> 假设你的logo在服务器中的位置是“服务器根目录/view/img/mylogo.png”，那么你需要填写“http://你的网址/view/img/mylogo.png”。 </p>
                <h4>Logo在图床</h4>
                <p> 请复制图床提供的图片URL，粘贴到文本框中即可。</p>
            </details>
        </div>
        <h4></h4>
        <h4>页脚信息</h4>
        <ul>
            <li>自定义内容→全局→页脚左侧文字</li>
            <li>自定义内容→全局→页脚右侧文字</li>
        </ul>
        <p>将以上两项的内容全部删除，然后换成你的内容，如版权信息、备案号等.</p>
        </div>
        <div class="col-lg-6">
        <h4>需要更多帮助？</h4>
        <p>请查阅包内附送的<a href="../plugin/abs_theme_stately/Stately主题 Document 使用文档（使用记事本打开 Open with Notepad）.md">Stately主题
        使用文档</a>。</p>
        </div>
        </div>

    </section>
    <hr>
    <section class="text-center">
        <p class="lead">最后,请考虑为作者买一杯你最喜欢的饮料</p>'
                . $data['panels']['about']['sections']['about_theme']['options']['C0FFEE']['default']
                . $data['panels']['about']['sections']['about_theme']['options']['C0FFEE']['description']
                . '</section>'
        )
    );

    $inst_page_js = <<<'EOT'
<script defer>
(function () {
  function activateStep(targetSelector) {
    if (!targetSelector) return;
    var $targetPane = $(targetSelector);
    if (!$targetPane.length) return;

    $('.nav.nav-pills .nav-link').removeClass('active').attr('aria-selected', 'false');
    var $targetTab = $('.nav.nav-pills .nav-link[data-bs-target="' + targetSelector + '"], .nav.nav-pills .nav-link[data-target="' + targetSelector + '"]').first();
    $targetTab.addClass('active').attr('aria-selected', 'true');

    $('.tab-content .tab-pane').removeClass('show active');
    $targetPane.addClass('show active');
  }

  $('.nav.nav-pills .nav-link').on('click', function (e) {
    var target = $(this).attr('data-bs-target') || $(this).attr('data-target');
    if (!target) return;
    e.preventDefault();
    activateStep(target);
  });

  $('.btnNext').on('click', function (e) {
    e.preventDefault();
    var $currentPane = $('.tab-content .tab-pane.show.active');
    if (!$currentPane.length) $currentPane = $('.tab-content .tab-pane.active').first();
    if (!$currentPane.length) return false;

    var $nextPane = $currentPane.nextAll('.tab-pane').first();
    if ($nextPane.length) {
      activateStep('#' + $nextPane.attr('id'));
    }
    return false;
  });

  $('.btnPrevious').on('click', function (e) {
    e.preventDefault();
    var $currentPane = $('.tab-content .tab-pane.show.active');
    if (!$currentPane.length) $currentPane = $('.tab-content .tab-pane.active').first();
    if (!$currentPane.length) return false;

    var $prevPane = $currentPane.prevAll('.tab-pane').first();
    if ($prevPane.length) {
      activateStep('#' + $prevPane.attr('id'));
    }
    return false;
  });

  function getSelectedInputValue() {
    var inputs = document.querySelectorAll("#template-customizer-color input[name='template-customizer-color']");
    var selectedValue = null;
    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].checked) {
        selectedValue = inputs[i].value;
        break;
      }
    }
    return selectedValue;
  }

  window.getSelectedInputValue = getSelectedInputValue;
})();
</script>
EOT;

    $inst_page_flatten = $inst_page_init
        . '<div class="nav-align-top col-md-10 mx-auto mb-4">'
        . '<ul class="nav nav-pills justify-content-center mb-3" role="tablist">';

    foreach ($inst_page_steps as $step_count => $step) {
        $inst_page_flatten .= '<li class="nav-item" role="presentation">
    <button type="button" class="nav-link ' . ($step_count === 0 ? 'active' : '') . '" role="tab" data-toggle="tab" data-target="#step_' . ($step_count + 1) . '" data-bs-toggle="tab" data-bs-target="#step_' . ($step_count + 1) . '" aria-controls="step_' . ($step_count + 1) . '" aria-selected="true">
        <span class="d-block fs-3 badge rounded-circle bg-label-primary"><i class="' . $step['icon'] . '"></i></span> ' . $step['title'] . ' </button>
</li>';
    }
    $inst_page_flatten .= '</ul>
<form action="./' . url('plugin-install-abs_theme_stately') . '" method="post">
<div class="tab-content card">';

    foreach ($inst_page_steps as $step_count => $step) {
        $inst_page_flatten .= '<div class="tab-pane fade ' . ($step_count === 0 ? 'show active' : '') . '" id="step_' . ($step_count + 1) . '" role="tabpanel">'
            . $step['content']
            . '</div>';
    }

    $inst_page_flatten .= '</div>
</form>'
. '<footer class="text-center text-black-50 p-3">'

. $data['panels']['custom_content']['sections']['global']['options']['footer_left_content']['default']
. '<wbr>丨Made by ' . $data['panels']['about']['sections']['about_theme']['options']['authors']['default'] . ' &copy; 2022 - ' . date('Y ')
. '<wbr>丨V ' . $PLUGIN_PROFILE['version'] . ' For Xiuno BBS ' . $PLUGIN_PROFILE['bbs_version'] . '+'
.'</footer>'
. '</div>'
        . $inst_page_js;

    message(
        0,
        $inst_page_flatten
    );
}
