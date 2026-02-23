<?php

/*
	Xiuno BBS 4.0 插件实例：友情链接插件安装
	admin/plugin-install-xn_friendlink.htm
*/

!defined('DEBUG') AND exit('Forbidden');

$config = array();
	
$config['on'] = 1;
$config['auto_save'] = 1;
$config['auto_restore'] = 1;
$config['save'] = 1;
$config['restore'] = 1;
$config['auto_localimg'] = 1;
$config['localimg'] = 1;
$config['fromword'] = 1;
$config['resize'] = 1;
$config['clear'] = 1;

setting_set('zz_iqismart_editplus', $config);   
?>