<?php 
!defined('DEBUG') AND exit('Access Denied.');
$action = param(3);
if(empty($action)){

	if($method == 'GET'){//设置页面





		include _include(APP_PATH.'plugin/a_coin/setting.htm');

	}else{//提交页面
		$id = param('uid');
		$golds = param('golds');
		$user = db_find_one('user',array('username'=>$id));
		$add_golds = $golds + $user['golds'];

		$r = db_update('user', array('username'=>$id),array('golds' => $add_golds,));
		if($r)
		{
			message(0, '充值成功！');
		}
		else
		{
			message(-1, '找不到此账户！');
		}
		

		
	}

}


?>