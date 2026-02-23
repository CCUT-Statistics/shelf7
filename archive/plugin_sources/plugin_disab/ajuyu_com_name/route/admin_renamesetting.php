<?php
!defined('DEBUG') AND exit('Access Denied.');
$action = param(1);//isset($_GET["type"])?$_GET["type"]:"";//param(1);
if(empty($action)) {
	if ($method == 'GET') {//设置页面
	  	$header['title'] = '改名设置';

	

	    //$kv = kv_cache_get('renamesetting');
	    //$jinbilx = file_get_contents($kv['type']);//金币类型
	    //$jinbisl = file_get_contents($kv['count']);//金币数量
	


	  	include _include(APP_PATH.'plugin/ajuyu_com_name/view/shezhi.htm');
	} elseif ($method == "POST") {
	    $op=param('op');
	    if($op==0) {
		    //设置参数
            $type = param('type');
          	$count = param('count');
           
          	$kv = array();
            if(!$kv) {
                $kv = array('type'=>$type, 'count'=>$count);
               	kv_cache_delete('renamesetting');
                kv_set('renamesetting', $kv);
             	  
            }

            message(0,'设置成功！');
        
        }
	
    }
}
?>