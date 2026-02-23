<?php
!defined('DEBUG') AND exit('Access Denied.');
$action = param(1);
if(empty($action)) {
	$header['title'] = '卡密设置';
	$kamilist = db_sql_find("SELECT * FROM bbs_kami");
	include APP_PATH.'plugin/kami/view/shezhi.htm';
}else if ($action == 'shengcheng') {
	$weishu = param('weishu');
	$geshu = param('geshu');
	$mianzhi = param('mianzhi');
	if($weishu>10)
	{
	    message('weishu', '位数不能大于10');
	}
	empty($weishu) AND message('weishu', '位数不能为空');
	empty($geshu) AND message('geshu', '个数不能为空');
	empty($mianzhi) AND message('mianzhi', '面值不能为空');
	while ($geshu > 0) {
		$kami = xn_rand($weishu);
		$arr = array(
			'kami' => $kami,
			'mianzhi' => $mianzhi,
		);
		db_insert('kami',$arr);
		$geshu--;
	};
	message(0, '成功');
	
};
?>