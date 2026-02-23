//<?php if (true) :
/* =====Stately主题【开始】===== */

/* =====文字分隔符（用于菜单）===== */
elseif ($menu_item['href'] === "__divider_text__") :

    if (!(isset($menu_item['submenu']) && !empty($menu_item['submenu'])) || $args['container_class'] != 'dropdown-menu') {
        $r .= '<li class="menu-header small">' . '<span class="menu-header-text">' . $menu_item['name'] . '</span>' . '</li>';
    } else {
        continue;
    }

/* =====用户菜单中的“用户头像、用户名、用户组”组合成一个菜单项===== */
elseif ($menu_item['href'] === "__user_brief__") :
    $abs_theme_stately_setting = setting_get('abs_theme_stately_setting');
    global $grouplist, $credits1_name, $credits2_name, $credits3_name;
    //*
    if ((isset($menu_item['submenu']) && !empty($menu_item['submenu'])) || stripos($args['menu_class'], 'dropdown-menu') !== false) {
        $r .= '<div class="dropdown-item">'
            . '<div class="d-flex">'
            . '<div class="flex-shrink-0 me-3 py-1">'
            . '<div class="avatar">'
            . '<a href="' . url('my') . '" class="v_avatar v_avatar-post">'
            . '<img loading=lazy decoding=async src="' . $user['avatar_url'] . '" alt="' . $user['username'] . '" class="w-px-40 h-auto rounded-circle">'
            . ( function_exists('v_show_badge' && isset($user['v']) && $user['v'] > 0) ? v_show_badge($user['v'], $user['v_title'], $till_v_settings = setting_get('till_verified_member_setting')) : '')
            . '</a>'
            . '</div>'
            . '</div>'
            . '<div class="flex-grow-1">';
            //*
        if (function_exists('vip__isvip') && vip__isvip($user['vip_end']) && function_exists('vip_read')) { //如果是VIP
            $vip_info = vip_read($uid);
            $r .= '<a href="' . url('my') . '" class="fw-semibold d-block text-danger isvip">' . $user['username'] . '</a>'
            . '<span class="fw-semibold d-inline-block isvip"><span class="badge bg-label-warning">VIP Lv.' . $vip_info['level'] . '</span></span>';
            unset($vip_info);
        } else { //普通用户
            $r .= '<a href="' . url('my') . '" class="fw-semibold d-block">' . $user['username'] . '</a>';
        }
        //*/
        $r .= <<<EOT
        // hook header_nav_user_name_after.htm
EOT;
        //*
        if ($abs_theme_stately_setting['ui_tweek']['menu_magichref_user_brief']['show_uid']) {
            $r .= '<small class="badge bg-label-primary mr-1">UID: ' . $user['uid'] . '</small>';
        }
        //*/
        //*
        if($abs_theme_stately_setting['ui_tweek']['menu_magichref_user_brief']['show_usergroup']) {
            $r .= '<small class="badge bg-label-secondary">' . $user['groupname'] . '</small>';
        }
        $r .= '</div>'
            . '</div>';
        //*
        if(isset($user['credits']) && $abs_theme_stately_setting['ui_tweek']['menu_magichref_user_brief']['show_progress']){
            $progress = 100;
            $max = 1;
            if ($user['gid'] > 100) {
                foreach ($grouplist as $group) {
                    if ($group['gid'] < 100) continue;
                    $n = $user['credits'];
                    if ($n > $group['creditsfrom'] && $n <= $group['creditsto']) {
                        $max = $group['creditsto'];
                        if ($user['groupname'] != $group['name']) {
                            $user['groupname'] = $group['name'];
                            user_update_group($uid);
                        }
                        break;
                    }
                }
                $progress = min(intval($n / $max * 100.0),100.0);
            }
            $r .= '<div class="d-flex justify-content-between small mt-2">'
                .'<span>'
                .$credits1_name.'：'
                .$user['credits']
                .'</span>'
                .'<span class="badge bg-label-primary">'
                .$progress.'%'
                .'</span>'
                .'</div>'
                .'<div class="progress mt-2" style="height:5px">'
                .'<div class="progress-bar" role="progressbar" style="width: '.$progress.'%" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100"></div>'
                .'</div>';
            unset($progress, $max);
        }
        //*/

        //*
        if ($abs_theme_stately_setting['ui_tweek']['menu_magichref_user_brief']['show_stats']) {
            $r .= '<div class="d-flex justify-content-between text-center mt-3">'
            . '<div class="d-flex flex-column">'
            . '<small class="text-muted">'
            . lang('threads')
            . '</small>'
            . '<span>'
            . $user['threads']
            . '</span>'
            . '</div>'
            . '<div class="d-flex flex-column">'
            . '<small class="text-muted">'
            . lang('posts')
            . '</small>'
            . '<span>'
            . $user['posts']
            . '</span>'
            . '</div>';
            if (isset($user['follows'])) {
                $r .= '<div class="d-flex flex-column">'
                . '<small class="text-muted"> 关注 </small>'
                . '<span>'
                . $user['follows']
                . '</span>'
                . '</div>';
            }
            if (isset($user['followeds'])) {
                $r .= '<div class="d-flex flex-column">'
                . '<small class="text-muted"> 粉丝 </small>'
                . '<span>'
                . $user['followeds']
                . '</span>'
                . '</div>';
            }
            $r .= '</div>';
        }
        //*/
        //*
        if(isset($user['credits']) && $abs_theme_stately_setting['ui_tweek']['menu_magichref_user_brief']['show_credits']){
            $r .= '<div class="row row-cols-2 mt-2 g-0">'
            . '<div class="col" title="'.$credits2_name.'" data-bs-toggle="tooltip">'
            . '<span class="mr-1 badge badge-center rounded-pil bg-label-warning"><i class="la la-coins"></i></span>'
            . $user['golds']
            . '</div>'
            . '<div class="col" title="'.$credits3_name.'" data-bs-toggle="tooltip">'
            . '<span class="mr-1 badge badge-center rounded-pil bg-label-info"><i class="la la-money-bill-alt"></i></span>'
            . $user['rmbs']*0.01
            . '</div>'
            .'</div>';
        }
        //*/
        $r .= '</div>';

    } else {
        continue;
    } 
    //*/

