<?php exit;

function pushbaidu($tid, $token) {
    $siteurl = http_url_path();
    $url = $siteurl.url('thread-'.$tid);
    $api = "http://data.zz.baidu.com/urls?site={$siteurl}&token={$token}";
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $url,
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    curl_exec($ch);
}
$pushbaidu = param('pushbaidu', 0);
$pconfig = kv_get('nciaer_pushbaidu');
$gids = $pconfig['gids'] ? $pconfig['gids']:array();
if($pushbaidu && in_array($user['gid'], $gids)) {
    pushbaidu($tid, $pconfig['token']);
}
