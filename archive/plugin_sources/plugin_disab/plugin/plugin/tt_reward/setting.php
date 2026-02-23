<?php !defined('DEBUG') AND exit('Access Denied.');
$action = param(3);
if(empty($action)) {
    if ($method == 'GET')
        include _include(APP_PATH . 'plugin/tt_reward/setting.htm');
    elseif($method=='POST'){
        $keys = array('reward_from1','reward_to1','reward_from2','reward_to2','reward_from3','reward_to3');
        $inputs = array('exp_from','exp_to','gold_from','gold_to','rmb_from','rmb_to');
        foreach($grouplist as $_group){
            $update_array=array(); $i=0;
            foreach($keys as $_k)
                $update_array[$_k] = param($inputs[$i++],array(0))[$_group['gid']];
            db_update('group',array('gid'=>$_group['gid']),$update_array);
        }
        setting_set('tt_reward',array('self_use'=>param('self_use','0'),'limit'=>param('limit','3')));
        group_list_cache_delete();
        message(0,'设置完毕！');
    }
}
?>