/* =====用户头像（带二级菜单）===== */
elseif ($menu_item['href'] === "__user_avatar_submenu__") :
    $abs_theme_stately_setting = setting_get( 'abs_theme_stately_setting');
    if ($uid != 0) {
        if ($abs_theme_stately_setting['ui_tweek']['menu_magichref_user_avatar_submenu']['style'] === 'modal') {
            $r .= '<li class="nav-item">'
            . '<a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#statelyMyInfoModal" aria-controls="statelyMyInfoModal">'
            . ( $abs_theme_stately_setting['ui_tweek']['menu_magichref_user_avatar_submenu']['show_username'] ? '<span class="d-none d-lg-inline mr-2">' . $user['username'] . '</span>' : '')
            . '<div class="avatar d-inline-block">'
            . '<img loading=lazy decoding=async src="' . $user['avatar_url'] . '" alt="' . $user['username'] . '" class="img-fluid rounded-circle">'
            . '</div>'
            . '</a>'
            . '</li>';
            
        } else {
            $r .= '<li class="nav-item navbar-dropdown dropdown-user dropdown">'
            . '<a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">'
            . ( $abs_theme_stately_setting['ui_tweek']['menu_magichref_user_avatar_submenu']['show_username'] ? '<span class="d-none d-lg-inline mr-2">' . $user['username'] . '</span>' : '')
            . '<div class="avatar d-inline-block">'
            . '<img loading=lazy decoding=async src="' . $user['avatar_url'] . '" alt="' . $user['username'] . '" class="img-fluid rounded-circle">'
            . '</div>'
            . '</a>'
            . xn_nav_menu(array(
                'menu' => 'user_menu',
                'container' => false,
                'menu_class' => 'dropdown-menu dropdown-menu-end',
                'link_class' => 'dropdown-item',
                'echo' => false
                ))
                . '</li>';
            }
    } else {
        continue;
    }
    
/* =====搜索框===== */

elseif ($menu_item['href'] === "__stately_search__") :
    $abs_theme_stately_setting = setting_get( 'abs_theme_stately_setting');
    $r .= '<li class="form-group nav-item menu-item ' . $menu_item['class'] . '">'
    .'<div class="menu-block">'
    .'<form action="'.url('search').'" class="">'
    .'<div class="input-group">'
    .'<input type="text" class="form-control" placeholder="'. $abs_theme_stately_setting['global']['search']['placeholder'].'" name="keyword" autocomplete="off">'
    .'<div class="input-group-text p-0">'
    .'<button class="btn btn-sm btn-link" type="submit"><span class="la la-search"></span></button>'
    .'</div>'
    .'</div>'
    .'</form>'
    .'</div>'
    .'</li>';
    //$r .= "stately_search_box_WIP";

/* =====搜索弹窗===== */
elseif ($menu_item['href'] === "__stately_search_modal__") :
    $_this_item = array(
        'icon' => $menu_item['icon'],
        'name' => $menu_item['name'],
        'href' => '#statelySearchModal',
        'class' => $menu_item['class'],
            'before' => $args['menu'] === 'appbar_menu' ? '<span>' : '<span class="d-none d-md-inline">',
            'after' => '</span>',
        'attr' => 'data-bs-toggle="modal" data-bs-target="#statelySearchModal"'
    );
    $r .= xn_nav_menu_item($_this_item, $args);

