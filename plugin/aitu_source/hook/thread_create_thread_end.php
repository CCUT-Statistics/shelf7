<?php exit;
$source = param('source', '', FALSE);
if(!empty($source)){
	post_update($pid, array('source'=>$source));
}

?>