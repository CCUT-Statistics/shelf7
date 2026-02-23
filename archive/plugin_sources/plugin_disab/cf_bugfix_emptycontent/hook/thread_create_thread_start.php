<?php
exit;
$subject = trim(param('subject'));
empty($subject) AND message('subject', lang('please_input_subject'));
$inputmsg = str_replace(array("<p>","","</p>"),"",param('message', '', FALSE));
if( trim(str_replace("&nbsp;","",$inputmsg)) == "" ){
  message('message', lang('please_input_message'));
}