/* =====通知弹窗===== */
elseif ($menu_item['href'] === "__stately_notice_modal__"):
    if ($uid != 0 && isset($user['unread_notices'])) {
        $_this_item = array(
            'icon' => $menu_item['icon'],
            'name' => $menu_item['name'],
            'href' => '#statelyNotificationModal',
            'before' => $args['menu'] === 'appbar_menu' ? '<span>' : '<span class="d-none d-md-inline">',
            'after' => ($user['unread_notices'] != 0 ? '</span> <b class="badge badge-danger">' . $user['unread_notices'] . '</b>' : '</span>'),
            'attr' => 'data-bs-toggle="offcanvas" data-bs-target="#statelyNotificationModal" aria-controls="statelyNotificationModal"'
        );
        $r .= xn_nav_menu_item($_this_item, $args);
    } else {
        continue;
    }
/* =====登录弹窗===== */
elseif ($menu_item['href'] === "__stately_login_modal__"):
    if ($uid == 0) {
        if ($args['menu'] === 'appbar_menu') {
                $_this_item = array(
                    'icon' => $menu_item['icon'],
                    'name' => '',
                    'href' => '#',
                    'link_class' => 'btn btn-primary' . $menu_item['class'],
                    'link_attr' => 'role="button"',
                    'attr' => 'data-bs-toggle="modal" data-bs-target="#statelyLoginModal"'
                );
        } else {
            $_this_item = array(
                'icon' => $menu_item['icon'],
                'name' => lang('login'),
                'href' => '#',
                'link_class' => 'btn btn-primary ' . $menu_item['class'],
                'link_attr' => 'role="button"',
                'attr' => 'data-bs-toggle="modal" data-bs-target="#statelyLoginModal"'
            );
        }
        
        $r .= xn_nav_menu_item($_this_item, $args);
    } else {
        $r .= '';
    }

/* =====切换颜色模式===== */
elseif ($menu_item['href'] === "__stately_btn_colormode__") :
    $abs_theme_stately_setting = setting_get('abs_theme_stately_setting');
    $_this_item_name = '自动';
    $_this_item_icon = 'las la-sync';
    switch($abs_theme_stately_setting['ui']['color']['mode']){
        case 'light':
            $_this_item_name = '浅色';
            $_this_item_icon = 'las la-sun';
            break;
        case 'dark':
            $_this_item_name = '深色';
            $_this_item_icon = 'las la-moon';
            break;
    }
    $_this_item = array(
        'icon' => $_this_item_icon,
        'name' => $_this_item_name,
        'href' => '#',
        'id' => 'statelyToggleThemeColorMode',
        'class' => $menu_item['class'],
        'before' => '<span class="d-none d-md-inline">',
        'after' => '</span>',
        'attr' => 'data-bs-toggle="tooltip" data-real-original-title="点击切换颜色模式"',
        'title' => '点击切换颜色模式'
    );
    $r .= xn_nav_menu_item($_this_item, $args);
/* =====切换全屏模式===== */
    elseif ($menu_item['href'] === "__stately_btn_fullscreen__") :
        $_this_item = array(
            'icon' => $menu_item['icon'],
            'name' => $menu_item['name'],
            'href' => '#',
            'id' => 'statelyToggleFullscreenMode',
            'class' => $menu_item['class'],
            'before' => '<span class="d-none d-md-inline">',
            'after' => '</span>',
            'attr' => 'data-bs-toggle="tooltip" data-real-original-title="点击切换全屏模式"',
            'title' => '点击切换全屏模式'
        );
        $r .= xn_nav_menu_item($_this_item, $args);

