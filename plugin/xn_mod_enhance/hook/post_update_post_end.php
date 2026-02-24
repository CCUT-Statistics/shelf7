<?php exit;



// 增加一条编辑历史 $pid, $uid, $time, $message
$update_reason = trim(param('update_reason'));
$logid = post_update_log_create(array(
	'pid' => intval($pid),
	'uid' => intval($uid),
	'create_date' => intval($time),
	'reason' => $update_reason,
	'message' => array_value($post, 'message_fmt', ''),
));

if($logid) {
	$update = array();
	isset($post['updates']) AND $update['updates+'] = 1;
	isset($post['last_update_uid']) AND $update['last_update_uid'] = intval($uid);
	isset($post['last_update_date']) AND $update['last_update_date'] = intval($time);
	isset($post['last_update_reason']) AND $update['last_update_reason'] = $update_reason;
	!empty($update) AND post__update($pid, $update);
}

?>