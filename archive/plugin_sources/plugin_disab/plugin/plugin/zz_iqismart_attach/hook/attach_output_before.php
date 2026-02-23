 attach_downloads($aid);
    if($attach['uid'] != $user['uid'] ){
      if($attach['credits'] > 0 || $attach['golds'] > 0  || $attach['rmbs'] > 0 ){
       	$buy = db_find_one('attach_buy', array('uid' => $uid,'aid' => $aid));

       	if(empty($buy)) {message(-1, '你还没购买该附件');die();}
      }
    }