/* =====论坛大类===== */
elseif ($menu_item['href'] === "__forumlist_section__") :
    global $route;
    $abs_theme_stately_setting = setting_get('abs_theme_stately_setting');
    $forumlist_temp = forum_list_cache();
    if (strpos($menu_item['name'], "|") !== false) {
        $forumlist_selected = explode('|', $menu_item['name']); //分割竖线
        $menu_item['name'] = $forumlist_selected[0]; //更新导航菜单名称
        $forumlist_selected = explode(',', $forumlist_selected[1]);
    } else {
        $forumlist_selected = '';
    }

    $row_cols = '';
    switch($abs_theme_stately_setting['ui_tweek']['bbs']['cols_count']) {
        case '2':
            $row_cols = ' row-cols-1 row-cols-sm-2';
            break;
        case '3':
            $row_cols = ' row-cols-1 row-cols-sm-2 row-cols-md-3';
            break;
        case '4':
            $row_cols = ' row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4';
            break;
        default:
            $row_cols = 'row-cols-1';
    }

    switch($abs_theme_stately_setting['ui_tweek']['bbs']['style']) {
        case 'v2':
                $r .= '<section class="card mb-3' . $menu_item['class'] . '" ' . $menu_item["attr"] . '>'
                . '<div class="card-header"><i class="' . $menu_item['icon'] . '"></i> ' . $menu_item['name'] . ' <small class="text-muted">' . $menu_item['desc'] . '</small></div>'
                . '<div class="card-body">'
                . '<div class="row ' . $row_cols . '">';
            foreach ($forumlist_temp as $key => $_forum) {
                if (empty($forumlist_selected) || in_array($key, $forumlist_selected)) {
                    $r .= '<article class="col p-0 list-group-item border-top-0 border-left-0 border-right-0 discovery_forum">'
                        . '<div class="p-2 list-group-item-action">'
                        . '<div class="media">'
                        . '<img loading=lazy decoding=async src="' . $_forum['icon_url'] . '" class="img-fluid w-px-50 img-fluid rounded">'
                        . '<div class="media-body ml-3">'
                        . '<h5 class="my-2"><a href="' . url('forum-' . $_forum['fid']) . '">' . $_forum['name'] . '</a></h5>'
                        . '<p class="text-muted m-0 small forum-brief">' . $_forum['brief'] . '</p>'
                        . '</div>'
                        . '</div>'
                        /*. '<hr>'*/
                        . '<div class="d-flex justify-content-between small mt-3">'
                        . '<div>'
                        . '<span class="text-muted">' . lang('threads') . '：' . $_forum['threads'] . '</span>'
                        . '<span class="text-muted ml-2">' . lang('today_posts') . '：' . $_forum['todayposts'] . '</span>'
                        . '</div>'
                        . '<div>'
                        . '<a class="text-muted" href="' . url('forum-' . $_forum['fid']) . '">' . lang('go_in_forum') . ' <i class="la la-angle-right"></i></a>'
                        . '</div>'
                        . '</div>'
                        . '</div>'
                        . '</article>';
                } else {
                    continue;
                }
            }
            $r .= '</div>'
                . '</div>'
                . '</section>';
            break;
        case 'v3':
            $r .= '<div class="card mb-3' . $menu_item['class'] . '" ' . $menu_item["attr"] .'>
			<div class="card-header">
				<i class="' . $menu_item['icon'] . ' mr-2"></i>' . $menu_item['name'] . ' <small class="text-muted">' . $menu_item['desc'] . '</small></div>
			<div class="card-body py-2">
				<div class="row ' . $row_cols . ' gx-0 gx-sm-1 gx-md-2">';
                foreach ($forumlist_temp as $key => $_forum) {
                    if (empty($forumlist_selected) || in_array($key, $forumlist_selected)) {
                        $r .= '<div class="col">'
                            . '<div class="discovery-forum">'
                            . '<div class="media" data-fid="' . $_forum['fid'] . '">'
                            . '<img class="avatar-4 rounded mr-3" src="' . $_forum['icon_url'] . '">'
                            . '<div class="media-body">'
                            . '<h3 class="h5 mb-2">'
                            . '<a href="' . url('forum-' . $_forum['fid']) . '">' . $_forum['name'] . '</a>'
                            . '</h3>'
                            . '<p class="mb-0">' . $_forum['brief'] . '</p>'
                            . '</div>'
                            . '</div>'
                            . '<hr>'
                            . '<div class="d-flex justify-content-between text-muted small">'
                            . '<ul class="list-inline m-0">'
                            . '<li class="list-inline-item">' . lang('today_threads') . '：' . $_forum['todaythreads'] . '</li>'
                            . '<li class="list-inline-item">' . lang('today_posts') . '：' . $_forum['todayposts'] . '</li>'
                            . '</ul>'
                            . '<div>'
                            . '<a class="" href="' . url('forum-' . $_forum['fid']) . '">' . lang('go_in_forum') . ' <i class="la la-angle-right"></i></a>'
                            . '</div>'
                            . '</div>'
                            . '</div>'
                            . '</div>';
                    } else {
                        continue;
                    }
                }
				$r .= '</div>'
                . '</div>'
                . '</div>';
            break;
        case 'v4':
            switch($abs_theme_stately_setting['ui_tweek']['bbs']['cols_count']) {
                case '2':
                    $row_cols = ' flex-md-basis-50';
                    break;
                case '3':
                    $row_cols = ' flex-md-basis-50 flex-lg-basis-33';
                    break;
                case '4':
                    $row_cols = ' flex-md-basis-50 flex-lg-basis-33 flex-xl-basis-25';
                    break;
                default:
                    $row_cols = '';
            }

            $r .= '<section class="' . $menu_item['class'] . '" ' . $menu_item["attr"] . '>'
            . '<div class="mt-2 p-3 border-bottom border-2 border-primary"><i class="' . $menu_item['icon'] . '"></i> ' . $menu_item['name'] . ' <small class="text-muted">' . $menu_item['desc'] . '</small></div>'
            . '<div class="card-body">'
            . '<div class="d-flex flex-row flex-wrap w-100">';
            foreach ($forumlist_temp as $key => $_forum) {
                if (empty($forumlist_selected) || in_array($key, $forumlist_selected)) {
                    $r .= '<article class="flex-md-grow-1 flex-md-shrink-0 ' . $row_cols . ' w-100 p-1 discovery_forum_v4">'
                        . '<div class="card mb-0">'

                        . ( (isset($_forum['cover_url']) && !empty($_forum['cover_url'])) ? '<div class="card-img-backdrop">'
                        . '<img class="card-img" src="' . $_forum['cover_url'] . '">'
                        . '</div>' : '' )

                        . '<div class="card-body">'
                        . '<div class="media">'
                        . '<img class="avatar-4" src="' . $_forum['icon_url'] . '">'
                        . '<div class="media-body pl-3">'
                        . '<h3 class="h6 mb-2">'
                        . '<a href="' . url('forum-' . $_forum['fid']) . '">' . $_forum['name'] . '</a>'
                        . '</h3>'
                        . '<p class="mb-2">' . $_forum['brief'] . '</p>'
                        . '<ul class="list-inline small m-0">'
                        . '<li class="list-inline-item"><i class="la la-comments" aria-hidden="true"></i> <span class="sr-only">' . lang('threads') . '：</span>' . $_forum['threads'] . '</li>'
                        . '</ul>'
                        . '</div>'
                        . '</div>'
                        . '</div>'
                        . '</div>'
                        . '</article>';
                } else {
                    continue;
                }
            }
            $r .= '</div>'
                . '</div>'
                . '</section>';
            break;

        case 'v4_with_last_post':
            if (!function_exists('array_key_first')) {
                /**
                 * Get the first key of an array.
                 *
                 * @param array $arr The input array.
                 * @return mixed The first key on success; NULL if the array is empty.
                 */
                function array_key_first(array $arr) {
                    foreach ($arr as $key => $unused) {
                        return $key;
                    }
                    return null;
                }
            }
            $have_allowtop = false;
            switch($abs_theme_stately_setting['ui_tweek']['bbs']['cols_count']) {
                case '2':
                    $row_cols = ' flex-md-basis-50';
                    break;
                case '3':
                    $row_cols = ' flex-md-basis-50 flex-lg-basis-33';
                    break;
                case '4':
                    $row_cols = ' flex-md-basis-50 flex-lg-basis-33 flex-xl-basis-25';
                    break;
                default:
                    $row_cols = '';
            }

            $r .= '<section class="' . $menu_item['class'] . '" ' . $menu_item["attr"] . '>'
            . '<div class="mt-2 p-3 border-bottom border-2 border-primary"><i class="' . $menu_item['icon'] . '"></i> ' . $menu_item['name'] . ' <small class="text-muted">' . $menu_item['desc'] . '</small></div>'
            . '<div class="card-body">'
            . '<div class="d-flex flex-row flex-wrap w-100">';
            foreach ($forumlist_temp as $key => $_forum) {
                if (empty($forumlist_selected) || in_array($key, $forumlist_selected)) {

                    $_thread = cache_get('last_post_for_fid_' . $_forum['fid']);
                    if(is_null($_thread)) {
                        $_thread = thread__find_by_fid($_forum['fid'],1,1,'lastpid');
                        $_thread = $_thread[array_key_first($_thread)];

                        cache_set('last_post_for_fid_' . $_forum['fid'],$_thread,60);
                    }

                    if (!empty($_thread)) :
                    ob_start();
                    ?>
<ul class="list-unstyled m-0">
                    // hook stately_layout_threadlist__classic_v4.htm
</ul>
                    <?php
                    $last_post_html = ob_get_clean();
                    else:
                    $last_post_html = '';
                endif;

                    $r .= '<article class="flex-md-grow-1 flex-md-shrink-0 ' . $row_cols . ' w-100 p-1 discovery_forum_v4">'
                        . '<div class="card mb-0">'

                        . ( (isset($_forum['cover_url']) && !empty($_forum['cover_url'])) ? '<div class="card-img-backdrop">'
                        . '<img class="card-img" src="' . $_forum['cover_url'] . '">'
                        . '</div>' : '' )

                        . '<div class="card-body">'

                        . '<section class="forum-info">'
                        . '<div class="media">'
                        . '<img class="avatar-4" src="' . $_forum['icon_url'] . '">'
                        . '<div class="media-body pl-3">'
                        . '<h3 class="h6 mb-2">'
                        . '<a href="' . url('forum-' . $_forum['fid']) . '">' . $_forum['name'] . '</a>'
                        . '</h3>'
                        . '<p class="mb-2">' . $_forum['brief'] . '</p>'
                        . '<ul class="list-inline small m-0">'
                        . '<li class="list-inline-item"><i class="la la-comments" aria-hidden="true"></i> <span class="sr-only">' . lang('threads') . '：</span>' . $_forum['threads'] . '</li>'
                        . '</ul>'
                        . '</div>'
                        . '</div>'
                        . '</section>'
                        . '<aside class="forum-lastpost">'
                        . $last_post_html
                        . '</aside>'
                        . '</div>'
                        . '</div>'
                        . '</article>';
                } else {
                    continue;
                }
            }
            $r .= '</div>'
                . '</div>'
                . '</section>';
            break;

        default: /* v1 */
            $r .= '<div class="card mb-3' . $menu_item['class'] . '" ' . $menu_item["attr"] . '>'
            . '<div class="card-header"><i class="' . $menu_item['icon'] . '"></i> ' . $menu_item['name'] . ' <small class="text-muted">' . $menu_item['desc'] . '</small></div>'
            . '<div class="card-body">'
            . '<div class="row ' . $row_cols . '">';
            foreach ($forumlist_temp as $key => $_forum) {
                if (empty($forumlist_selected) || in_array($key, $forumlist_selected)) {
                    $r .= '<article class="discovery_forum">'
                        . '<div class="media py-3">'
                        . '<img class="avatar-4" src="' . $_forum['icon_url'] . '">'
                        . '<div class="media-body pl-3">'
                        . '<h3 class="h6 mb-2">'
                        . '<a href="' . url('forum-' . $_forum['fid']) . '">' . $_forum['name'] . '</a>'
                        . '<span class="badge bg-label-primary float-right" title="' . lang('threads') . '">' . $_forum['threads'] . '</span>'
                        . '</h3>'
                        . '<p>' . $_forum['brief'] . '</p>'
                        . '<ul class="list-inline small">'
                        . '<li class="list-inline-item">' . lang('today_threads') . '：' . $_forum['todaythreads'] . '</li>'
                        . '<li class="list-inline-item">' . lang('today_posts') . '：' . $_forum['todayposts'] . '</li>'
                        . '</ul>'
                        . '</div>'
                        . '</div>'
                        . '</article>';
                } else {
                    continue;
                }
            }
            $r .= '</div>'
                . '</div>'
                . '</div>';
            break;
    }
    if (
        !empty($abs_theme_stately_setting) &&
        ($route == 'index' && $abs_theme_stately_setting['ui_style']['homepage']['layout'] === 'bbs_v2')
        || ($route == 'bbs' && $abs_theme_stately_setting['ui_style']['bbs']['layout'] === 'bbs_v2')
    ) {
        
    } else {
        
    }

