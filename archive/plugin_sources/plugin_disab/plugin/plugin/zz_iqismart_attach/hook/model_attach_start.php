// downloads + 1
function attach_downloads($aid, $n = 1) {
    global $conf;
    $sqladd = strpos($conf['db']['type'], 'mysql') === FALSE ? '' : ' LOW_PRIORITY';
    $r = db_exec("UPDATE$sqladd `bbs_attach` SET downloads=downloads+$n WHERE aid='$aid'");
    return $r;
}