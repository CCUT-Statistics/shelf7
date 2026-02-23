<?php
/*
 * 奇狐网插件 安装文件
 * QQ:77798085
*/
!defined('DEBUG') AND exit('Forbidden');

$fox_notify_kv = kv_get('fox_notify');
if(empty($fox_notify_kv)) {
    $fox_notify_kv = array(
        'notice_on' => 0,
        'notice_type' => 0,
        'notice_title' => '通知',
        'notice_button' => '朕知道了',
        'notice_content' => '<p>公告测试</p>',
    );
    kv_cache_set('fox_notify', $fox_notify_kv);
}?>