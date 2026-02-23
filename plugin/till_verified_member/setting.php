<?php !defined('DEBUG') and exit('Access Denied.');

/* ========== 常量定义 ========== */

//这个插件的文件夹URL
define('PLUGIN_DIR', 'plugin/' . param(2) . '/');
/**
 * @var array $PLUGIN_PROFILE 插件的conf
 */
$PLUGIN_PROFILE = json_decode(file_get_contents(APP_PATH . PLUGIN_DIR . 'conf.json'), true);
/**
 * @var array $PLUGIN_SETTING 插件设置
 */
$PLUGIN_SETTING = setting_get('till_verified_member_setting');

//实用函数
include APP_PATH . PLUGIN_DIR . 'function.php';
/**
 * @var array $v_credit_type 积分类型
 */
$v_credit_type = array(
    'credits' => lang('credits1'),
    'golds' => lang('credits2'),
    'rmbs' => lang('credits3')
);
/**
 * @var array $v_shapes 认证徽章形状
 */
$v_shapes = array(
    'square' => '方形',
    'circle' => '圆形'
);
/**
 * @var array $v_colors 认证徽章颜色
 */
$v_colors = array(
    'primary' => '主要（蓝色）',
    'secondary' => '次要（灰色）',
    'success' => '成功（绿色）',
    'info' => '信息（蓝色/紫色）',
    'warning' => '警告（金色）',
    'danger' => '危险（红色）',
    'red' => '红色',
    'orange' => '橙色',
    'yellow' => '黄色',
    'green' => '绿色',
    'teal' => '水绿色',
    'cyan' => '青色',
    'blue' => '蓝色',
    'indigo' => '靛蓝色',
    'purple' => '紫色',
    'pink' => '粉色',
    'rainbow' => '彩虹色',
    'custom' => '自定义颜色',
);

/* ========== 输入框定义 ========== */

if ($method == 'GET' && param('op', '') === 'check_user') {
    $till_v_check_user = till_v_check_user_verified(param('username', $user['username']), true);
} else {
    $till_v_check_user = array('v_level' => 0, 'v_title' => '');
}

$input = array();

$input['v_allow_user_apply']                = form_radio_yes_no('v_allow_user_apply', $PLUGIN_SETTING['v_allow_user_apply']);
$input['v_lock_user_apply']                 = form_radio_yes_no('v_lock_user_apply', $PLUGIN_SETTING['v_lock_user_apply']);
$input['v_return_credits_when_reject']      = form_radio_yes_no('v_return_credits_when_reject', $PLUGIN_SETTING['v_return_credits_when_reject']);

$input['v_show_thread_list_inc_avatar_after']      = form_radio_yes_no('v_show_thread_list_inc_avatar_after', $PLUGIN_SETTING['v_show_thread_list_inc_avatar_after']);
$input['v_show_thread_user_avatar_after']          = form_radio_yes_no('v_show_thread_user_avatar_after', $PLUGIN_SETTING['v_show_thread_user_avatar_after']);
$input['v_show_post_list_inc_avatar_after']        = form_radio_yes_no('v_show_post_list_inc_avatar_after', $PLUGIN_SETTING['v_show_post_list_inc_avatar_after']);
$input['v_show_user_profile_avatar_after']         = form_radio_yes_no('v_show_user_profile_avatar_after', $PLUGIN_SETTING['v_show_user_profile_avatar_after']);
$input['v_show_my_common_avatar_after']            = form_radio_yes_no('v_show_my_common_avatar_after', $PLUGIN_SETTING['v_show_my_common_avatar_after']);

