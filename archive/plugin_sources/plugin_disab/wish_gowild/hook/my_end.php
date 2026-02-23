//<?
elseif($action == 'count'){
    $act = param('act');
    if($act == 'detail'){
        // hook my_gowild_count_detail_start.php

        $page = param(2, 1);
        $pagesize = 20;
        $wish_url = xn_urldecode(param('url'));
        $totalnum = param('t');
        $totalnum = $totalnum ? $totalnum : wish_get_go_wild_count_by_uid_url($uid, $wish_url);

        // hook my_gowild_count_detail_list_before.php

        $wish_url_encode=xn_urlencode($wish_url);
        $pagination = pagination(url('my-count-{page}')."?act=detail&t={$totalnum}&url=$wish_url_encode", $totalnum, $page, $pagesize);
        $wishlist = wish_get_go_wild_by_uid_url($uid, $wish_url, $page, $pagesize);

        // hook my_gowild_count_detail_end.php

        include _include(APP_PATH.'plugin/wish_gowild/view/htm/my_count_detail.htm');
    } else {
        // hook my_gowild_count_start.php

        $page = param(2, 1);
        $pagesize = 20;
        $wish_count_data = kv_cache_get('wish_gowild_count_data');
        $wish_count_data = isset($wish_count_data[$uid]) ? array_reverse($wish_count_data[$uid], true) : array();
        $totalnum = count($wish_count_data);

        // hook my_gowild_count_list_before.php

        $pagination = pagination(url('my-count-{page}'), $totalnum, $page, $pagesize);
        $page = max(1, $page);
        $offset = ($page - 1) * $pagesize;
        $countlist = array_slice($wish_count_data, $offset, $pagesize, true);

        // hook my_gowild_count_end.php

        include _include(APP_PATH.'plugin/wish_gowild/view/htm/my_count.htm');
    }
}
