<?php exit;
	//付费查看

	//查找付费记录
	$content_pay = db_find_one('ws_thread_pay', array('tid' => $tid, 'uid' => $uid, 'type' => 1));
	if($thread['content_golds']){
		if($preg_pay){
			for($i=0;$i<count($array[0]);$i++){
				$a = $array[0][$i];
				$b = $array[1][$i];
				if($content_pay||$thread['uid']==$uid){
					$first['message_fmt'] = str_replace($a,$b,$first['message_fmt']);
				}else{
					$first['message_fmt'] = str_replace($a,$html_pay,$first['message_fmt']);
				}
			}
		}
	}else{
		$first['message_fmt'] = str_replace(array('[pay]','[/pay]'),'',$first['message_fmt']);
	}
?>