<?php 
	exit;
	$ax_kv = kv_get('xiunobbs_cn_list_block');
    $_fid = $ax_kv['fid'];
	if(in_array(a,$_fid)) {
	    include _include(APP_PATH.'plugin/xiunobbs_cn_list_block/htm/index.htm');exit;
	}
?>