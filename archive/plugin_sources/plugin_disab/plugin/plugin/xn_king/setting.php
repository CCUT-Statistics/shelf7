<?php

/*
    本插件由 XIUNO爱好者制作
*/

!defined('DEBUG') AND exit('Access Denied.');
$action = param(3);
if(empty($action)){
    if($method == 'GET')
        include _include(APP_PATH.'plugin/xn_king/setting.htm');
}


	
?>