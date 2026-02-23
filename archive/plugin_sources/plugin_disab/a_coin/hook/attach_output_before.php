<?php exit; 
	$attach_pay = db_find_one('ws_thread_pay', array('tid' => $tid, 'uid' => $uid, 'type' => 2));
	if(!$attach_pay&&$uid!=$thread['uid']){
		//检测是否登录
		if(!$user) message(-1, jump('请先登录后付费！', url('user-login'), 2));

		//检测余额是否充足
		if($thread['attach_golds']!=0 && $user['golds']<$thread['attach_golds']){
			message(-1, jump('余额不足！', url('thread-'.$tid), 2));
		}

		//进行扣费并记录
		db_insert('ws_thread_pay',array('tid' => $tid, 'uid' => $uid, 'coin' => (int)$thread['attach_golds'], 'type' => 2, 'paytime' => time()));
		$now_golds = $user['golds']-$thread['attach_golds'];
		db_update('user', array('uid' => $uid), array('golds' => $now_golds));

		//把金币给发帖人
		$origin = db_find_one('user', array('uid' => $thread['uid']));
		$current = $origin['golds']+$thread['attach_golds'];
		db_update('user', array('uid' => $thread['uid']), array('golds' => $current));

		message(0, jump('付费成功！', url('thread-'.$tid), 1));
	}
?>