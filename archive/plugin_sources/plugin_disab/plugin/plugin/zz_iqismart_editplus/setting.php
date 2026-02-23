<?php

defined('DEBUG') OR exit('Forbidden');

$header['title'] = '编辑器辅助设置';

if ($method == 'GET') {
	
	$config = setting_get('zz_iqismart_editplus'); 
	
	include _include(APP_PATH . 'plugin/zz_iqismart_editplus/view/htm/setting.htm');
	
} else {
	
	$config = array();
	
   $config['on'] = param('on', 0);
	$config['auto_save'] = param('auto_save', 0);
	$config['auto_restore'] = param('auto_restore', 0);
  	$config['save'] = param('save', 0);
	$config['restore'] = param('restore', 0);
  	$config['auto_localimg']  = param('auto_localimg', 0);
	$config['localimg'] = param('localimg', 0);
	$config['fromword'] = param('fromword', 0);
  	$config['resize'] = param('resize', 0);
 	$config['clear'] = param('clear', 0);
	setting_set('zz_iqismart_editplus', $config); 

	message(0, jump('设置保存成功', url('plugin-setting-zz_iqismart_editplus')));
	
}

?>
