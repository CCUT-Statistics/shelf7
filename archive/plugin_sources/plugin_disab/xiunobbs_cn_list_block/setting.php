<?php 

!defined('DEBUG') AND exit('Access Denied.');

$action = param(3);
$_fid = param('post_fid', array());


if($method == 'GET') {	
//初始化设置	
$xiunobbs_cn_list_block = kv_get('xiunobbs_cn_list_block');
if(empty($xiunobbs_cn_list_block)) 
{
	
	$xiunobbs_cn_list_block = array(
	'fid'=>$_fid,
);
  kv_set('xiunobbs_cn_list_block', $xiunobbs_cn_list_block);
}	
//初始化结束

	include _include(APP_PATH.'plugin/xiunobbs_cn_list_block/setting.htm');		
} 
else
{
	$xiunobbs_cn_list_block['fid'] = $_fid;
	kv_set('xiunobbs_cn_list_block', $xiunobbs_cn_list_block);		
	
	if(in_array(z,$_fid)) {
		$replace = array();
		$replace['pagesize'] = '12';
		file_replace_var(APP_PATH.'conf/conf.php', $replace);
		
	}else if(in_array(y,$_fid)){
		$replace = array();
		$replace['pagesize'] = '24';
		file_replace_var(APP_PATH.'conf/conf.php', $replace);
	}else if(in_array(z,$_fid)){
		$replace = array();
		$replace['pagesize'] = '36';
		file_replace_var(APP_PATH.'conf/conf.php', $replace);
	}else{
		
	}
message(0, '修改成功');
	
}
	



?>
