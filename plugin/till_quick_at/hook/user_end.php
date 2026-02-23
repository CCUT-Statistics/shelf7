//<?php

    if ($action === 'atsearch') {
        $till_quick_at_setting = setting_get('till_quick_at_setting');

        if ($method === 'GET' && $ajax) {
            if ($uid) {
                $searching_for_user = addcslashes(trim(param('who', '')), "%_\\");
                if (empty($searching_for_user)) {
                    message(1, [
                        'message' => '请输入要搜索的用户名',
                        'users_list' => [],
                    ]);
                    die;
                }
                if (mb_strlen($searching_for_user) >= 31) {
                    message(3, [
                        'message' => '请缩短要搜索的用户名',
                        'users_list' => [],
                    ]);
                    die;
                } else {
                    $search_result = cache_get('atsearch_' . $searching_for_user);
                    if (is_null($search_result) || $till_quick_at_setting['use_cache']) {
                        $search_result = db_find(
                            'user',
                            ['username' => ['like' => '%' . $searching_for_user . '%']],
                            ['login_date' => 0],
                            1,
                            20,
                            'uid',
                            ['uid', 'gid', 'username', 'create_date', 'login_date', 'create_ip', 'login_ip', 'avatar']
                        );
                        cache_set('atsearch_' . $searching_for_user, $search_result, 30);
                    }
                    if (!empty($search_result)) {
                        foreach ($search_result as &$_user) {
                            user_format($_user);
                            unset(
                                $_user['create_date'],
                                $_user['login_date'],
                                $_user['create_ip'],
                                $_user['login_ip'],
                                $_user['avatar'],
                                $_user['create_ip_fmt'],
                                $_user['create_date_fmt'],
                                $_user['login_ip_fmt'],
                                $_user['login_date_fmt']
                            );
                        }
                        message(0, [
                            'message' => '已找到用户：',
                            'users_list' => $search_result,
                        ]);
                    } else {
                        message(2, [
                            'message' => '未找到用户',
                            'users_list' => [],
                        ]);
                    }
                }
            } else {
                message(1, 'Get request only');
                die;
            }
        } else {
            message(-1, '请登录后再使用本功能');
            die;
        }
    }
