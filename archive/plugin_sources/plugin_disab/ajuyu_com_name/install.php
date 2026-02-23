<?php

/*
	插件安装文件
*/

!defined('DEBUG') AND exit('Forbidden');

$kv = kv_cache_get('renamesetting');
if(!$kv) {
	$kv = array('type'=>'golds', 'count'=>1);
	kv_cache_set('renamesetting', $kv);
}

?>