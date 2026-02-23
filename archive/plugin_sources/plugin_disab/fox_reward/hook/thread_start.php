<?php exit;
if($action == 'reward'){
    $tid = param(2);
    $thread = thread_read($tid);
    empty($thread) AND message(-1, lang('thread_not_exists'));
    $forum = forum_read($thread['fid']);
    empty($forum) AND message(3, lang('forum_not_exists'));
    empty($forum['is_reward']) AND message(-1, '本版未开启打赏权限！');
    $totalnum = fox_rewardlog_count($tid);
    $reasonlist = array(0 => '与人为善, 好运常伴！', 1 => '赠人玫瑰, 手留余香！');
    if(!empty($fox_reward_arr['fox_reward_reason'])){
        $reasonlist = fox_rewardlog_str_array($fox_reward_arr['fox_reward_reason']);
    }
    if ($method == 'GET'){
        $n = array_rand($reasonlist);
        $default_reason = $reasonlist[$n];
        include _include(APP_PATH . 'plugin/fox_reward/oddfox/theme/fox_reward.php');
        return;

    }elseif($method == 'POST'){
        $thread['uid'] == $user['uid'] AND message(-1, '不能给自己打赏！');
        if ($gid != 1){
            fox_rewardlog_read($thread['tid'], $user['uid']);
            $reward_num = fox_rewardlog_today($user['uid']);
            if($reward_num >= $fox_reward_arr['fox_reward_max_num']){
                message(-1, '您今日已经打赏'.$fox_reward_arr['fox_reward_max_num'].'次了！');
            }
        }
        $n = array_rand($reasonlist);
        $post_data = array();
        $post_data['tid'] = $tid;
        $post_data['oid'] = $thread['uid'];
        $post_data['uid'] = $user['uid'];
        $post_data['num'] = param('golds_num', 1);
        $post_data['reason'] = param('reason', '');
        $post_data['time'] = $time;
        $post_data['uip'] = $longip;
        empty($post_data['reason']) AND $post_data['reason'] = $reasonlist[$n];

        if(($post_data['num'] > $fox_reward_arr['fox_golds_num_max']) && ($gid != 1)){
            message(-1, '打赏金币数量大于允许的最高数量！');
        }
        
        if(!empty($fox_reward_arr['fox_golds_reduce'])){
            fox_add_user_log_by_thread_reward($tid, $post_data['num'], $thread['uid'], $user['uid']);
        }
        $r = db_create('fox_rewardlog', $post_data);
        $r === FALSE AND message(-1, '打赏失败');
        message(0, '打赏成功');
    }

}elseif($action == 'rewardlog'){
    if ($method == 'GET'){
        $tid = param(2);
        $page = param(3, 1);
        $thread = thread_read($tid);
        empty($thread) AND message(-1, lang('thread_not_exists'));
        $forum = forum_read($thread['fid']);
        empty($forum) AND message(3, lang('forum_not_exists'));
        empty($forum['is_reward']) AND message(-1, '本版未开启打赏权限！');
        empty($user['uid']) AND message(-1, '请先登录后再查看打赏记录!');
        $totalnum = fox_rewardlog_count($tid);
        $thread_reward_list = fox_rewardlog_find(array('tid'=>$thread['tid']), array('id'=>1), $page, 20);
        $pagination = pagination(url("thread-rewardlog-{$tid}-{page}"), $totalnum, $page, 20);
        include _include(APP_PATH . 'plugin/fox_reward/oddfox/theme/fox_rewardlog.php');
        return;
    }else {
        message(-1, 'Access Denied.');
    }
}
?>