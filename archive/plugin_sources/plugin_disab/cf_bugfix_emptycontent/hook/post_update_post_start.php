<?php
exit;
$subject = trim(htmlspecialchars(param('subject', '', FALSE)));
$inputmsg = str_replace(array("<p>","","</p>"),"",param('message', '', FALSE));
if( trim(str_replace("&nbsp;","",$inputmsg)) == "" ){
  message('message', lang('please_input_message'));
}
if($isfirst) {empty($subject) AND message('subject', lang('please_input_subject'));}