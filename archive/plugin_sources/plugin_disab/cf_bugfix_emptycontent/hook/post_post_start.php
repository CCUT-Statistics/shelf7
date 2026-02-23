<?php
exit;
$message = trim(param('message', '', FALSE));
empty($message) AND message('message', lang('please_input_message'));