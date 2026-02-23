<?php
/*
 * 奇狐网插件 配置文件
 * QQ:77798085
*/

!defined('DEBUG') AND exit('Access Denied.');

$fox_notify_error1 = '请先<a href="'.url("plugin-install-fox_notify").'" class="text-danger">安装'.$plugins['fox_notify']['name'].'</a>，您已将该插件卸载。';
$fox_notify_error2 = '请先<a href="'.url("plugin-enable-fox_notify").'" class="text-danger">开启'.$plugins['fox_notify']['name'].'</a>，您已将该插件禁用。';
empty($plugins['fox_notify']['installed']) AND message(-1, $fox_notify_error1);
empty($plugins['fox_notify']['enable']) AND message(-1, $fox_notify_error2);

if ($method == 'GET'){
    
    $fox_notify_kv = kv_cache_get('fox_notify');
    $input = array();
    $input['notice_on'] = form_radio('notice_on', array(1=>'开启', 0=>'关闭'), $fox_notify_kv['notice_on']);
    $input['notice_type'] = form_radio('notice_type', array(1=>'一直显示', 0=>'关闭后24小时内不再显示'), $fox_notify_kv['notice_type']);
    $input['notice_title'] = form_text('notice_title', $fox_notify_kv['notice_title']);
    $input['notice_button'] = form_text('notice_button', $fox_notify_kv['notice_button']);
    $input['notice_content'] = form_textarea('notice_content', $fox_notify_kv['notice_content'], '100%', 100);
    
    $header['title'] = $plugins['fox_notify']['name'] . '_' . $conf['sitename'];
    $header['mobile_title'] = $plugins['fox_notify']['name'] . '_' . $conf['sitename'];
    include _include(APP_PATH.'plugin/fox_notify/oddfox/core/fox_setting.php');
    
}elseif($method == 'POST'){

    $fox_notify_kv = array();
    $fox_notify_kv['notice_on'] = param('notice_on', 0);
    $fox_notify_kv['notice_type'] = param('notice_type', 0);
    $fox_notify_kv['notice_title'] = param('notice_title', '', FALSE);
    $fox_notify_kv['notice_button'] = param('notice_button', '', FALSE);
    $fox_notify_kv['notice_content'] = param('notice_content', '', FALSE);
    kv_cache_set('fox_notify', $fox_notify_kv);
    message(0, '设置成功');

}else {
    message(-1, 'Access Denied.');
}
?>