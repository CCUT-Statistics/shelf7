$_uid = param(1, 0);
empty($_uid) AND $_uid = $uid;
$_user = user_read($_uid);

if (empty($_user) && !in_array($action,['login','create','logout','resetpw','resetpw_complete','send_code','synlogin',],true)) {
    header("HTTP/1.1 404 Not Found");
    include _include(APP_PATH . 'plugin/abs_theme_stately/view/htm/404.htm');
    die;
}

