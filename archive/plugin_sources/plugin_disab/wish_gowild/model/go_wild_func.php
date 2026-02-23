<?php
$wish_gowild = setting_get('wish_gowild');

//判断用户是否有权限统计
function wish_is_user_can_count($wish_uid){
    global $wish_gowild;
    if(empty($wish_gowild)){
        $wish_gowild = setting_get('wish_gowild');
    }
    if(!empty($wish_uid) &&
        !empty($wish_gowild['is_count']) && $wish_gowild['is_count'] == 'yes'
    ){
        if(!is_array($wish_gowild['group'])){
            $wish_gowild['group'] = str_replace('，', ',', $wish_gowild['group']);
            $wish_gowild['group'] = explode(',', $wish_gowild['group']);
        }
        $wish_gowild['group'] = array_map('trim', $wish_gowild['group']);
        $wish_gowild['group'] = array_filter($wish_gowild['group']);
        if(empty($wish_gowild['group']) || in_array($wish_uid, $wish_gowild['group'])){
            return true;
        }
    }
    return false;
}

//立即跳转
function jump_now($wish_url){
    header('Location: ' . $wish_url);
    exit();
}

//获取统计列表
function wish_get_go_wild_by_uid_url($uid, $url, $page, $pagesize){
    $list = db_find('go_wild', array('uid'=>$uid,'url'=>$url), array('create_time'=>-1), $page, $pagesize);
    return $list;
}

//获取统计总数
function wish_get_go_wild_count_by_uid_url($uid, $url){
    $t = db_count('go_wild', array('uid'=>$uid,'url'=>$url));
    return $t;
}

//插入统计详情
function wish_insert_go_wild_log($uid, $url, $from_url){
    $r = db_insert('go_wild', array(
        'uid'=>$uid,
        'url'=>$url,
        'from_url'=>$from_url,
        'ip'=>ip(),
        'create_time'=>date('Y-m-d H:i:s'),
    ));
    return $r;
}