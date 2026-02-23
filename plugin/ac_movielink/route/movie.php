<?php
!defined('DEBUG') AND exit('Access Denied.');
// 判断用户是否已登录
if(empty($uid)) {
    // 用户未登录，重定向到登录页面
    http_location(url('user-login'));
    } else {
        // 用户已登录，你可以获取用户名
        $user = user_read($uid);
        $username = $user['username'];
    }
include _include(APP_PATH . 'plugin/ac_movielink/view/htm/movie.htm');
