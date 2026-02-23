
    elseif ($action == 'cover') {
        if (!isset($till_user_cover_setting)) {
            $till_user_cover_setting = setting_get('till_user_cover_setting');
        }
        if (!$till_user_cover_setting['allow_frontend_update']) {
            message(1, '不允许更改封面图');
        }

        $covers_list_raw = cover_get_covers_list();
        $covers_list = array();
        $covers_list_i = 0;
        foreach ($covers_list_raw as $k => $v) {
            $covers_list[$covers_list_i] = array(
                'url' => $k,
                'label' => $v
            );
            $covers_list_i++;
        }
        $current_cover_i = 0;
        unset($covers_list_i);

        foreach ($covers_list as $k => $v) {
            $r = array_search(cover_get_cover_url_by_uid_raw_DO_NOT_USE_OR_YOU_WILL_BE_FIRED($uid), $v);
            if ($r === false) {
                continue;
            } else {
                $current_cover_i = $k;
            }
        }

        if ($method == 'GET') {
            // hook my_cover_image_get_start.php

            include _include(APP_PATH . 'plugin/till_user_cover/view/htm/my_cover.htm');
        } else {

            /**
             * @var string|bool $remove_cover 是否删除封面图
             */
            $remove_cover = param('remove_cover', '');
            /**
             * @var string $way 封面图处理方式：preset==预设、custom==自定义
             */
            $way = param('way', '');
            /**
             * @var string $cover_image_url
             */
            $cover_image_url = param('cover_image_url', '');
            $cover_image_url_p = param('cover_image_url_p', '');
            $cover_image_url_real = '';

            if ($remove_cover) {
                user_update($uid, array('cover_url' => ''));
                message(0, jump("封面图已删除。", url('my-cover'), 2));
            }

            // hook my_cover_image_post_start.php

            switch ($way) {
                case 'preset':
                    //确保key存在，才更换封面图
                    if (array_key_exists($cover_image_url_p, $covers_list)) {
                        $cover_image_url_real = $covers_list[$cover_image_url_p]['url'];
                    } else {
                        $cover_image_url_real = $covers_list[0]['url'];
                    }
                    break;
                case 'custom':
                    if (function_exists('xn_html_safe')) {
                        $cover_image_url_real = xn_html_safe($cover_image_url);
                    } else {
                        $cover_image_url_real = strip_tags(htmlspecialchars($cover_image_url));
                    }
                    break;
                default:
                    message(1, 'Bad Request');
                    break;
            }

            // hook my_cover_image_post_end.php

            if (!empty($cover_image_url_real)) {
                user_update($uid, array('cover_url' => $cover_image_url_real));
                message(0, jump('封面图设置成功！', url('my-cover'), 1));
            }
        }
    }