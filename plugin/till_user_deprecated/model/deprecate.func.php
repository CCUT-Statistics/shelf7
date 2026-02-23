<?php

if (!function_exists("create_uuid")) {
    /**
     * 生成UUID
     *
     * @param string $prefix 前缀
     * @return string UUID xxxxxxxx-xxxx-xxxx-xxxxxx-xxxxxxxxxx (8-4-4-4-12)
     */
    function create_uuid($prefix = "") {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
        return $prefix . $uuid;
    }
}

/**
 * 停用用户
 *
 * @param int $uid 用户ID
 * @return bool
 */
function deprecate_user($uid, $delete_directly = false) {
    $new_username = 'someone' . $uid;

    if ($delete_directly) {
        $result = user_delete($uid);
    } else {
        $the_user = user_read($uid);
        $user_updated = array();
        $user_updated['deprecated'] = 1;
        $user_updated['gid'] = 0;
        //*
        foreach ($the_user as $key => $value) {
            //保留
            $key_continue = in_array($key, array('deprecated', 'uid', 'gid', 'online_status', 'groupname', 'salt', 'email', 'threads', 'posts', 'create_ip', 'create_ip_fmt', 'create_date', 'create_date_fmt', 'login_ip', 'login_date', 'login_date_fmt', 'login_ip_fmt', 'digests', 'digests_3', 'logins', 'idnumber',  'favorites', 'avatar_url'));
            //用户名
            $key_username = in_array($key, array('username', 'realname'));
            //密码
            $key_password = in_array($key, array('password', 'password_sms'));
            $key_del_int = in_array($key, array('credits', 'golds', 'rmbs', 'OK', 'v', 'vip_end', 'activities_posted', 'notices', 'unread_notices', 'avatar', 'ban', 'follows', 'fans'));
            $key_del_string = in_array($key, array('realname', 'signature', 'cover_url', 'ban_log', 'qq', 'mobile'));
            if ($key_continue) {
                continue;
            } elseif ($key_username) {
                $user_updated[$key] = $new_username;
            } elseif ($key_password) {
                $user_updated[$key] = md5(create_uuid());
            } elseif ($key_del_int) {
                $user_updated[$key] = 0;
            } elseif ($key_del_string) {
                $user_updated[$key] = '';
            } else {
                if (is_int($value)) {
                    $user_updated[$key] = 0;
                } else {
                    $user_updated[$key] = '';
                }
            }
        }
        //*/
        var_dump($user_updated);
        $result = user_update($uid, $user_updated);
        /*
        $result = user_update($uid, array(
            'deprecated' => 1,

            'gid' => 0,
            'username' => $new_username,
            'realname' => $new_username,
            'password' => create_uuid(),
            'password_sms' => create_uuid(),
            'mobile' => '',
            'qq' => '',
            'credits' => 0,
            'golds' => 0,
            'rmbs' => 0,
            'vip_end' => 0,
            'email_v' => '',
            'signature' => '',
            'cover_url' => '',
            'ban' => 0,
            'ban_log' => '',
            'OK' => 0,
            'v' => 0,
            'v_title' => '',
        ));
        */
    }

    return $result;
}