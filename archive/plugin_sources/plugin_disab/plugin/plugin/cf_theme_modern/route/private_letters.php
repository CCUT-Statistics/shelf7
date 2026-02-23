<?php
!defined('DEBUG') and exit('Access Denied.');

$header['title'] = lang('private_letters');

if ($method == 'GET') {

    include _include(APP_PATH.'plugin/cf_theme_modern/htm/private_letters.htm');

} else {
    $to_uid = param('to_uid', '');
    if (empty($to_uid)) {
        message(-1, jump(lang('user_cannot_be_empty'), 'back'));
    }

    $cf_message = param('cf_message', '');
    if (empty($cf_message)) {
        message(-1, jump(lang('data_is_empty'), 'back'));
    }

    $to_user = user_read($to_uid);
    if (empty($to_user)) {
        message(-1, jump(lang('user_not_exists'), 'back'));
    }
	if ($gid==7 || $uid==0) {
        message(-1, jump(lang('insufficient_privilege'), 'back'));
    }
	
    $message = "<div class='comment-info'>".lang('sent_you_a_message')."</div><div class='single-comment'>".$cf_message."</div>";
    notice_send($uid, $to_uid, $message, 7);     
    message(0, lang('user_send_sucessfully'));
}