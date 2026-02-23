<?php

/*
	Xiuno BBS 4.0 图片水印功能
	插件由查鸽信息网制作网址：http://cha.sgahz.net/
*/
!defined('DEBUG') AND exit('Forbidden');
// 初始化
$kv = setting_get('sg_watermark');
if(!$kv) {
	$kv = array('type'=>'1', 'position'=>'9', 'format'=>array('gif'=>1,'jpg'=>1,'jpeg'=>1,'png'=>1), 'text'=>'查鸽信息网 http://cha.sgahz.net/', 'size'=>'16', 'color'=>'#FF0000', 'font'=>'t1.ttf', 'width'=>'0');
	setting_set('sg_watermark', $kv);
}
?>