$input['v_show_header_nav_username_after']         = form_radio_yes_no('v_show_header_nav_username_after', $PLUGIN_SETTING['v_show_header_nav_username_after']);
$input['v_show_post_list_inc_username_after']      = form_radio_yes_no('v_show_post_list_inc_username_after', $PLUGIN_SETTING['v_show_post_list_inc_username_after']);
$input['v_show_my_common_username_after']          = form_radio_yes_no('v_show_my_common_username_after', $PLUGIN_SETTING['v_show_my_common_username_after']);
$input['v_show_thread_list_inc_username_before']   = form_radio_yes_no('v_show_thread_list_inc_username_before', $PLUGIN_SETTING['v_show_thread_list_inc_username_before']);
//$input['v_show_thread_quick_reply_message_before'] = form_radio_yes_no('v_show_thread_quick_reply_message_before', $PLUGIN_SETTING['v_show_thread_quick_reply_message_before']);
$input['v_show_thread_username_before']            = form_radio_yes_no('v_show_thread_username_before', $PLUGIN_SETTING['v_show_thread_username_before']);
$input['v_show_thread_user_username_after']        = form_radio_yes_no('v_show_thread_user_username_after', $PLUGIN_SETTING['v_show_thread_user_username_after']);
$input['v_show_user_profile_username_after']       = form_radio_yes_no('v_show_user_profile_username_after', $PLUGIN_SETTING['v_show_user_profile_username_after']);
$the_donate_img = "data:image/png;base64," . $PLUGIN_PROFILE['nothing_to_see_here'];
$input['v_page_my_apply_before_select_title'] = form_text('v_page_my_apply_before_select_title', $PLUGIN_SETTING['v_page_my_apply_before_select_title']);
$input['v_page_my_apply_before_select_text']  = form_text('v_page_my_apply_before_select_text', $PLUGIN_SETTING['v_page_my_apply_before_select_text']);
$input['v_page_my_apply_after_select_title']  = form_text('v_page_my_apply_after_select_title', $PLUGIN_SETTING['v_page_my_apply_after_select_title']);
$input['v_page_my_apply_after_select_text']   = form_text('v_page_my_apply_after_select_text', $PLUGIN_SETTING['v_page_my_apply_after_select_text']);
$input['v_page_my_apply_before_form_title']   = form_text('v_page_my_apply_before_form_title', $PLUGIN_SETTING['v_page_my_apply_before_form_title']);

$v_type = array(0 => '无/取消认证');
for ($i = 1; $i <= 5; $i++) {
    $v_type[$i] = $PLUGIN_SETTING['v_type_' . $i . '_name'];
    $input['v_type_' . $i . '_activated']     = form_radio_yes_no('v_type_' . $i . '_activated', $PLUGIN_SETTING['v_type_' . $i . '_activated']);
    $input['v_type_' . $i . '_name']          = form_text('v_type_' . $i . '_name', $PLUGIN_SETTING['v_type_' . $i . '_name']);
    $input['v_type_' . $i . '_description']   = form_text('v_type_' . $i . '_description', $PLUGIN_SETTING['v_type_' . $i . '_description']);
    $input['v_type_' . $i . '_icon']          = form_text('v_type_' . $i . '_icon', $PLUGIN_SETTING['v_type_' . $i . '_icon']);
    $input['v_type_' . $i . '_color']         = form_select('v_type_' . $i . '_color', $v_colors, $PLUGIN_SETTING['v_type_' . $i . '_color']);
    $input['v_type_' . $i . '_color_custom']  = form_text('v_type_' . $i . '_color_custom', $PLUGIN_SETTING['v_type_' . $i . '_color_custom']);
    $input['v_type_' . $i . '_shape']         = form_select('v_type_' . $i . '_shape', $v_shapes, $PLUGIN_SETTING['v_type_' . $i . '_shape']);
    $input['v_type_' . $i . '_requirement']   = form_text('v_type_' . $i . '_requirement', $PLUGIN_SETTING['v_type_' . $i . '_requirement']);
    $input['v_type_' . $i . '_credit_use']    = form_radio_yes_no('v_type_' . $i . '_credit_use', $PLUGIN_SETTING['v_type_' . $i . '_credit_use']);
    $input['v_type_' . $i . '_credit_type']   = form_select('v_type_' . $i . '_credit_type', $v_credit_type, $PLUGIN_SETTING['v_type_' . $i . '_credit_type']);
    $input['v_type_' . $i . '_credit_amount'] = form_text('v_type_' . $i . '_credit_amount', $PLUGIN_SETTING['v_type_' . $i . '_credit_amount']);
}

$input['v_edit_username'] = form_text('v_username', param('username', $user['username']));
$input['v_edit_level'] = form_select('v_level', $v_type, $till_v_check_user['v_level']);
$input['v_edit_title'] = form_text('v_title', $till_v_check_user['v_title']);

$action = param(3);

