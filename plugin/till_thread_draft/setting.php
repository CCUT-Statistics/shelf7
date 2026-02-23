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
$PLUGIN_SETTING = setting_get('till_thread_draft_setting');
/**
 * @var int $THREAD_DRAFT_SLOT_COUNT 草稿最大栏位
 */
$THREAD_DRAFT_SLOT_COUNT = $PLUGIN_SETTING['thread_draft_slot_count'];
/**
 * @var string $subaction 子操作
 */
$subaction = param(3, '');

$subtable_max = thread_draft_get_subtable_by_uid(user_maxid());
$subtable_paging_html = '';

/**
 * @var array $input 输入框
 */
$input = array();
$input['thread_draft_slot_count'] = form_text('thread_draft_slot_count', $PLUGIN_SETTING['thread_draft_slot_count']);
$input['auto_save_draft_interval'] = form_text('auto_save_draft_interval', $PLUGIN_SETTING['auto_save_draft_interval']);
$input['draft_shelf_life'] = form_text('draft_shelf_life', $PLUGIN_SETTING['draft_shelf_life']);

$input['plugin_compatibility'] = form_radio_yes_no('plugin_compatibility', $PLUGIN_SETTING['plugin_compatibility']);
$input['need_toast'] = form_radio_yes_no('need_toast', $PLUGIN_SETTING['need_toast']);

$input['delete_all_settings_and_drafts_after_uninst'] = form_radio_yes_no('delete_all_settings_and_drafts_after_uninst', $PLUGIN_SETTING['delete_all_settings_and_drafts_after_uninst']);
/**
 * 小路由器
 */
switch ($subaction) {
    case 'list': //列表
        $list_page = param(4, 0);
        $find_username = param('find_username', '');
        if (is_numeric($find_username)) {
            $_user = db_find_one('user', array('uid' => $find_username));
        } else {
            $_user = db_find_one('user', array('username' => $find_username));
        }
        $draft_list = kv_get('till_thread_draft_' . $list_page);

        /**
         * @var array $draft__number_of_users_in_this_subtable 这个分表里有多少用户有草稿
         */
        $draft__number_of_users_in_this_subtable = cache_get('draft__number_of_users_in_this_subtable');

        if (empty($draft__number_of_users_in_this_subtable)) {
            $draft__number_of_users_in_this_subtable = array();
            for ($i = 0; $i <= $subtable_max; $i++) {
                $t_drafts = kv_get('till_thread_draft_' . $i);
                $draft__number_of_users_in_this_subtable[$i] = 0;
                foreach ($t_drafts as $value) {
                    if (count($value) > 0) {
                        $draft__number_of_users_in_this_subtable[$i]++;
                    }
                }
            }
            cache_set('draft__number_of_users_in_this_subtable', $draft__number_of_users_in_this_subtable, 60);
        }
        for ($i = 0; $i <= $subtable_max; $i++) {
            /**
             * @var int $j 为了不影响$i计数开的变量
             */
            $j = $i;
            $subtable_paging_html .= '<li class="nav-item">'
                . '<a href="' . url('plugin-setting-' . param(2) . '-list-' . $i) . '" class="nav-link ' . ($i == param(4) ? 'active' : '') . ' ' . ($draft__number_of_users_in_this_subtable[$i] !== 0 ? 'font-weight-bold' : '') . '" title="UID：' . $i . '00 ~ ' . $i . '99 ' . ($draft__number_of_users_in_this_subtable[$i] !== 0 ? '(' . $draft__number_of_users_in_this_subtable[$i] . lang('user') . ')' : '') . '" data-toggle="tooltip">'
                . ($j + 1)
                . '</a>'
                . '</li>';
        }

        if ($method == 'GET') {
            include _include(APP_PATH . 'plugin/till_thread_draft/setting_list.htm');
        } else {
            if (thread_draft_read($_user['uid'])) {
                message(0, jump('请稍等', url('plugin-setting-' . param(2) . '-list-' . $list_page) . '#user' . $_user['uid'], 0));
            } else {
                message(0, jump('该用户没有草稿', url('plugin-setting-' . param(2) . '-list'), 2));
            }
        }
        break;

        /*
    case 'publish': //发布
        $this_uid = param('uid', 0);
        $this_slot = param('slot', 0);
        thread_draft_publish($this_uid, $this_slot);
        break;
    case 'edit': //编辑
        $this_uid = param('uid', 0);
        $this_slot = param('slot', 0);
        if ($this_uid !== 0 && $this_slot <= $THREAD_DRAFT_SLOT_COUNT) {
            if ($method == 'GET') {
                include _include(APP_PATH . 'plugin/till_thread_draft/setting_edit.htm');
            } else {
            }
        } else {
            message(-1, '用户或草稿栏位不存在');
        }
        break;
        //*/
    case 'delete': //删除
        //$delete_all = param('delete_all', false);
        $the_uid = param('uid', 0);
        $the_slot = param('slot', array());
        if ($method == 'POST' && !empty($the_slot)) {
            thread_draft_delete($the_uid, $the_slot);
            message(0, '草稿已删除');
        } else {
            message(1, 'Bad Request');
        }

        break;
        /*
    case 'delete_expired':
        $the_uid = param('uid', 0);
        break;
        */
    case 'delete_expired_all':
        $list_page = param(4, 0);
        $draft_list = kv_get('till_thread_draft_' . $list_page);
        if ($list_page > $subtable_max) {
            message(0, jump('删除全部过期帖子草稿完成!', url('plugin-setting-' . param(2)), 3));
        } elseif (is_null($draft_list)) {
            $the_message = 'UID为' . $list_page . '00 ~ ' . $list_page . '99' . '的用户没有草稿，已跳过，请不要离开本页面';
            message(0, jump($the_message, url('plugin-setting-' . param(2) . '-delete_expired_all-' . intval($list_page + 1)), 0));
        }
        $the_deleted_count = 0;
        foreach ($draft_list as $key => $value) {
            thread_draft_delete_expired($key, $PLUGIN_SETTING['draft_shelf_life'], $deleted_count);
            $the_deleted_count .= $deleted_count;
        }
        $the_message = '已删除UID为' . $list_page . '00 ~ ' . $list_page . '99' . '的全部过期草稿（共' . $the_deleted_count . '个），请不要离开本页面';
        message(0, jump($the_message, url('plugin-setting-' . param(2) . '-delete_expired_all-' . intval($list_page + 1)), 1));

        break;

    default: //参数配置
        if ($method == 'GET') {
            include _include(APP_PATH . 'plugin/till_thread_draft/setting.htm');
        } else {
            //保存设置
            $PLUGIN_SETTING['thread_draft_slot_count'] = intval(param('thread_draft_slot_count', 1));
            $PLUGIN_SETTING['auto_save_draft_interval'] = intval(param('auto_save_draft_interval', 1));
            $PLUGIN_SETTING['draft_shelf_life'] = intval(param('draft_shelf_life', 1));

            $PLUGIN_SETTING['need_toast'] = param('need_toast', false);
            $PLUGIN_SETTING['plugin_compatibility'] = param('plugin_compatibility', false);

            $PLUGIN_SETTING['delete_all_settings_and_drafts_after_uninst'] = param('delete_all_settings_and_drafts_after_uninst', false);
            setting_set('till_thread_draft_setting', $PLUGIN_SETTING);
            message(0, jump('设置成功！', url('plugin-setting-till_thread_draft'), 1));
        }

        break;
}