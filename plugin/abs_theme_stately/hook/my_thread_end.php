//<?php
    if (function_exists('search_type') && !empty(param('search_subject', ''))) {
        $tablepre = isset($db) ? $db->tablepre : 'bbs_';

        $threadlist = array();
        $keyword = param('search_subject', '');
        $page = param('search_page', 1);
        $keyword_decode = search_keyword_safe(xn_urldecode($keyword));
        $keyword_arr = explode(' ', $keyword_decode);

        $search_conf = kv_get('search_conf');
        $search_type = $search_conf['type'];
        $search_range = $search_conf['range'];

        $range = 1;
        $pagesize = $conf['pagesize'] ?? 20;

        if (!function_exists('search_thread_by_fulltext_and_uid')) {

            function search_thread_by_fulltext_and_uid($keyword_decode_against, $uid, $start, $pagesize) {

                global $forumlist, $gid, $uid;

                // 限制递归调用次数
                static $call_count = 0;
                if ($call_count++ > 5) {return array();}

                $arrlist = db_sql_find("SELECT * FROM bbs_thread_search WHERE MATCH(message) AGAINST ('$keyword_decode_against' IN BOOLEAN MODE) ORDER BY tid DESC LIMIT $start, $pagesize;");
                // echo "SELECT * FROM bbs_thread_search WHERE MATCH(message) AGAINST ('$keyword_decode_against' IN BOOLEAN MODE) LIMIT $start, $pagesize;";exit;
                $tids = arrlist_values($arrlist, 'tid');
                $threadlist = thread_find_by_tids($tids);
                $threadlist = arrlist_multisort($threadlist, 'tid', FALSE);

                $count_before = count($threadlist);
                thread_list_access_filter($threadlist, $gid);
                $count_after = count($threadlist);

                // 如果过滤超过了一半，则从数据库中加大 $pagesize 再取。
                $less_number = $pagesize / 2;
                if ($count_before - $count_after > $less_number) {
                    $pagesize *= 2;
                    $threadlist = search_thread_by_fulltext_and_uid($keyword_decode_against, $uid, $start, $pagesize);
                }

                return $threadlist;
            }
        }

        if ($search_type == 'fulltext') {
            $keyword_decode_against = search_cn_encode($keyword_decode);
            $keyword_decode_against = '+' . str_replace(' ', ' +', $keyword_decode_against);


            $arr = db_sql_find_one("SELECT COUNT(*) AS num FROM bbs_thread_search WHERE MATCH(message) AGAINST ('$keyword_decode_against' IN BOOLEAN MODE)");
            $total = $arr['num'];

            $pagination = pagination(url("search-$keyword-$range-{page}"), $total, $page, $pagesize);

            $start = ($page - 1) * $pagesize;
            $threadlist = search_thread_by_fulltext_and_uid($keyword_decode_against, $uid, $start, $pagesize);

            $the_url = url("my-thread",['search_subject'=>$keyword]);
            $the_url_pagination = http_build_query(['search_page'=>'__page__']);
            $sep = strpos($the_url, '?') === FALSE ? '?' : '&';

            $pagination = pagination($the_url . $sep . str_replace('__page__','{page}',$the_url_pagination), $total, $page, $pagesize);


            foreach ($threadlist as &$thread) {
                $thread['subject'] = search_keyword_highlight($thread['subject'], $keyword_arr);
            }
        } elseif ($search_type == 'like') {
            $total_arr = db_sql_find_one(
                "select COUNT(*) AS `num` from "
                . $tablepre
                . "thread where uid = " . $uid . " and subject like '%"
                . $keyword_decode
                . "%';"
            );
            $total = intval($total_arr['num']);
            $threadlist = db_sql_find(
                "select * from "
                . $tablepre
                . "thread where uid = " . $uid . " and subject like '%"
                . $keyword_decode
                . "%' limit "
                . max(0,(($page - 1) * $pagesize))
                . ', '
                . $pagesize
                . ';'
            );
            $threadlist = arrlist_multisort($threadlist, 'tid', FALSE);
            foreach ($threadlist as &$thread) {
                thread_format($thread);
                $thread['subject'] = search_keyword_highlight($thread['subject'], $keyword_arr);
            }
            $the_url = url("my-thread",['search_subject'=>$keyword]);
            $the_url_pagination = http_build_query(['search_page'=>'__page__']);
            $sep = strpos($the_url, '?') === FALSE ? '?' : '&';

            $pagination = pagination($the_url . $sep . str_replace('__page__','{page}',$the_url_pagination), $total, $page, $pagesize);

        } else {
            message(-1, 'Bad Request｛' . __LINE__ . '｝');
        }
    }
