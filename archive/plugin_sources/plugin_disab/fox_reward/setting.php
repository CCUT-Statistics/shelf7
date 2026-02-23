<?php
/*
 * 奇狐网插件 安装文件
 * QQ:77798085
 */

!defined('DEBUG') AND exit('Access Denied.');

if($method == 'GET'){
    
    $input = array();
    $forums = forum__find();
    $input['fox_golds_num_max'] = form_text('fox_golds_num_max', !empty($fox_reward_arr['fox_golds_num_max']) ? $fox_reward_arr['fox_golds_num_max'] : '');
    $input['fox_reward_max_num'] = form_text('fox_reward_max_num', !empty($fox_reward_arr['fox_reward_max_num']) ? $fox_reward_arr['fox_reward_max_num'] : '');
    $input['fox_golds_reduce'] = form_select('fox_golds_reduce', array(0=>'不扣打赏者金币', 1=>'扣除打赏者金币'), !empty($fox_reward_arr['fox_golds_reduce']) ? $fox_reward_arr['fox_golds_reduce'] : 0);
    $input['fox_reward_reason'] = form_textarea('fox_reward_reason', !empty($fox_reward_arr['fox_reward_reason']) ? $fox_reward_arr['fox_reward_reason'] : '', '100%', 100);
    include _include(APP_PATH.'plugin/fox_reward/oddfox/theme/fox_admin_setting.php');
    
}elseif($method == 'POST'){
    
    $input = array();
    $input['fox_golds_num_max'] = param('fox_golds_num_max', 0);
    $input['fox_reward_max_num'] = param('fox_reward_max_num', 0);
    $input['fox_golds_reduce'] = param('fox_golds_reduce', 0);
    $input['fox_reward_reason'] = param('fox_reward_reason', '');
    kv_cache_set('fox_reward', $input);
    
    $is_reward_arr = param('is_reward', array(0));
    $tablepre = $db->tablepre;
    db_update('forum', array(), array('is_reward'=>0));
    if(!empty($is_reward_arr)){
        $is_reward = implode(',', $is_reward_arr);
        $sql = "UPDATE {$tablepre}forum SET is_reward='1' WHERE `fid` in ($is_reward);";
        db_exec($sql);
    }
    forum_list_cache_delete();    
    message(0, lang('modify_successfully'));
    
}else{
    message(-1, 'Access Denied.');
}
?>