if (empty($action)) {
    /* ==========设置页面========== */
    if ($method == 'GET') {

        /* ==========第一部分—申请用户列表========== */
        $page = 1; //起始页
        $pagesize = 20; //每页多少个
        $applying_list = ''; //申请用户，用于列表回调
        $applyed_list = ''; //申请通过用户，用于列表回调
        $applying_pagination = '';
        $applyed_pagination = '';


        /* =====申请用户列表===== */
        $applying_num = db_count('till_v_apply', array('status' => 0));
        $list = db_find('till_v_apply', $cond = array('status' => 0), $orderby = array('create_time' => -1), $page, $pagesize);
        //$list = db_find('v_apply', $cond = array('status' => 0), $orderby = array('create_time' => -1), $page, $pagesize);

        if ($list) {
            foreach ($list as $key) {
                $this_user = db_find_one('user', array('uid' => $key['uid']));
                $applying_list .= '<tr>'
                    . '<td>' . $key['uid'] . '</td>'
                    . '<td>' . $this_user['username'] . '</td>'
                    . '<td>' . $PLUGIN_SETTING['v_type_' . $key['v'] . '_name'] . '</td>'
                    . '<td>' . $key['v_title'] . '</td>'
                    . '<td>' . $key['v_info'] . '</td>'
                    . '<td>' . date('Y-n-j', $key['create_time']) . '</td>'
                    . '<td><button onclick="pass(' . $key['uid'] . ')" class=" btn btn-success">通过</button>'
                    . '<button onclick="reject(' . $key['uid'] . ')" class=" btn btn-danger" >拒绝</button></td>'
                    . '</tr>';
            }
        }
        $applying_pagination = pagination_ajax("{page}", $applying_num, $page, $pagesize);

        /* =====申请成功用户列表===== */
        $applyed_num = db_count('till_v_apply', array('status' => 1));
        $list = db_find('till_v_apply', array('status' => 1), $orderby = array('create_time' => -1), $page, $pagesize);

        if ($list) {
            foreach ($list as $key) {
                $this_user = db_find_one('user', array('uid' => $key['uid']));
                $applyed_list .= '<tr>'
                    . '<td>' . $key['uid'] . '</td>'
                    . '<td>' . $this_user['username'] . '</td>'
                    . '<td>' . $PLUGIN_SETTING['v_type_' . $key['v'] . '_name'] . '</td>'
                    . '<td>' . $key['v_title'] . '</td>'
                    . '<td>' . $key['v_info'] . '</td>'
                    . '<td>' . date('Y-n-j', $key['create_time']) . '</td>'
                    . '<td><button onclick="window.location.assign(\'' . url('plugin-setting-till_verified_member') . '?op=check_user&username=' . $key['uid'] . '#v_add_user\')" class=" btn btn-success">编辑</button>'
                    . '<button onclick="reject(' . $key['uid'] . ')" class=" btn btn-danger" >去除</button></td>'
                    . '</tr>';
            }
        }
        $applyed_pagination = pagination_ajax("{page}", $applyed_num, $page, $pagesize);


        /* ==========第二部分—设置页面========== */

        //加载设置页面
        include _include(APP_PATH . 'plugin/till_verified_member/setting.htm');
    } elseif ($method == "POST") {
        $op = param('op'); //操作
        $this_username = param('username'); //要更改的用户
        if ($op == 'check_user') {
            /* =====查询===== */
            if (empty($this_username)) die();
            till_v_check_user_verified($this_username);
        } elseif ($op == 'update_user') {
            /* =====添加/更新/删除===== */
            if (empty($this_username)) {
                message(-1, "NO_SUCH_USER");
                die();
            }

            $v_level = param('v_level', 0);
            $v_title = param('v_title', '');

            if (is_numeric($this_username)) {
                $_user = db_find_one('user', array('uid' => $this_username));
            } else {
                $_user = db_find_one('user', array('username' => $this_username));
            }
            if ($_user) {
                $r = user_update($_user['uid'], array('v' => $v_level, 'v_title' => $v_title));
                if ($r) {
                    message(0, '更新成功！');
                } else {
                    message(-1, "没有更新或更新失败");
                }
            } else {
                message(-1, "NO_SUCH_USER");
            }
        } elseif ($op == 'update_settings') {
            /* =====更新设置===== */
            //设置参数
            $PLUGIN_SETTING['v_allow_user_apply']             = param('v_allow_user_apply', false);
            $PLUGIN_SETTING['v_lock_user_apply']              = param('v_lock_user_apply', false);
            $PLUGIN_SETTING['v_return_credits_when_reject']   = param('v_return_credits_when_reject', false);

            $PLUGIN_SETTING['v_show_thread_list_inc_avatar_after']      = param('v_show_thread_list_inc_avatar_after', 1);
            $PLUGIN_SETTING['v_show_thread_user_avatar_after']          = param('v_show_thread_user_avatar_after', 1);
            $PLUGIN_SETTING['v_show_post_list_inc_avatar_after']        = param('v_show_post_list_inc_avatar_after', 1);
            $PLUGIN_SETTING['v_show_user_profile_avatar_after']         = param('v_show_user_profile_avatar_after', 1);
            $PLUGIN_SETTING['v_show_my_common_avatar_after']            = param('v_show_my_common_avatar_after', 1);

            $PLUGIN_SETTING['v_show_header_nav_username_after']         = param('v_show_header_nav_username_after', 1);
            $PLUGIN_SETTING['v_show_post_list_inc_username_after']      = param('v_show_post_list_inc_username_after', 1);
            $PLUGIN_SETTING['v_show_my_common_username_after']          = param('v_show_my_common_username_after', 1);
            $PLUGIN_SETTING['v_show_thread_list_inc_username_before']   = param('v_show_thread_list_inc_username_before', 1);
            //$PLUGIN_SETTING['v_show_thread_quick_reply_message_before'] = param('v_show_thread_quick_reply_message_before', 1);
            $PLUGIN_SETTING['v_show_thread_username_before']            = param('v_show_thread_username_before', 1);
            $PLUGIN_SETTING['v_show_thread_user_username_after']        = param('v_show_thread_user_username_after', 1);
            $PLUGIN_SETTING['v_show_user_profile_username_after']       = param('v_show_user_profile_username_after', 1);

            $PLUGIN_SETTING['v_page_my_apply_before_select_title'] = param('v_page_my_apply_before_select_title', '');
            $PLUGIN_SETTING['v_page_my_apply_before_select_text']  = param('v_page_my_apply_before_select_text', '');
            $PLUGIN_SETTING['v_page_my_apply_after_select_title']  = param('v_page_my_apply_after_select_title', '');
            $PLUGIN_SETTING['v_page_my_apply_after_select_text']   = param('v_page_my_apply_after_select_text', '');
            $PLUGIN_SETTING['v_page_my_apply_before_form_title']   = param('v_page_my_apply_before_form_title', '');

            for ($i = 1; $i <= 5; $i++) {
                $PLUGIN_SETTING['v_type_' . $i . '_activated']     = param('v_type_' . $i . '_activated', true);
                $PLUGIN_SETTING['v_type_' . $i . '_name']          = param('v_type_' . $i . '_name', '');
                $PLUGIN_SETTING['v_type_' . $i . '_description']   = param('v_type_' . $i . '_description', '');
                $PLUGIN_SETTING['v_type_' . $i . '_icon']          = param('v_type_' . $i . '_icon', '');
                $PLUGIN_SETTING['v_type_' . $i . '_color']         = param('v_type_' . $i . '_color', '');
                $PLUGIN_SETTING['v_type_' . $i . '_color_custom']  = param('v_type_' . $i . '_color_custom', '');
                $PLUGIN_SETTING['v_type_' . $i . '_shape']         = param('v_type_' . $i . '_shape', '');
                $PLUGIN_SETTING['v_type_' . $i . '_requirement']   = param('v_type_' . $i . '_requirement', '');
                $PLUGIN_SETTING['v_type_' . $i . '_credit_use']    = param('v_type_' . $i . '_credit_use', false);
                $PLUGIN_SETTING['v_type_' . $i . '_credit_type']   = param('v_type_' . $i . '_credit_type', '');
                $PLUGIN_SETTING['v_type_' . $i . '_credit_amount'] = max(1, intval(param('v_type_' . $i . '_credit_amount', '')));
            }

            setting_set('till_verified_member_setting', $PLUGIN_SETTING);
            message(0, jump('设置成功！', url('plugin-setting-till_verified_member'), 1));
        }
    }
}

