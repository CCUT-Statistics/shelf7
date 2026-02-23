<?php

/**
 * 获取可用内置封面图列表
 * 
 * @return array 键为URL，值为文件名
 */
function cover_get_covers_list() {
    $dir = APP_PATH  . '/' . 'plugin' . '/' . 'till_user_cover' . '/' . 'covers' . '/';
    $r = array();
    if (is_dir($dir)) {
        $info = opendir($dir);
        while (($file = readdir($info)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            } else {
                $r[$file] = str_replace(strrchr($file, "."), "", $file);
            }
        }
        closedir($info);
    }
    return $r;
}

/**
 * 获取用户的封面图地址
 *
 * @param int $uid
 * @return string
 */
function cover_get_cover_url_by_uid($uid = NULL, $custom_location = NULL) {
    global $conf;
    if (is_null($uid) || $uid == 0) {
        return null;
    }
    $_user = user_read_cache($uid);
    $the_cover_url = $_user['cover_url'];
    if (strpos($the_cover_url, "http://") !== false || strpos($the_cover_url, "https://") !== false) {
        //外部封面图
        return $the_cover_url;
    } else {
        //内置封面图
        if (is_null($custom_location)) {
            $custom_location = '.';
        }

        return $custom_location . '/' . 'plugin' . '/' . 'till_user_cover' . '/' . 'covers' . '/' . $the_cover_url;
    }
}

/**
 * 获取用户的封面图地址
 *
 * @param int $uid
 * @return string
 */
function cover_get_cover_url_by_uid_raw_DO_NOT_USE_OR_YOU_WILL_BE_FIRED($uid = NULL) {
    global $conf;
    if (is_null($uid) || $uid == 0) {
        return null;
    }
    $_user = user_read_cache($uid);
    return $_user['cover_url'];
}

// ========== 其他函数 ==========
if (!function_exists('form_radio_image')) {
    /**
     * 多个单选框——图片风格（选中“甲或乙或丙”）
     * @param string $name 设置项的name
     * @param array $arr 选项数组，使用“键-值”模式：键是value，值是对外显示的标签
     * @param string $color 开关按钮的颜色
     * @param mixed $checked 预先选中的选项
     * @return string 对应的HTML代码
     */
    function form_radio_image($name, $arr, $checked = 0, $url_prefix = '', $color = "primary") {

        $s = '';
        $s .= '<div class="btn-group btn-group-toggle" data-toggle="buttons">';
        foreach ((array)$arr as $k => $v) {
            $add = $k == $checked ? ' checked="checked"' : '';
            $activeadd = $k == $checked ? ' active' : '';
            $s .= '<label class="btn btn-' . $color . ' ' . $activeadd . '"><input type="radio" value="' . $k . '" name="' . $name . '" id="' . $name . '_' . $k . '"' . $add . ' />'
                . '<img class="rounded" src="'
                . $url_prefix . $v['url']
                . '" /><br>'
                . $v['label']
                . '</label>'
                . PHP_EOL;
        }
        $s .= '</div>';
        return $s;
    }
}