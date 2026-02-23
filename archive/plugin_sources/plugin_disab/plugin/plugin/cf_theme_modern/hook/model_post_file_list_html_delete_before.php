<?php
exit;

$s .= "<span class='text-grey ml-1'>(".lang('post_attach_date')."：".date('Y-m-d H:i:s', $attach['create_date'])."，".lang('post_attach_filesize')."：".humansize($attach['filesize'])."，".lang('post_attach_downloads')."：".intval($attach['downloads']).")</span>";

?>
