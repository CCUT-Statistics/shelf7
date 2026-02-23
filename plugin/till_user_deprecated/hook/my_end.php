<?php
exit;
if ($action == 'deprecate') {
    if ($user && (isset($user['deprecated']) && boolval($user['deprecated']) == true)) {
        $uid = 0;
        $_SESSION['uid'] = $uid;
        user_token_clear();
        message(0, jump(lang('user_is_deprecated'), url('user-logout'), 5));
    }

    $till_user_deprecated_setting = setting_get('till_user_deprecated_setting');
    $check_usergroups = $till_user_deprecated_setting['usergroup_allowed'];
    if ($method == 'GET') {
        include _include(APP_PATH . 'plugin/till_user_deprecated/view/htm/my_deprecate.htm');
    } elseif ($method == 'POST') {

        $the_username = param('myusername', '');
        $the_uid = param('myuid', 0);
        if (in_array($gid, $check_usergroups)) {
            if ($the_username == $user['username'] && $the_uid == $user['uid']) {
                $r = deprecate_user($user['uid'], $till_user_deprecated_setting['delete_account_directly']);
                if ($r) {
                    message(0, jump('Goodbye!', url('user-logout'), 1));
                } else {
                    message(1, 'Internal Server Error');
                }
            } else {
                message(1, lang("Please enter the correct username"));
            }
        } else {
            message(1, "Bad Request");
        }
    }
}