/* =====紧凑帖子列表-门户主页===== */
elseif ($menu_item['href'] === "__portal_section__") :
    $abs_theme_stately_setting = setting_get('abs_theme_stately_setting');
        if (is_numeric($menu_item['name'])) {
        $forumlist_temp = forum_list_cache();
        if (intval($menu_item['name']) === 0) {
            $forums_selected = -1;
            $menu_item['name'] = lang('new_thread'); //更新导航菜单名称
            } else {
            $forums_selected = intval($menu_item['name']);
            $menu_item['name'] = $forumlist_temp[$forums_selected]['name']; //更新导航菜单名称
        }
        
    }
    $this_section_col_count = 12;
    switch(intval($menu_item['attr'])) {
        case 2:
            $this_section_col_count = 6;
            break;
        case 3:
            $this_section_col_count = 4;
            break;
        case 4:
            $this_section_col_count = 3;
            break;
    }
    $this_section_thread_count = 10;
    if(intval($menu_item['attr']) === 1) {
        $this_section_thread_count = 20;
    }
    $r .= '<div class="col-lg-' . $this_section_col_count . '">'
        . '<section class="card portal-section mb-3' . $menu_item['class'] . '" ' . '>'
        . '<header class="card-header">'
        . '<div class="d-flex justify-content-between">'
        . '<div>'
        . '<i class="' . $menu_item['icon'] . '"></i> '
        . $menu_item['name']
        . ' <small class="text-muted">'
        . $menu_item['desc']
        . '</small>'
        . '</div>'
        . '<div class="text-end">'

        . '<i class="icon-caret-right thread-ico text-black-50"></i> '
        . '<a href="' . url('forum-' . $forums_selected) . '">'
        . lang('go_in_forum')
        . '</a>'

        . '</div>'
        . '</div>'
        . '</header>'
        . '<div class="card-body">';
    if (!empty($forums_selected)) {
        $the_condition = array('fid' => $forums_selected);
        if ($forums_selected === -1) {
            $the_condition = array('closed' => '0');
        }
        

        $_threadlist = cache_get("stately_portal_section__". str_replace(',', '_', $forums_selected));
        if ($abs_theme_stately_setting['advanced']['threadlist']['do_not_use_cache'] || (empty($_threadlist) || $_threadlist === NULL)) {
            $_threadlist = thread_find($the_condition, array('tid' => -1), 1, $this_section_thread_count);
            cache_set("stately_portal_section__" . str_replace(',','_',$forums_selected), $_threadlist, 240);
        }
        

        $r .= '<ul class="list-unstyled threadlist threadlist-threads">';
        foreach ($_threadlist as $_thread) {
            $r .= '<li class="media thread ' . $_thread['top_class'] . '" data-href="' . url('thread-' . $_thread['tid']) . '" data-tid="' . $_thread['tid'] . '">'
                . '<span class="col pl-0">'
                . '<i class="icon-caret-right thread-ico text-black-50"></i> '
                . '<a href="' . url('thread-' . $_thread['tid']) . '">'
                . $_thread['subject']
                . '</a>'
                . '</span>'
                . '<span class="text-muted">'
                . $_thread['create_date_fmt']
                . '</span>'
                . '</li>';
        }
        $r .= '</ul>';
    } else {
        $r .= '请在导航标签处输入论坛板块ID';
    }
    $r .= '</div>'
        . '</d>'
        . '</section>'
        . '</div>';

