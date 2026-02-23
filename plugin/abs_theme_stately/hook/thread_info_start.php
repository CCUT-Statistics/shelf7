

$thread = thread_read($tid);

if (empty($thread)) {
    header("HTTP/1.1 404 Not Found");
    include _include(APP_PATH . 'plugin/abs_theme_stately/view/htm/404.htm');
    die;
}