/* ==========申请用户列表AJAX========== */
if ($action == 'vapplyinglist') {
    $page = param('l');
    $ajax_list = ''; //用于列表回调
    $num = db_count('till_v_apply', array('status' => 0));
    $arrlist = db_find('till_v_apply', $cond = array('status' => 0), $orderby = array('create_time' => -1), $page, $pagesize, $key = '', $col = array('uid', 'v', 'v_title', 'v_info', 'status', 'remark', 'create_time'), $d = NULL);
    foreach ($arrlist as $key) {
        $this_user = db_find_one('user', array('uid' => $key['uid']));
        $ajax_list .= '<tr>'
            . '<td>' . $key['uid'] . '</td>'
            . '<td>' . $this_user['username'] . '</td>'
            . '<td>' . $PLUGIN_SETTING['v_type_' . $key['v'] . '_name'] . '</td>'
            . '<td>' . $key['v_title'] . '</td>'
            . '<td>' . $key['v_info'] . '</td>'
            . '<td>' . date('Y-n-j', $key['create_time']) . '</td>'
            . '<td><button onclick="pass(' . $key['uid'] . ')" class=" btn btn-success">通过</button>'
            . '<button onclick="reject(' . $key['uid'] . ')" class=" btn btn-danger" >拒绝</button></td>'
            . '</tr>';
    }
    $pagination = pagination_ajax("{page}", $num, $page, $pagesize); //用于分页回调
    message(0, array('a' => $ajax_list, 'b' => $pagination, 'c' => $page));
}

