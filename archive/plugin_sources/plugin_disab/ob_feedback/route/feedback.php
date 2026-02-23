<?php

!defined('DEBUG') and exit('Access Denied.');

$header['title'] = '发送反馈';

if ($method == 'GET') {

    include _include(APP_PATH . 'plugin/ob_feedback/htm/feedback.htm');
} else {
    $ob_thread_subject = param('ob_thread_subject', '');
    $ob_thread_url = param('ob_thread_url', '');

    $ob_thread = '<a target="_blank" href="'.$ob_thread_url.'">' . $ob_thread_subject . '</a>';
    $to_uid = param('to_uid', '');
    $ob_feed = param('feedback', '');
    $ob_message = param('ob_message', '');

    $tablepre = $db->tablepre;


    if (empty($to_uid)) {
        message(1, jump('用户不能为空', 'back'));
    }

    if (empty($ob_message)  && $ob_feed == "其他") {
        message(1, jump('发送内容不能为空', 'back'));
    }

    $to_user = user_read($to_uid);
    if (empty($to_user)) {
        message(1, jump('用户不存在，请确认后重试', 'back'));
    }


    $message = "<div class='comment-info'>【" . $ob_feed . "】《" . $ob_thread . "》</div><div class='single-comment'>" . $ob_message . "</div>";

    //查找管理员和超版，发送一份反馈
    $ob_gid = db_sql_find("SELECT * FROM {$tablepre}user WHERE gid = '1' or gid = '2'");
    if (!empty($ob_gid)) {
        foreach ($ob_gid as $u) {
            notice_send($uid, $u[uid], $message, 66);
        }
    }

    //判断用户id，不是管理员就发出反馈，防止重复发送
    $ob_uid = db_sql_find("SELECT * FROM {$tablepre}user WHERE uid = $to_uid");
    if (!empty($ob_uid)) {
        foreach ($ob_uid as $u) {
            if ($u[gid] != 1 && $u[gid] != 2) {
                if($ob_feed != "侵权投诉"){
                    notice_send($uid, $to_uid, $message, 66);
                }
            }
        }
    }


    message(0, '发送成功');
}
