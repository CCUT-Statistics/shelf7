<?php
function userlist_find($cond = array(), $orderby = array(), $page = 1, $pagesize = 10000){
    //if(empty($cond)) return array();
    // hook model_points_find_start.php
    $user_list = db_find('user', $cond, $orderby, $page, $pagesize);
    // hook model_points_find_end.php
    return $user_list;
}
?>