<?php exit;
if($action == 'reward') {
    if ($method == 'GET')
        include _include(APP_PATH . 'plugin/tt_reward/view/htm/tt_reward.htm');
    elseif ($method == 'POST') {
        if (empty($uid)) die();
        $tid = param(2, 0);
        if (empty($tid)) die();
        $_thread = thread_read($tid);
        if (empty($_thread)) die();
        if ($uid == $_thread['uid']) {
            message(-1, '您不能打赏自己的帖子！');
            die();
        }
        $credits1 = param('credits1', '0');
        $credits2 = param('credits2', '0');
        $credits3 = param('credits3', '0');
        if (empty($credits1) && empty($credits2) && empty($credits3)) {
            message(-1, '请输入打赏金额！');
            die();
        }
        $f = db_count('reward', array('uid' => $uid, 'tid' => $tid));
        if ($f) {
            message(-1, '您只能打赏一次该作者！');
            die();
        }
        $set_reward = setting_get('tt_reward');
        $limit = $set_reward['limit'];
        $use_self = $set_reward['self_use'];
        $today0 = strtotime(date('Y-m-d', time())) - 1;
        $r = db_count('reward', array('uid' => $uid, 'time' => array('>' => $today0)));
        if ($limit != '0' && $r >= $limit) {
            message(-1, '您今天打赏次数已用完，请明天再来打赏！');
            die();
        }
        if ($use_self && $credits1 > 0 && ($user['credits'] - $credits1) < 0) {
            message(-1, '您的' . lang('credits1') . '不足！');
            die();
        }
        if ($use_self && $credits2 > 0 && ($user['golds'] - $credits2) < 0) {
            message(-1, '您的' . lang('credits2') . '不足！');
            die();
        }
        if ($use_self && $credits3 > 0 && ($user['rmbs'] - $credits3) < 0) {
            message(-1, '您的' . lang('credits3') . '不足！');
            die();
        }
        if ($credits1 != 0 && ($credits1 < $group['reward_from1'] || $credits1 > $group['reward_to1'])) {
            message(-1, lang('credits1') . '超过限制！系统限制为' . $group['reward_from1'] . '~' . $group['reward_to1']);
            die();
        }
        if ($credits2 != 0 && ($credits2 < $group['reward_from2'] || $credits2 > $group['reward_to2'])) {
            message(-1, lang('credits2') . '超过限制！系统限制为' . $group['reward_from2'] . '~' . $group['reward_to2']);
            die();
        }
        if ($credits3 != 0 && ($credits3 < $group['reward_from3'] || $credits3 > $group['reward_to3'])) {
            message(-1, lang('credits3') . '超过限制！系统限制为' . $group['reward_from3'] . '~' . $group['reward_to3']);
            die();
        }
        $update_to_arr = array();
        $update_from_arr = array();
        if ($credits1 != 0) {
            $update_to_arr['credits+'] = $credits1;
            if ($use_self && $credits1 > 0) $update_from_arr['credits-'] = $credits1;
        }
        if ($credits2 != 0) {
            $update_to_arr['golds+'] = $credits2;
            if ($use_self && $credits2 > 0) $update_from_arr['golds-'] = $credits2;
        }
        if ($credits3 != 0) {
            $update_to_arr['rmbs+'] = $credits3;
            if ($use_self && $credits3 > 0) $update_from_arr['rmbs-'] = $credits3;
        }
        db_update('user', array('uid' => $_thread['uid']), $update_to_arr);
        if ($use_self) db_update('user', array('uid' => $uid), $update_from_arr);
        db_insert('reward', array('uid' => $uid, 'time' => $time, 'tid' => $tid, 'credits' => $credits1, 'golds' => $credits2, 'rmbs' => $credits3));
        db_insert('user_pay', array('uid' => $uid, 'status' => 1, 'num' => '0', 'type' => 14, 'credit_type' => '1', 'time' => time(), 'code' => $tid .tt_credits_rtn_name($credits1, $credits2, $credits3)));
        db_insert('user_pay', array('uid' => $_thread['uid'], 'status' => 1, 'num' => '0', 'type' => 15, 'credit_type' => '1', 'time' => time(), 'code' => $tid . tt_credits_rtn_name($credits1, $credits2, $credits3)));
        message(0, '打赏成功！');
    }
} elseif($action=='sReward') {
    $tid = param(2);
    include _include(APP_PATH . 'plugin/tt_reward/view/htm/tt_reward_list.htm');
    return;
}
?>