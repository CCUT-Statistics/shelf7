<?php
!defined('DEBUG') AND exit('Access Denied.');

if($method == 'GET') {
	include _include(APP_PATH.'plugin/aky_gstyle/setting.htm');
	
} else {
    $op=param('op');
    if($op=='0'){
        message(0,db_sql_find('SELECT * FROM `bbs_group`'));
    }
    if($op=='1'){
        //首页和分类列表页
        //文章页面作者图标
        //回复列表页面图标
    
        //用户组图标颜色
        foreach($grouplist as $_group1){
           if($_group1['gid']==0)continue;
           $group_color = param('gc_'.$_group1['gid'], '');
           $group_fcolor = param('gf_'.$_group1['gid'], '');
           $group_size = param('gz_'.$_group1['gid'], '');
           //如果字体大小为空则填充12
           if(empty($group_size))$group_size='12';
           //执行修改
           db_update('group',array('gid'=>$_group1['gid']),array('colour'=>$group_color,'fcolour'=>$group_fcolor,'size'=>$group_size));
        }
        message(0, '配置成功');
    }
}
	
?>