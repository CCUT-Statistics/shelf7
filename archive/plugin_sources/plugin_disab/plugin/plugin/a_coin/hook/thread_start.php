<?php exit;
if($action == 'contentPay'){
	$tid = param(2);
	$content_pay = db_find_one('ws_thread_pay', array('tid' => $tid, 'uid' => $uid, 'type' => 1));
	if(!$content_pay){
		//检测是否登录
		if(!$user) message(-1, jump('请先登录后付费！', url('user-login'), 2));
		
		//检测帖子是否存在
		$thread = thread_read($tid);
		empty($thread) AND message(-1, lang('thread_not_exists:'));

		//检测余额是否充足
		if($thread['content_golds']!=0 && $user['golds']<$thread['content_golds']){
			message(-1, jump('余额不足！', http_referer(), 2));
		}

		//进行扣费并记录
		db_insert('ws_thread_pay',array('tid' => $tid, 'uid' => $uid, 'coin' => (int)$thread['content_golds'], 'type' => 1, 'paytime' => time()));
		$now_golds = $user['golds']-$thread['content_golds'];
		db_update('user', array('uid' => $uid), array('golds' => $now_golds));

		//把金币给发帖人
		$origin = db_find_one('user', array('uid' => $thread['uid']));
		$current = $origin['golds']+$thread['content_golds'];
		db_update('user', array('uid' => $thread['uid']), array('golds' => $current));
		
		message(0, jump('付费成功！', url('thread-'.$tid), 2));
	}else{
		message(0, jump('已付费！', url('thread-'.$tid), 1));
	}
}
?>