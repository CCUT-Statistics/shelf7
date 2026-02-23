<?php

$till_v_settings = setting_get('till_verified_member_setting');

if (!function_exists('v_show_badge')) {
    /**
     * 显示认证徽章
     *
     * @param int $v_level 认证等级
     * @param string $v_title 认证头衔
     * @param array $args 其他参数，详见函数内
     * @param array $v_setting 插件设置
     * @return string 认证徽章的HTML代码
     */
    function v_show_badge($v_level = 0, $v_title = '', $args = array()) {
        if ($v_level === 0) return; //如果没有认证，就不显示

        $r = ''; //输出结果

        //默认参数
        $args_default = array(
            'v_icon_icon' => 'check', //图标
            'v_icon_shape' => 'circle', //形状
        );
        $args = array_merge($args_default, $args);

        $r .= '<span class="verified-badge lv' . $v_level . ' ';
        switch ($args['v_type_' . $v_level . '_shape']) {
            case 'square':
                $r .= ' v_badge-square ';
                break;

            default:
                //do nothing
                break;
        }
        $r .= 'v_badge-bg-' . $args['v_type_' . $v_level . '_color']; //颜色

        $r .= '" '; //end class
        if (!empty($v_title)) {
            $r .= ' data-toggle="tooltip" title="' . $v_title . '"';
        }
        $r .= ' >'
            . '<i class="icon-' . $args['v_type_' . $v_level . '_icon'] . '"></i>'
            . '<span class="sr-only">' . $args['v_type_' . $v_level . '_name'] . '：' . $v_title . '</span></span>';

        return $r;
    }
}

/**
 * 查询用户认证状态
 *
 * @param string|int $username 用户名或用户ID
 * @param bool $is_ajax 返回数组
 * @return array
 */
function till_v_check_user_verified($username, $is_ajax = false) {
    if (is_numeric($username)) {
        $_user = db_find_one(
            'user',
            array('uid' => $username)
        );
    } else {
        $_user = db_find_one(
            'user',
            array('username' => $username)
        );
    }

    if ($_user) {
        $r = array(
            'v_level' => (!empty($_user['v']) ? (is_numeric($_user['v']) ? $_user['v'] : 1) : 0), //如果v是数字（本插件），则为认证等级；否则为1（兼容）；再否则为0
            'v_title' => (!empty($_user['v_title']) ? $_user['v_title'] : (!is_numeric($_user['v']) ? $_user['v'] : '_Not set')) //如果v_title存在，则为认证信息；否则为v的值（兼容）；再否则为空
        );
        if ($is_ajax) {
            return $r;
        } else {
            message(0, $r);
        }
    } else {
        message(1, 'NO_SUCH_USER');
    }
}