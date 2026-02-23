<?php
!defined('DEBUG') AND exit('Access Denied.');
if ($method == 'GET') {
    $pconfig = kv_get('nciaer_pushbaidu');
    $gids = $pconfig['gids'] ? $pconfig['gids'] : array();
    $token = $pconfig['token'];
    include _include(APP_PATH . 'plugin/nciaer_pushbaidu/setting.htm');
} else {
    $token = param('token');
    $gids = param('gids', array());
    $pconfig = array();
    $pconfig['token'] = $token;
    $pconfig['gids'] = $gids;
    kv_set('nciaer_pushbaidu', $pconfig);

    message(0, '提交成功！');
}
