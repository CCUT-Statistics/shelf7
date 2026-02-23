$fid = param(1, 0);
$page = param(2, 1);
$forum = forum_read($fid);

if(!(param(1, '') === 'get_custom_fields' || param(1, '') === 'enter_magic_word')) {
    if (empty($forum)) {
        header("HTTP/1.1 404 Not Found");
        include _include(APP_PATH . 'plugin/abs_theme_stately/view/htm/404.htm');
        die;
    }
}