/* ==========申请通过用户列表AJAX========== */
if ($action == 'vpassedlist') {
    $page = param('uid');
    $ajax_list = ''; //用于列表回调
    $num = db_count('till_v_apply', array('status' => -1));
    $arrlist = db_find('till_v_apply', $cond = array('status' => 0), $orderby = array('create_time' => -1), $page, $pagesize, $key = '', $col = array('uid', 'v', 'v_title', 'v_info', 'status', 'remark', 'create_time'), $d = NULL);
    foreach ($arrlist as $key) {
        $this_user = db_find_one('user', array('uid' => $key['uid']));
        $ajax_list .= '<tr>'
            . '<td>' . $key['uid'] . '</td>'
            . '<td>' . $this_user['username'] . '</td>'
            . '<td>' . $PLUGIN_SETTING['v_type_' . $key['v'] . '_name'] . '</td>'
            . '<td>' . $key['v_title'] . '</td>'
            . '<td>' . $key['v_info'] . '</td>'
            . '<td>' . date('Y-n-j', $key['create_time']) . '</td>'
            . '<td><button onclick="window.location(' . url('plugin-setting-till_verified_member') . $key['uid'] . '#v_add_user)" class=" btn btn-success">编辑</button>'
            . '<button onclick="reject(' . $key['uid'] . ')" class=" btn btn-danger" >去除</button></td>'
            . '</tr>';
    }
    $pagination = pagination_ajax("{page}", $num, $page, $pagesize); //用于分页回调
    message(0, array('a' => $ajax_list, 'b' => $pagination, 'c' => $page));
}

/* ==========认证通过========== */
if ($action == 'pass') {
    $the_uid = param('uid');
    $apply = v_apply_read($the_uid);
    user_update($the_uid, array('v' => $apply['v'], 'v_title' => $apply['v_title']));
    v_apply_update($the_uid, array('status' => 1));

    $pass_message = '恭喜！认证成功！';
    if (function_exists("notice_send")) {
        notice_send(1, $the_uid, $pass_message, 3); // 发送通知；3:系统通知
    }
    message(0, '认证已通过！');
}

/* ==========认证拒绝========== */
if ($action == 'reject') {
    $the_uid = param('uid', 0);
    $apply = v_apply_read($the_uid);
    $v_level = $apply['v'];
    $reject_reason_real = '您的认证被拒绝或取消';
    $reject_reason = param('reason', '');
    if (!empty($reject_reason)) {
        $reject_reason_real .= '，原因：' . $reject_reason;
    }
    if ($PLUGIN_SETTING['v_return_credits_when_reject'] && $PLUGIN_SETTING['v_type_' . $v_level . '_credit_use']) {
        $this_user = user_read($the_uid);
        $count = $PLUGIN_SETTING['v_type_' . $v_level . '_credit_amount'];
        $type = $PLUGIN_SETTING['v_type_' . $v_level . '_credit_type'];
        if ($count > 0) {
            if ($type == 'credits') {
                user_update($the_uid, array('credits' => ($this_user['credits'] + $count)));
            } elseif ($type == 'golds') {
                user_update($the_uid, array('golds' => ($this_user['golds'] + $count)));
            } elseif ($type == 'rmbs') {
                user_update($the_uid, array('rmbs' => ($this_user['rmbs'] + $count)));
            }
        }
    }
    user_update($the_uid, array('v' => 0, 'v_title' => ''));

    v_apply_update($the_uid, array('status' => -1, 'remark' => $reject_reason));
    if (function_exists("notice_send")) {
        notice_send(1, $the_uid, $reject_reason_real, 3); // 发送通知
    }
    message(0, '认证已拒绝！');
}