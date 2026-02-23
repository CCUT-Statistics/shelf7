/* =====草稿===== */
elseif ($menu_item['href'] === "__user_draft__") :
if ($uid != 0) {
$_this_item = array(
'icon' => $menu_item['icon'] ,
'name' => $menu_item['name'],
'href' => url('my-draft'),
'after' => (thread_draft_count($uid) != 0 ? ' <b class="badge badge-info">'.thread_draft_count($uid).'</b>' : '')
);
$r .= xn_nav_menu_item($_this_item, $args);
} else {
continue;
}