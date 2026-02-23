<?php
!defined('DEBUG') AND exit('Access Denied.');
include _include(XIUNOPHP_PATH.'xn_send_mail.func.php');
$caozuo = param(1);
if ($caozuo == 'chongzhi') {
	$header['title'] = '充值';
	include APP_PATH.'plugin/kami/view/chongzhi.htm';
}else if ($caozuo == 'zhuanzhang') {
	user_login_check();
	$header['title'] = '转账';
	include APP_PATH.'plugin/kami/view/zhuanzhang.htm';
}else if ($caozuo == 'chongzhi2') {
	$youxiang = param('youxiang');
	$kahao = param('kahao');
	$kami = param('kami');
	empty($youxiang) AND message('youxiang', '邮箱不能为空');
	if(is_email($youxiang, $err)) {
		$user = user_read_by_email($youxiang);
		empty($user) AND message('youxiang', '邮箱不存在');
	} else {
		message('youxiang', '邮箱格式不对');
	}
	empty($kahao) AND message('kahao', '卡号不能为空');
	empty($kami) AND message('kami', '卡密不能为空');
	$chazhao = db_find_one('kami',array('kahao'=>$kahao,'kami'=>$kami));
	empty($chazhao) AND message(-1, '卡号或卡密错误');
	if ($chazhao['uid'] != 0) message(-1, '卡密已经使用');
	$jieguo = db_update('kami',array('kahao'=>$chazhao['kahao']),array('uid'=>$user['uid'],'riqi'=>date('y-m-d h:i:s',time())));
	if ($jieguo == FALSE) message(-1, '数据库写入出错');
	$user['golds'] += $chazhao['mianzhi'];
	db_update('user',array('uid'=>$user['uid']),array('golds'=>$user['golds']));
	message(0, '充值成功');
}else if ($caozuo == 'zhuanzhang2') {
	$user = user_read($uid);
	user_login_check();
	$method != 'POST' AND message(-1, lang('method_error'));
	$youxiang = param('youxiang');
	empty($youxiang) AND message('youxiang', '对方邮箱不能为空');
	!is_email($youxiang, $err) AND message('youxiang', $err);
	$r = user_read_by_email($youxiang);
	!$r AND message('youxiang', '对方邮箱不存在,请仔细核对');
	
	// 发送邮件 | send mail
	$smtplist = include _include(APP_PATH.'conf/smtp.conf.php');
	$n = array_rand($smtplist);
	$smtp = $smtplist[$n];
	$rand = rand(100000, 999999);
	$_SESSION['zhuanzhang_yanzhengma'] = $rand;
	$subject = '转账验证码：'.$rand.' - 【'.$conf['sitename'].'】';
	$message = $subject;
	$r = xn_send_mail($smtp, $conf['sitename'], $youxiang, $subject, $message);
	if($r === TRUE) {
		message(0, lang('send_successfully'));
	} else {
		message(-1, $errstr);
	}
}else if ($caozuo == 'zhuanzhang3') {
	$user = user_read($uid);
	user_login_check();
	$method != 'POST' AND message(-1, lang('method_error'));
	// 校验数据
	$zhuanzhang_yanzhengma = _SESSION('zhuanzhang_yanzhengma');
	empty($zhuanzhang_yanzhengma) AND message(-1, '请先发送验证码');
	
	$youxiang_duifang = param('youxiang');
	empty($youxiang_duifang) AND message('youxiang', '对方邮箱不能为空');
	!is_email($youxiang_duifang, $err) AND message('youxiang', $err);
	$user_duifang = user_read_by_email($youxiang_duifang);
	!$user_duifang AND message('youxiang', '对方邮箱不存在,请仔细核对');
	$jine = param('jine');
	empty($jine) AND message('jine', '转账金额不能为空');
	$yanzhengma = param('yanzhengma');
	empty($yanzhengma) AND message('yanzhengma', '验证码不能为空');
	if ($yanzhengma != $zhuanzhang_yanzhengma) message('yanzhengma', '验证码错误');
	if ($user['golds'] < $jine) message ('jine','您当前拥有:'.$user['golds'].'N币,不足以转账,请调整转账金额或充值');
	$user['golds'] -= $jine;
	$jieguo = db_update('user',array('uid'=>$user['uid']),array('golds'=>$user['golds']));
	if ($jieguo == FALSE) message(-1, '数据库写入出错');
	$user_duifang['golds'] += $jine;
	db_update('user',array('uid'=>$user_duifang['uid']),array('golds'=>$user_duifang['golds']));
	unset($_SESSION['zhuanzhang_yanzhengma']);
	message(0, '转账成功');
	
};
?>