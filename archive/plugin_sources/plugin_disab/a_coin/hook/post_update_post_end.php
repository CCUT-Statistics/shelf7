<?php exit;
$content_coin_status = param('content_coin_status');
$attach_coin_status = param('attach_coin_status');
$content_coin = param('content_coin');
$attach_coin = param('attach_coin');
if($content_coin_status&&$content_coin){
	db_update('thread', array('tid' => $tid), array('content_golds' => $content_coin));
}else{
	db_update('thread', array('tid' => $tid), array('content_golds' => 0));
}

if($attach_coin_status&&$attach_coin){
	db_update('thread', array('tid' => $tid), array('attach_golds' => $attach_coin));	
}else{
	db_update('thread', array('tid' => $tid), array('attach_golds' => 0));
}
?>