<?php

if (!function_exists('v_apply_create')) :
    /**
     * 认证申请-创建
     *
     * @param array $arr
     */
    function v_apply_create($arr) {
        $r = db_create('till_v_apply', $arr);
        /*
        if ($r) {
            return true;
        } else {
            return false;
        }
        //return $r;
        //*/
        return true;
    }
endif;

if (!function_exists('v_apply_update')) :
    /**
     * 认证申请-更新
     *
     * @param int $id
     * @param array $arr
     */
    function v_apply_update($id, $arr) {
        $r = db_update('till_v_apply', array('uid' => $id), $arr);
        return $r;
    }
endif;

if (!function_exists('v_apply_read')) :
    /**
     * 认证申请-获取
     *
     * @param int $id
     */
    function v_apply_read($id) {
        $r = db_find_one('till_v_apply', array('uid' => $id));
        return $r;
    }
endif;

if (!function_exists('v_apply_find')) :
    /**
     * 认证申请-查找
     *
     * @param array $form
     * @param array $field
     * @param array $cond
     * @param array $orderby
     * @param int $page
     * @param int $pagesize
     */
    function v_apply_find($form, $field, $cond = array(), $orderby = array(), $page = 1, $pagesize = 10) {
        $arrlist = db_find($form, $cond, $orderby, $page, $pagesize, $field, array($field));
        if (empty($arrlist)) return array();
        $tidarr = arrlist_values($arrlist, $field);
        $sg_signlist = db_find($form, array($field => $tidarr), $orderby, 1, $pagesize, $field);
        return $sg_signlist;
    }
endif;

if (!function_exists('pagination_ajax')) :
    /**
     * bootstrap 翻页，命名与 bootstrap 保持一致
     *
     * @param string $url 网址
     * @param int $totalnum 总数
     * @param int $page 页码
     * @param int $pagesize 每页有多少个
     * @return string
     */
    function pagination_ajax($url, $totalnum, $page, $pagesize = 20) {
        $totalpage = ceil($totalnum / $pagesize);
        if ($totalpage < 2) return '';
        $page = min($totalpage, $page);
        $shownum = 5;   // 显示多少个页 * 2

        $start = max(1, $page - $shownum);
        $end = min($totalpage, $page + $shownum);

        // 不足 $shownum，补全左右两侧
        $right = $page + $shownum - $totalpage;
        $right > 0 && $start = max(1, $start -= $right);
        $left = $page - $shownum;
        $left < 0 && $end = min($totalpage, $end -= $left);

        $s = '';
        $page != 1 && $s .= pagination_tpl_ajax(str_replace('{page}', $page - 1, $url), '«', '');
        if ($start > 1) $s .= pagination_tpl_ajax(str_replace('{page}', 1, $url), '1 ' . ($start > 2 ? '... ' : ''));
        for ($i = $start; $i <= $end; $i++) {
            $s .= pagination_tpl_ajax(str_replace('{page}', $i, $url), $i, $i == $page ? ' active' : '');
        }
        if ($end != $totalpage) $s .= pagination_tpl_ajax(str_replace('{page}', $totalpage, $url), ($totalpage - $end > 1 ? '... ' : '') . $totalpage);
        $page != $totalpage && $s .= pagination_tpl_ajax(str_replace('{page}', $page + 1, $url), '»');
        return $s;
    }
endif;

if (!function_exists('pagination_tpl_ajax')) :
    /**
     * bootstrap 翻页-输出
     *
     * @param [type] $url
     * @param [type] $text
     * @param string $active
     */
    function pagination_tpl_ajax($url, $text, $active = '') {
        global $g_pagination_tpl;
        empty($g_pagination_tpl) and $g_pagination_tpl = '<li class="page-item{active}"><a data-title="{url}" class="page-link">{text}</a></li>';
        return str_replace(array('{url}', '{text}', '{active}'), array($url, $text, $active), $g_pagination_tpl);
    }
endif;

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

    if ($args['v_type_' . $v_level . '_color'] === 'custom') { //自定义颜色
        $r .= ' style="background:' . $args['v_type_' . $v_level . '_color_custom'] . '" ';
    }

    $v_title_add = $args['v_type_' . $v_level . '_name'];
    if (!empty($v_title)) {
        $v_title_add .= '：' . $v_title;
        $r .= ' data-toggle="tooltip" title="' . $v_title_add . '"';
    } else {
        $r .= ' title="' . $v_title_add . '"';
    }
    $r .= ' >'
        . '<i class="icon-' . $args['v_type_' . $v_level . '_icon'] . '"></i>' // Icon
        . '</span>';

    return $r;
}