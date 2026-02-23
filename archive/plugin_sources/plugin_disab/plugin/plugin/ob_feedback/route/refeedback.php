<?php

!defined('DEBUG') and exit('Access Denied.');

$header['title'] = '发送反馈';

if ($method == 'GET') {

    include _include(APP_PATH . 'plugin/ob_feedback/htm/refeedback.htm');
} else {

    $tablepre = $db->tablepre;
    $to_uid = param('ob_uid', '');
    $ob_refeed = param('refeedback', '');
    $ob_notice_nid = param('ob_notice_nid', '');
    $ob_remessage = param('ob_remessage', '');

    $ob_notice_nid_sql = db_sql_find("SELECT * FROM {$tablepre}notice WHERE nid = $ob_notice_nid");

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

    if(!empty($ob_notice_nid_sql)){
        foreach ($ob_notice_nid_sql as $u) {
            $ob_nid = $u[message];
            if($ob_refeed == "其他" || empty($ob_refeed)){
                $message = "<div class='comment-info'>发来了消息</div><div class='single-comment'>". $ob_remessage ."</div>";
            }else{
                $message = "<div class='comment-info'>" . $ob_refeed.  "</div><div class='single-comment'>". $ob_nid ."</div><div class='single-comment'>" . $ob_remessage . "</div>";
            }
            
            notice_send($user['uid'], $to_uid, $message, 7);
        }
    }
    
    message(0, '发送成功');
}