/* =====紧凑帖子列表+大型分类名称展示-门户主页V2===== */
elseif ($menu_item['href'] === "__portal_section_v2__") :
    $abs_theme_stately_setting = setting_get('abs_theme_stately_setting');
        if (is_numeric($menu_item['name'])) {
        $forumlist_temp = forum_list_cache();
        if (intval($menu_item['name']) === 0) {
            $forums_selected = -1;
            $menu_item['name'] = lang('new_thread'); //更新导航菜单名称
            } else {
            $forums_selected = intval($menu_item['name']);
            $menu_item['name'] = $forumlist_temp[$forums_selected]['name']; //更新导航菜单名称
            $menu_item['desc'] = empty($menu_item['desc']) ? $forumlist_temp[$forums_selected]['brief'] : $menu_item['desc'];
        }
    }
    $this_section_col_count = 12;
    $this_section_header_left_col_count = 'col-2 col-lg-1';
    $this_section_header_right_col_count = 'col-10 col-lg-11';
    switch(intval($menu_item['attr'])) {
        case 2:
            $this_section_col_count = 6;
            $this_section_header_left_col_count = 'col-2 col-lg-2';
            $this_section_header_right_col_count = 'col-10 col-lg-10';
            break;
        case 3:
            $this_section_col_count = 4;
            $this_section_header_left_col_count = 'col-2 col-lg-3';
            $this_section_header_right_col_count = 'col-10 col-lg-9';
            break;
        case 4:
            $this_section_col_count = 3;
            $this_section_header_left_col_count = 'col-2 col-lg-3';
            $this_section_header_right_col_count = 'col-10 col-lg-9';
            break;
    }
    $this_section_thread_count = 10;
    if(intval($menu_item['attr']) === 1) {
        $this_section_thread_count = 20;
    }
    $r .= '<div class="col-lg-' . $this_section_col_count . '">'
        . '<section class="card portal-section portal-section-v2 mb-3' . $menu_item['class'] . '" ' . '>'
        . '<div class="card-body">';
    $r .= '<header class="row align-items-center mb-3">'
        . '<div class="' . $this_section_header_left_col_count . '">'
        . '<a href="' . url('forum-' . $forums_selected) . '">'
        . '<img loading=lazy decoding=async src="' . $forumlist_temp[$forums_selected]['icon_url'] . '" class="img-fluid img-thumbnail w-100">'
        . '</a>'
        . '</div>'
        . '<div class="' . $this_section_header_right_col_count . '">'
        . '<h3 class="h5 mb-2">' . $menu_item['name'] . '</h3>'
        . '<p class="m-0">' 
        . '<i class="' . $menu_item['icon'] . '"></i> '
        . $menu_item['desc'] 
        . '</p>'
        . '<div class="d-flex justify-content-between mt-2">'
        . '<div>'
        . '<span class="text-muted">'
        . '<i class="la la-copy"></i> '
        . $forumlist_temp[$forums_selected]['threads']
        . '</span>'
        . '</div>'
        . '<div class="text-end">'
        . '<a class="badge bg-label-primary" href="' . url('forum-' . $forums_selected) . '">'
        . lang('go_in_forum')
        . '</a>'
        . '</div>'
        . '</div>'
        . '</div>'
        . '</header>';
    if (!empty($forums_selected)) {
        $the_condition = array('fid' => $forums_selected);
        if ($forums_selected === -1) {
            $the_condition = array('closed' => '0');
        }
        

        $_threadlist = cache_get("stately_portal_section__". str_replace(',', '_', $forums_selected));
        if ($abs_theme_stately_setting['advanced']['threadlist']['do_not_use_cache'] || (empty($_threadlist) || $_threadlist === NULL)) {
            $_threadlist = thread_find($the_condition, array('tid' => -1), 1, $this_section_thread_count);
            cache_set("stately_portal_section__" . str_replace(',','_',$forums_selected), $_threadlist, 240);
        }
        

        $r .= '<ul class="list-unstyled threadlist threadlist-threads">';
        foreach ($_threadlist as $_thread) {
            $r .= '<li class="media thread ' . $_thread['top_class'] . '" data-href="' . url('thread-' . $_thread['tid']) . '" data-tid="' . $_thread['tid'] . '">'
                . '<span class="col pl-0">'
                . '<i class="icon-circle-o thread-ico text-black-50"></i> '
                . '<a href="' . url('thread-' . $_thread['tid']) . '">'
                . $_thread['subject']
                . '</a>'
                . '</span>'
                . '<span class="text-muted">'
                . $_thread['create_date_fmt']
                . '</span>'
                . '</li>';
        }
        $r .= '</ul>';
    } else {
        $r .= '请在导航标签处输入论坛板块ID';
    }
    $r .= '</div>'
        . '</d>'
        . '</section>'
        . '</div>';

