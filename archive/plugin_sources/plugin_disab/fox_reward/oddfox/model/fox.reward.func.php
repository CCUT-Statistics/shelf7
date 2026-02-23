<?php
function fox_rewardlog_read($tid, $uid){
    if(!empty($tid) && !empty($uid)){
        $fox_rewardlog = db_find_one('fox_rewardlog', array('tid'=>$tid, 'uid'=>$uid));
        if(!empty($fox_rewardlog)){
            return message(-1, '您已经打赏过了！');
        }
    }
}
function fox_rewardlog_count($tid){
    if( !empty($tid) ){
        $r = db_count('fox_rewardlog', array('tid'=>$tid));
    }else{
        $r = 0;
    }
    return $r;
}
function fox_rewardlog_count_golds($tid){
    global $db;
    $r = array('num' => 0);
    if( !empty($tid) ){
        $tablepre = $db->tablepre;
        $r = db_sql_find_one("select sum(num) as num from {$tablepre}fox_rewardlog where tid={$tid}");
    }
    return $r['num'];
}
function fox_rewardlog_find($cond = array(), $orderby = array(), $page = 1, $pagesize = 20, $key = 'id', $col = array()){
    $list = db_find('fox_rewardlog', $cond, $orderby, $page, $pagesize, $key, $col);
    if( !empty($list) ){
        foreach($list as &$value){
            if(!empty($value['uid'])){
                $_user = user_read($value['uid']);
                $value['username'] = $_user['username'];
                $value['user_url'] = url("user-$_user[uid]");
                $value['avatar_url'] = $_user['avatar_url'];
            }
        }
    }
    return $list;
}
function fox_rewardlog_str_array($str){
    if(!empty($str)){
      $str = trim($str);
      $array = explode("$$$", $str);
    }else{
      $array = array();
    }
    return $array;
}
function fox_add_user_log_by_thread_reward($tid, $num, $oid, $uid){
    if(!empty($tid) && !empty($num) && !empty($oid) && !empty($uid)){
        $user_find = db_find_one('user', array('uid'=>$uid), array(), array('golds'));
        if($num <= $user_find['golds']){
            user_update($uid, array('golds-'=>$num));
            user_update($oid, array('golds+'=>$num));
        }else{
            return message(-1, '您的金币不足，打赏失败！');
        }
    }
    return ;
}
function fox_rewardlog_today($uid){
    $today = strtotime(date('Y-m-d',time()));
    $reward_num = db_count('fox_rewardlog',array('uid'=>$uid, 'time'=>array('>='=>$today)));
    return $reward_num;
}
?>