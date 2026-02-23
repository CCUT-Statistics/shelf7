function threadlist_read_hot($pagesize = 20) {
$hotlist = cache_get("till_hot_threads"); //获取缓存
if (!$hotlist) {
$times_tamp_a = strtotime("-1 week"); //上周
//$times_tamp_a = mktime(0,0,0,date('m'),date('d')-1,date('Y'));//昨天
$hotlist = db_find('thread', array('create_date' => array('>' => $times_tamp_a)), array('views' => -1), 1, $pagesize, 'tid');
cache_set("till_hot_threads", $hotlist, 3600); //设置缓存 和 过期时间
return $hotlist;
}
return $hotlist;
}