/* =====灵活帖子列表-门户主页===== */
elseif ($menu_item['href'] === "__stately_threadlist__") :
    global $gid,$group,$route,$page;
    $abs_theme_stately_setting = setting_get('abs_theme_stately_setting');
    /**
     * @var array $stately_threadlist_section_args_custom 帖子列表参数(实参)
     */
    $stately_threadlist_section_args_custom = array();
    /**
     * @var array $stately_threadlist_section_args_raw 帖子列表参数(实参)
     */
    $stately_threadlist_section_args_raw = $menu_item['attr'];
    $stately_threadlist_section_args_raw = parse_str(str_replace(',','&',str_replace('&','\&',$stately_threadlist_section_args_raw)), $stately_threadlist_section_args_custom);
    $stately_threadlist_section_args_custom['fid'] = explode('|', $menu_item['name'])[1];
    $stately_threadlist_section_title = explode('|', $menu_item['name'])[0];
    /**
     * @var array $stately_threadlist_section_args 帖子列表参数(形参)(默认参数)
     */
    $stately_threadlist_section_args = array(
        'fid' => 1, //要显示的论坛板块
        'style' => 'blog_v2_top', //风格
        'pagesize' => 9, //显示多少帖子
        'cols' => 3, //列数
        'icon_color' => 'primary', //图标颜色
    );
    $stately_threadlist_section_args = array_merge($stately_threadlist_section_args,$stately_threadlist_section_args_custom);
    //var_dump($stately_threadlist_section_args);

    $stately_threadlist_style_override = $stately_threadlist_section_args['style'];
    $stately_threadlist_cols_count_override = 12;
    switch($stately_threadlist_section_args['cols']) {
        case 1:
            $stately_threadlist_cols_count_override = 12;
            break;
        case 2:
            $stately_threadlist_cols_count_override = 6;
            break;
        case 3:
            $stately_threadlist_cols_count_override = 4;
            break;
        case 4:
            $stately_threadlist_cols_count_override = 3;
            break;
    }

    $threadlist = cache_get("stately_threadlist_section_". $stately_threadlist_section_args['fid']);
    if ($abs_theme_stately_setting['advanced']['threadlist']['do_not_use_cache'] || (empty($threadlist) || $threadlist === NULL)) {
        $threadlist = thread__find_by_fid($stately_threadlist_section_args['fid'], 1, $stately_threadlist_section_args['pagesize'], 'lastpid');
        cache_set("stately_threadlist_section_" . $stately_threadlist_section_args['fid'], $threadlist, 240);
    }

    echo '<section class="my-3">';
    if(isset($stately_threadlist_section_args['noheading']) && intval($stately_threadlist_section_args['noheading']) === 0){
    echo '<header  class="d-flex align-items-center mb-3 gap-3">'
    . '<div>'
    . '<span class="badge bg-label-' . $stately_threadlist_section_args['icon_color'] . ' rounded-2 fs-big">'
    . '<i class="' . $menu_item['icon'] . ' fs-1"></i>'
    . '</span>'
    . '</div>'
    . '<div class="d-flex flex-column justify-content-center">'
    . '<h2 class="fs-4 mb-1">'
    . '<span class="align-middle">' . $stately_threadlist_section_title . '</span>'
    . '</h2>'
    . '<span>' . $menu_item['desc'] . '</span>'
    . '</div>'
    . '<div class="ml-auto ml-auto flex-shrink-0">'
    . '<a href="' . url('forum-'. $stately_threadlist_section_args['fid']) . '">' . lang('viewmore') . ' <i class="las la-angle-right"></i></a>'
    . '</div>'
    . '</header>';
}


    echo '<ul class="list-unstyled row">';
    // hook stately_threadlist_before.php
    include _include(APP_PATH . 'view/htm/thread_list.inc.htm');
    echo '</ul></section>';



/* =====Stately主题【结束】===== */

/* =====Stately主题 - 插件兼容【开始】 */

/* =====奇狐积分插件-签到===== */
elseif ($menu_item['href'] === "__fox_sign_in__") :
    global $user;
    if ($user) {
        $_this_item = array(
            'icon' => 'icon-calendar text-danger',
            'name' => (!empty($user['sign_status']) ? '已签' : '签到'),
            'href' => '#',
            'class' => 'fox_sign',
            'id' => 'fox_sign',
            'link_before' => '<span class="fox_sign_text">',
            'link_after' => '</span>',
        );
        
        $r .= xn_nav_menu_item($_this_item, $args);
    } else {
        continue;
    }

/* =====Stately主题 - 插件兼容【开始】 */
//endif;