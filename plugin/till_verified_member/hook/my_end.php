?>

<?php
if ($action == 'vapply') {

    /**
     * @var array $PLUGIN_SETTING 插件设置
     */
    $PLUGIN_SETTING = setting_get('till_verified_member_setting');

    //前置检查
    if ($PLUGIN_SETTING['v_allow_user_apply'] == false) {
        message(0, '已停止用户申请认证，如有需要，请联系管理员。');
    }

    /**
     * @var int|string $the_uid 用户ID
     */
    $the_uid = $user['uid'];

    /**
     * @var array $current_apply 已有申请
     */
    $current_apply = v_apply_read($the_uid);

    if ($method == 'GET') {
        include _include(APP_PATH . 'plugin/till_verified_member/view/htm/my_vapply.htm');
    } elseif ($method == 'POST') {

        /**
         * @var string $the_username 用户名
         */
        $the_username = param('username', '');

        //确保要申请的用户是当前用户
        if ($the_username !== user_read_cache($the_uid)['username']) {
            message(1, 'Bad Request');
        }

        $v_level = param('v_level', 0);
        $v_title = htmlspecialchars(strip_tags(param('v_title', '', true)));
        $v_info = htmlspecialchars(strip_tags(param('v_info', '', true)));

        $type = $PLUGIN_SETTING['v_type_' . $v_level . '_credit_type'];
        $count = $PLUGIN_SETTING['v_type_' . $v_level . '_credit_amount'];

        if ($PLUGIN_SETTING['v_type_' . $v_level . '_credit_use']) {
            $typeString = '';

            if ($type == 'credits') $typeString = lang('credits1');
            if ($type == 'golds') $typeString = lang('credits2');
            if ($type == 'rmbs') $typeString = lang('credits3');
            // 查询用户还有没有积分
            if ($count > 0 && $user[$type] < $count) {
                message(-1, $typeString . '积分不足！');
            }
        }

        if (empty($v_level)) {
            message(-1, '请选择认证级别');
        }

        if (empty($v_title)) {
            message(-1, '请填写认证头衔');
        }

        if (empty($v_info)) {
            message(-1, '请填写证明信息');
        }

        // 查询用户是否有申请记录
        $v_apply = v_apply_read($the_uid);
        // 如果锁开启
        if ($PLUGIN_SETTING['v_lock_user_apply'] && (!empty($v_apply) && $v_apply['status'] === 0)) {
            message(1, '我们已收到您的认证申请，请耐心等待审核。');
            die;
        }
        //如果没有，就创建
        if (empty($v_apply)) {
            $r = v_apply_create(array(
                'uid' => $the_uid,
                'create_time' => time(),
                'v' => intval($v_level),
                'v_title' => $v_title,
                'v_info' => $v_info,
                'v_file' => '#',
                'status' => 0,
                'remark' => ''
            ));
        } else {
            //如果有，就更新
            $r = v_apply_update($the_uid, array(
                'create_time' => time(),
                'v' => $v_level,
                'v_title' => $v_title,
                'v_info' => $v_info,
                'v_file' => '#',
                'status' => 0,
                'remark' => ''
            ));
        }
        user_update($the_uid, array('v' => 0));
        if ($r) {
            if ($PLUGIN_SETTING['v_type_' . $v_level . '_credit_use']) {
                $rb = false;
                if ($count > 0) {
                    if ($type == 'credits') {
                        $rb = user_update($the_uid, array('credits' => ($user['credits'] - $count)));
                    } elseif ($type == 'golds') {
                        $rb = user_update($the_uid, array('golds' => ($user['golds'] - $count)));
                    } elseif ($type == 'rmbs') {
                        $rb = user_update($the_uid, array('rmbs' => ($user['rmbs'] - $count)));
                    }
                }
            }
            message(0, jump('提交成功！请耐心等待审核', url('my'), 3));
        } else {
            message(-1, '提交失败！');
        }
    }
} elseif ($action == 'vresult') {
    if ($method == 'GET') {
        include _include(APP_PATH . 'plugin/till_verified_member/view/htm/my_vapply.htm');
    }
}
