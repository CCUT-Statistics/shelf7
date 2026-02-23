<?php

!defined('DEBUG') AND exit('Forbidden');

$setting = setting_get('till_news_ticker_setting');
if(empty($setting)) {
	$setting = array(
		'links'=>array(
    array(
      'linkid'=>0,
      'name'=>'欢迎使用“滚动公告栏”插件！',
      'url'=>'/',
      'icon'=>'icon-spinner',
    ),
    array(
      'linkid'=>1,
      'name'=>'作者：Tillreetree；点击查看更多精品插件！',
      'url'=>'https://till.geticer.eu.org/',
      'icon'=>'icon-spinner',
    ),
    array(
      'linkid'=>2,
      'name'=>'请随意编辑这些预定义的链接吧！祝你使用愉快！',
      'url'=>'/',
      'icon'=>'icon-spinner',
    ),
			),
    'single_time'=>5,
		'delete_setting_on_uninstall'=>0
  	);
	
	setting_set('till_news_ticker_setting', $setting);
}