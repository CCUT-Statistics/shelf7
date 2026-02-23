<?php

!defined('DEBUG') AND exit('Access Denied.');
include_once _include(APP_PATH.'plugin/vaptcha_v3/util/validate.php');

if ($method == 'GET') {
    $config = getConfig();
    include_once _include(APP_PATH.'plugin/vaptcha_v3/setting.htm');
} else {
    $config = json_encode($_POST);
    setting_set('vaptcha_v3', $config);
    echo json_encode(array("code" => 1));
}
