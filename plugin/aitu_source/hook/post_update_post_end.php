<?php exit;
$source = param('source', '', FALSE);
$r = post_update($pid, array('source'=>$source));
$r === FALSE AND message(-1, lang('update_post_failed'));

?>
