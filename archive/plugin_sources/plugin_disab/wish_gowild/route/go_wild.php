<?php
/*
 * 外链跳转页面
 * @copyright (c) wilson all rights reserved
 */

!defined('DEBUG') AND exit('Access Denied.');

if(strlen($_SERVER['REQUEST_URI']) > 800 ||
    strpos($_SERVER['REQUEST_URI'], "eval(")!==false ||
    strpos($_SERVER['REQUEST_URI'], "base64")!==false) {
    @header("HTTP/1.1 414 Request-URI Too Long");
    @header("Status: 414 Request-URI Too Long");
    @header("Connection: Close");
    @exit;
}

$wish_go_url = xn_urldecode(param('url'));
$wish_thread_uid = param('u');
$wish_from_url = xn_urldecode(param('fr'));
$wish_go_now = param('g');

if (!empty($wish_go_url)){
    //$header['title'] = '即将跳转到外部网站,请稍候...';
    $wish_url = $wish_go_url;
}else{
    //$header['title'] = '参数错误，请重试...';
    $wish_url = '';
}

if(empty($wish_gowild)){
    $wish_gowild = setting_get('wish_gowild');
}

//统计跳转次数
if(!empty($wish_url) && wish_is_user_can_count($wish_thread_uid)){
    //记录外链跳转详情
    if(empty($wish_gowild['is_count_detail']) || $wish_gowild['is_count_detail'] == 'yes'){
        wish_insert_go_wild_log($wish_thread_uid, $wish_url, $wish_from_url);
    }

    //记录统计数据
    $wish_gowild_data = kv_cache_get('wish_gowild_count_data');
    if(empty($wish_gowild_data[$wish_thread_uid][$wish_url]['count'])){
        $wish_gowild_data[$wish_thread_uid][$wish_url]['count'] = 0;
    }
    $wish_gowild_data[$wish_thread_uid][$wish_url]['count']++;
    kv_cache_set('wish_gowild_count_data', $wish_gowild_data);
}

//g=n时强制立即跳转
if($wish_go_now == 'n'){
    jump_now($wish_url);
}

//开启了立即跳转时，立即跳转
if(empty($wish_gowild['jump_now']) || $wish_gowild['jump_now'] == 'yes'){
    jump_now($wish_url);
}

if(empty($wish_gowild['safe_tips']) || $wish_gowild['safe_tips'] == 'yes'){
    //开启安全提示时，跳转到安全提示页面
    include _include(APP_PATH.'plugin/wish_gowild/view/htm/go_wild.htm');
} else {
    //其他情况，立即跳转
    jump_now($wish_url);
}

?>