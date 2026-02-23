
    elseif ($action == 's_customizer') {
        if ($method == 'GET') {
            if(!isset($abs_theme_stately_setting)) {
                $abs_theme_stately_setting = setting_get('abs_theme_stately_setting');
            }
            if($abs_theme_stately_setting['ui_tweek']['user']['show_customizer']){
                include _include(APP_PATH . 'plugin/abs_theme_stately/view/htm/stately_my_customizer.htm');
            } else {
                message(1,'暂不可用 | Unavailable');
            }
        } else {
            message(1,"Bad Request");
        }
    }