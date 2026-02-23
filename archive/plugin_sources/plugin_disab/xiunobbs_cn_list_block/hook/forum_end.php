<?php 
	exit;
	$ax_kv = kv_get('xiunobbs_cn_list_block');
    $_fid = $ax_kv['fid'];
	if(in_array($fid,$_fid) && in_array($fid,$_fid)) {
	    include _include(APP_PATH.'plugin/xiunobbs_cn_list_block/htm/forum.htm');exit;
	}
?>