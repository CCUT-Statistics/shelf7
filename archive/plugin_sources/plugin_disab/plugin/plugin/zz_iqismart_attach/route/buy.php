<?php
!defined('DEBUG') AND exit('Access Denied.');

if(empty($uid)){
    message(-1, jump('请先登录', http_url_path().url('user-login'), 2));
    return;
}


$aid = param('aid');
$attach = attach_read($aid);
$buyer = user_read($attach['uid']);
$thread = thread_read($attach['tid']);

if($attach['credits'] > 0 ||$attach['golds'] > 0  || $attach['rmbs'] > 0  ){
	
}else{
  message(-1,jump('该附件免费无需支付,即将自动下载...', url('attach-download-'.$aid), 2));
}

if($attach['credits'] > 0){
	$type = 'credits';
    $count = $attach['credits'];
}
if($attach['golds'] > 0){
	$type = 'golds';
  $count = $attach['golds'];
}
if($attach['rmbs'] > 0  ){
	$type = 'rmbs';
  $count = $attach['rmbs'];
}

if(empty($user['mobile'])  && $type == 'rmbs' && $buyer['gid'] > 10){
	message(-1, jump('人民币交易，请先绑定手机号。', url('my-mobile')));die;
}

$buy = db_find_one('attach_buy', array('uid' => $uid,'aid' => $aid));
if(empty($buy)) {
  if($type == 'credits'){
    if( $user['credits'] < $count ){
      message(-1, jump('积分不足！请充值！',url('my-pay')) );
    }
  }elseif($type == 'golds'){
    if( $user['golds'] < $count ){
      message(-1,  jump('金币不足！请充值！',url('my-pay'))  );
    }
  }elseif($type == 'rmbs'){
    if( $user['rmbs'] < $count ){
      message(-1, jump('人民币不足！请充值！',url('my-pay'))  );
    }
  }
  
  $str = '经验';
  $countStr;
  if($type == 'credits'){
     $str = '经验';
    $countStr = round($count,2);
    user_update($uid,array('credits' => ($user['credits'] - $count) ));
    user_update($buyer['uid'],array('credits' => ($buyer['credits'] + $count) ));	
 
  }elseif($type == 'golds'){
     $str = '金币';
     $countStr = round($count,2);
    user_update($uid,array('golds' => ($user['golds'] - $count) ));
    user_update($buyer['uid'],array('credits' => ($buyer['golds'] + $count) ));	
 
  }elseif($type == 'rmbs'){
     $str = '人民币';
     $countStr = round($count/100,2);
    user_update($uid,array('rmbs' => ($user['rmbs'] - $count) ));
    user_update($buyer['uid'],array('credits' => ($buyer['rmbs'] + $count) ));
         
  }
  $url = $_SERVER['SERVER_NAME'].'/'.url('thread-'.$attach['tid']);
  notice_send($uid, $buyer['uid'], '花费'.$countStr.$str.'购买了你的附件《'.$attach["orgfilename"].'》，所在主题 <a href="'. $url.'">'.$thread['subject'].'</a>', 3); // 3:系统通知
   send_weixin_notice($buyer['uid'],$user['username'].'花费'.$countStr.$str.'购买了你的附件《'.$attach["orgfilename"].'》', $url,'附件被购买','购买成功','所在主题:'.$thread['subject']);
  
  db_create('attach_buy', array('uid' => $uid,'aid' => $aid));
  
  
  
  message(0,jump('购买成功,即将自动下载...', url('attach-download-'.$aid), 2));
}else{
message(0,jump('你已购买过该附件,即将自动下载...', url('attach-download-'.$aid), 2));
}


?>