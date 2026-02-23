<?php
/*
	Xiuno BBS 4.0 图片水印功能
	插件由查鸽信息网制作网址：http://cha.sgahz.net/
*/

!defined('DEBUG') AND exit('Forbidden');
$r = setting_delete('sg_watermark');
$r === FALSE AND message(-1, '卸载失败');

?>