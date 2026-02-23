
//添加个人中心路径
if($action == 'name') {
	if($method == 'GET') {
		include _include(APP_PATH.'plugin/ajuyu_com_name/view/htm/my_name.htm');
	} elseif($method == 'POST') {

		// 验证是否拥有需要消耗数量的积分
		$my_golds	=	$user['golds'];		//账户剩余金币
		$my_rmbs	=	$user['rmbs'];		//账户剩余人民币
		$username_new = param('username_new');		//昵称
		//$user_golds = param('user_golds');
		empty($username_new) AND message(-1, '不可以为空');
		xn_strlen($username_new,"utf-8") > 9 AND message(-1, '不可以超过 9 个字'); // mb_strlen 非核心函数, 可能需要注意是否被禁用了	preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$username_new) AND message(-1,'不可以使用标点字符');
		preg_match('/[(\xc2\xa0)|\s]+/', $username_new) AND message(-1,'不可以使用空格　'); // 还有各种空白字符过滤呐

		// 过滤非法关键词

		$username_new == $user['username'] AND message(-1,'不可以和原来的名字相同');
		$ra = db_find_one('user', array('username' => $username_new));
		$ra != FALSE AND message(-1, '该 ID 已被占用, 请换一个' );
	// 如果改名成功, 则消耗积分
		$kv = kv_cache_get('renamesetting');		//查询设置
	    $type = $kv['type'];		//查询设置类型golds=金币rmbs=人民币
	    $count = $kv['count'];		//查询设置积分
		if($type == 'golds'){
			if($user['golds'] < $count){
			    message(-1, '金币不足！修改失败！' );
		    }
		}else if($type == 'rmbs'){
			if($user['rmbs'] < $count){
			    message(-1, '人民币不足！修改失败！' );
		    }
		}
		// 验证是否拥有需要消耗数量的积分
   	$rb = user_update($uid, array('username'=>$username_new));
		$rb === FALSE AND message(-1, '修改失败, 请重试..  如果依旧不可以, 请联系管理员 错误状态:updateFALSE');
		if($type == 'golds'){
			$user_golds = $user['golds'] - $count;
		    $rb = user_update($uid,array('golds' => $user_golds));
		    $rb === FALSE AND message(-1, '修改失败, 金币扣除失败！');
		    $user['golds'] = $user_golds;
		    $user['username'] = $username_new; // 使顶部已经获取的 ID 替换为新的, 防止用户再看到原来的 ID
		    message(0, '您好，您使用了'.$count.'个金币修改了新的昵称： '.$username_new.'.');
		}else if($type == 'rmbs'){
			$user_rmbs = $user['rmbs'] - $count;
		    $rb = user_update($uid,array('rmbs' => $user_rmbs));
		    $rb === FALSE AND message(-1, '修改失败, 金币扣除失败！');
		    $user['rmbs'] = $user_rmbs;
		    $user['username'] = $username_new; // 使顶部已经获取的 ID 替换为新的, 防止用户再看到原来的 ID
		    message(0, '您好，您使用了'.($count/100.0).'元人民币修改了新的昵称： '.$username_new.'.');
		}
		
	}
}

// 计算中文字符串长度 将字符串分解为单元 返回单元个数
function utf8_strlen($string = null) {
preg_match_all("/./us", $string, $match);
return count($match[0]);
}