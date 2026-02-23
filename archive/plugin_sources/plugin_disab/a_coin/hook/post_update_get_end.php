<?php exit; 
// +----------------------------------------------------------------------
// | Author: feng 修改版
// +----------------------------------------------------------------------
// | 功能: 金币功能
// +----------------------------------------------------------------------
$content_coin = $thread['content_golds'];
$attach_coin = $thread['attach_golds'];
$input['attach_coin_status'] = form_radio_yes_no('attach_coin_status', $attach_coin>0?1:0);
$input['content_coin_status'] = form_radio_yes_no('content_coin_status', $content_coin>0?1:0);
?>