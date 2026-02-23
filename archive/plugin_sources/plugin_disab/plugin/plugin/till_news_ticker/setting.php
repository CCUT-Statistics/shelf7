<?php

!defined('DEBUG') AND exit('Access Denied.');
$setting = setting_get('till_news_ticker_setting');
$profile = json_decode(file_get_contents(APP_PATH."plugin/till_news_ticker/"."conf.json"),true );

$action = param(3);
if(empty($action)) {
	//查
	$linklist = $setting['links'];
	$maxid = count($linklist)-1;
	if($method == 'GET') {
		$input = array();
		$input['single_time'] = form_text('single_time',$setting['single_time']);
		$input['delete_setting_on_uninstall'] = form_radio_yes_no('delete_setting_on_uninstall',$setting['delete_setting_on_uninstall']);
	
		include _include(APP_PATH.'plugin/till_news_ticker/setting.htm');
	} else {
		$rowidarr = param('rowid', array(0));
		$namearr = param('name', array(''));
		$urlarr = param('url', array(''));
		$iconarr = param('icon', array(''));
		$arrlist = array();
		foreach($rowidarr as $k=>$v) {
			if(empty($namearr[$k]) && empty($urlarr[$k]) && empty($iconarr[$k])) continue;
			$arr = array(
							'linkid'=>$k,
							'name'=>$namearr[$k],
							'url'=>$urlarr[$k],
							'icon'=>$iconarr[$k],
						);
			if(!isset($linklist[$k]) && is_null($linklist[$k])) {
				//增
				array_push($linklist,$arr);
			} else {
				//改
				$linklist[$k] = $arr;
			}
		}
		//删
		foreach ($setting['links'] as $key => $value) {
			if(!isset($rowidarr[$key]) ) {
				unset($linklist[$key]);
			}
		}
		$setting['links'] = $linklist;
		$setting['single_time'] = param('single_time', '', FALSE);
		$setting['delete_setting_on_uninstall'] = param('delete_setting_on_uninstall', '', FALSE);

		setting_set('till_news_ticker_setting', $setting);
		message(0, '修改成功');
	}
}