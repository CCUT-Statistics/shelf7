<?php

if (!isset($till_thread_draft_setting)) {
    /**
     * @var array $till_thread_draft_setting 插件设置
     */
    $till_thread_draft_setting = setting_get('till_thread_draft_setting');
}
if (!isset($THREAD_DRAFT_SLOT_COUNT)) {
    /**
     * @var int $THREAD_DRAFT_SLOT_COUNT 草稿最大栏位数量
     */
    $THREAD_DRAFT_SLOT_COUNT = $till_thread_draft_setting['thread_draft_slot_count'];
}
/**
 * @var array $t_thread_draft 临时操作用数组
 */
$t_thread_draft = array();

/**
 * 分表：
 * 每100个用户分一个表，用于减轻查找和读取时的压力，和减小数据发生损坏时的影响范围
 * 
 * 栏位序号：
 * 从0开始，连续数字。不需要考虑“ID”。
 * 
 * 读取流程：
 * 首先获取分表名：$UID × 0.01或UID ÷ 100（用乘法不会有“除以零”错误）
 * 然后获取分表数据：$a = kv_get(till_thread_draft_分表)
 * 然后获取对应用户的草稿：$b = $a[$UID]
 * 然后获取对应的草稿栏位：$c = $b[栏位序号]
 * 
 * 写入流程：
 * 修改过的数据：$d = 修改过的$c; 
 * 合并修改过的数据：$b[栏位序号] = $d;
 * 合并修改过的数据：$a[$uid] = $b
 * 保存到数据库：kv_set(till_thread_draft_分表, $a)
 */

// ========== 业务函数 ==========

/**
 * 保存草稿数据
 * 不建议直接使用，不当操作会导致整个表的内容蒸发
 * 一开始想用goto做一致处理，但因为一些原因，换成了函数
 *
 * @param array $args 要更新的数据
 * @param int $uid 用户ID
 * @param int $slot 栏位
 * @return mixed
 */
function thread_draft_kv_save_DO_NOT_USE_OR_YOU_WILL_BE_FIRED($args, $uid = 0, $slot = NULL) {
    global $THREAD_DRAFT_SLOT_COUNT;
    /**
     * @var int $subtable 分表
     */
    $subtable = thread_draft_get_subtable_by_uid($uid);
    /**
     * @var array $r 对应分表数据数组
     */
    $r = kv_get('till_thread_draft_' . $subtable);

    if ($uid !== 0) {
        if (!is_null($slot)) {
            if ($slot <= ($THREAD_DRAFT_SLOT_COUNT - 1)) {
                $r[$uid][$slot] = $args; //修改指定栏位
            } else {
                return message(-1, '草稿栏位超出范围');
            }
        } else {
            $r[$uid] = array_eliminate_key($args); //修改用户的全部栏位
        }
    } else {
        return message(-1, '用户不存在');
    }
    $r = kv_set('till_thread_draft_' . $subtable, $r); //最终保存

    cache_delete('thread_draft_count_' . $uid); //顺便清理对应用户的缓存，变相更新草稿数量

    return true;
}

// hook model_thread_draft_start.php

/**
 * 创建帖子草稿
 *
 * @param int $uid
 * @param array $arr 写入内容，期待值为：array('fid' => 1, 'subject' => '帖子标题', 'message' => '帖子内容')
 * @return bool|array
 */
function thread_draft_create($uid, $arr) {
    global $THREAD_DRAFT_SLOT_COUNT;
    global $till_thread_draft_setting;
    $t_thread_draft = thread_draft_read($uid);
    if (count($t_thread_draft) <= ($THREAD_DRAFT_SLOT_COUNT - 1)) {

        if ($till_thread_draft_setting['plugin_compatibility']) {
            $arr["create_time"] = time();
            $t_thread_draft[] = $arr;
        } else {
            /**
             * @var array $new_draft 经过强制过滤后的草稿；谁知道你会传过来什么呢
             */
            $new_draft = array(
                "fid" => $arr['fid'],
                "tid" => thread_maxid(),
                "subject" => htmlspecialchars($arr['subject']),
                "create_time" => time(),
                "message" => $arr['message']
            );
            $t_thread_draft[] = $new_draft;
        }
    } else {
        return false;
    }
    return thread_draft_kv_save_DO_NOT_USE_OR_YOU_WILL_BE_FIRED($t_thread_draft, $uid);
}

/**
 * 更新帖子草稿
 *
 * @param int $uid
 * @param int $slot 栏位
 * @param array $arr 更新内容
 * @return bool|array
 */
function thread_draft_update($uid, $slot, $arr) {
    $t_thread_draft = thread_draft_read($uid);
    $t_thread_draft[$slot] = array_merge($t_thread_draft[$slot], $arr);
    return thread_draft_kv_save_DO_NOT_USE_OR_YOU_WILL_BE_FIRED($t_thread_draft, $uid);
}

/**
 * 获取帖子草稿
 *
 * @param int $uid
 * @param int|null $slot 可选：栏位；若不填写，则获取全部草稿
 * @return bool|array
 */
function thread_draft_read($uid, $slot = NULL) {
    $subtable = thread_draft_get_subtable_by_uid($uid);
    $t_thread_draft = kv_get('till_thread_draft_' . $subtable);
    if (is_numeric($slot)) {
        return $t_thread_draft[$uid][intval($slot)];
    } else {
        return $t_thread_draft[$uid];
    }
}

/**
 * 将草稿发布成帖子
 * 若要处理多个草稿栏位，请用foreach
 *
 * @param int $uid
 * @param int $slot
 * @return bool|array
 */
function thread_draft_publish($uid, $slot) {
    $t_thread_draft = thread_draft_read($uid, $slot);
    $t_user = user_read_cache($uid);

    if (!$t_user) {
        message(1, '用户不存在');
    }

    // ===== 开始发帖，复制自route/thread.php =====

    // hook thread_create_thread_start.php

    //论坛板块是否存在
    $forum = forum_read($t_thread_draft['fid']);
    empty($forum) and message('fid', lang('forum_not_exists'));

    //用户可以发帖
    $r = forum_access_user($t_thread_draft['fid'], $t_user['gid'], 'allowthread');
    !$r and message(-1, lang('user_group_insufficient_privilege'));

    //帖子标题
    $subject = htmlspecialchars($t_thread_draft['subject']);
    empty($subject) and message('subject', lang('please_input_subject'));
    xn_strlen($subject) > 128 and message('subject', lang('subject_length_over_limit', array('maxlength' => 128)));

    //帖子内容
    $message = $t_thread_draft['message'];
    empty($message) and message('message', lang('please_input_message'));
    xn_strlen($message) > 2028000 and message('message', lang('message_too_long'));

    //上膛
    $thread = array(
        'fid' => $t_thread_draft['fid'],
        'uid' => $uid,
        'sid' => uniqid(), //暂不确定含义
        'subject' => $subject,
        'message' => $message,
        'time' => time(),
        'longip' => $t_user['login_ip'],
        'doctype' => 0,
    );

    $pid = NULL; //稍后该变量会被赋值
    $tid = thread_create($thread, $pid);
    $pid === FALSE and message(-1, lang('create_post_failed'));
    $tid === FALSE and message(-1, lang('create_thread_failed'));

    // was hook thread_create_thread_end.php
    global $till_thread_draft_setting;
    if ($till_thread_draft_setting['plugin_compatibility']) {
        //var_dump($t_thread_draft);
        $tagids = $t_thread_draft['tagid'];

        $tagcatemap = $forum['tagcatemap'];
        foreach ($forum['tagcatemap'] as $cate) {
            $defaulttagid = $cate['defaulttagid'];
            $isforce = $cate['isforce'];
            $catetags = array_keys($cate['tagmap']);
            $intersect = array_intersect($catetags, $tagids); // 比较数组交集
            // 判断是否强制
            if ($isforce) {
                if (empty($intersect)) {
                    message(-1, '请选择' . $cate['name']);
                }
            }
            // 判断是否默认
            if ($defaulttagid) {
                if (empty($intersect)) {
                    array_push($tagids, $defaulttagid);
                }
            }
        }

        foreach ($tagids as $tagid) {
            $tagid and tag_thread_create($tagid, $tid);
        }
    }
    // ===== 结束发帖 =====

    thread_draft_delete($uid, $slot);

    message(0, lang('create_thread_sucessfully'));
}

/**
 * 删除帖子草稿
 *
 * @param int $uid
 * @param int|array $slot 栏位
 * @return bool 操作是否成功
 */
function thread_draft_delete($uid, $slot) {
    $t_thread_draft = thread_draft_read($uid);
    if (is_array($slot)) {
        foreach ($slot as $value) {
            unset($t_thread_draft[$value]);
        }
    } else {
        unset($t_thread_draft[$slot]);
    }
    return thread_draft_kv_save_DO_NOT_USE_OR_YOU_WILL_BE_FIRED(array_eliminate_key($t_thread_draft), $uid);
}

/**
 * 删除全部帖子草稿【危险】
 *
 * @param int $uid
 * @return bool 操作是否成功
 */
function thread_draft_delete_all($uid) {
    return thread_draft_kv_save_DO_NOT_USE_OR_YOU_WILL_BE_FIRED(array(), $uid);
}

/**
 * 删除过保质期草稿【危险】
 * @param int $uid
 * @param int $deleted_count 删除了几篇帖子（回调
 * @return bool 操作是否成功
 */
function thread_draft_delete_expired($uid, $shelf_life = NULL, &$deleted_count = 0) {
    $t_thread_draft = thread_draft_read($uid);
    if (is_numeric($shelf_life) && $shelf_life > 0) {
        foreach ($t_thread_draft as $slot => $draft) {
            if ($draft['create_time'] <= (time() - $shelf_life)) {
                unset($t_thread_draft[$slot]);
                $deleted_count++;
            } else {
                continue;
            }
        }
    } //如果未指定保质期或保质期为0，则直通
    return thread_draft_kv_save_DO_NOT_USE_OR_YOU_WILL_BE_FIRED(array_eliminate_key($t_thread_draft), $uid);
}

// ========== 其他函数 ==========

/**
 * 消除数组的key，变成连续数字key
 *
 * @param array $arr 要处理的数组
 * @return array
 */
function array_eliminate_key($arr) {
    $r = array();
    foreach ($arr as $key => $value) {
        $r[] = $value;
    }
    return $r;
}

/**
 * 获取指定用户的帖子草稿列表
 * 更简单调用，带缓存
 *
 * @param int $uid
 * @return bool|array
 */
function thread_draft_list($uid) {
    $subtable = thread_draft_get_subtable_by_uid($uid); //分表
    $t_thread_draft = kv_cache_get('till_thread_draft_' . $subtable);
    return $t_thread_draft[$uid];
}

/**
 * 获取指定用户的草稿数量，带缓存
 *
 * @param int $uid
 * @return int|bool 如果用户存在，返回int，否则为false
 */
function thread_draft_count($uid) {
    $r = cache_get('thread_draft_count_' . $uid);
    if (!$r) {
        $r = count(thread_draft_list($uid));
        cache_set('thread_draft_count_' . $uid, $r, 3600);
    }
    return $r;
}

/**
 * 通过用户ID获取分表序号
 *
 * @param int $uid
 * @return int
 */
function thread_draft_get_subtable_by_uid($uid) {
    return floor(intval($uid) * 0.01);
}

/**
 * 获取指定用户的最新鲜（更新时间最近）的草稿
 *
 * @param int $uid
 * @return array
 */
function thread_draft_get_freshest_draft_by_uid($uid) {
    $t_thread_draft = thread_draft_list($uid);
    if (count($t_thread_draft) === 1) {
        return $t_thread_draft[0]; //如果只有一个草稿，那就返回这个草稿，不用再排序
    }
    $arr_create_time = array();

    foreach ($t_thread_draft as $_draft) {
        $arr_create_time[] = $_draft['create_time'];
    }
    array_multisort($arr_create_time, SORT_DESC, $t_thread_draft);

    return $t_thread_draft[0];
}

/**
 * 获取指定用户的最新鲜（更新时间最近）的草稿
 *
 * @param int $uid
 * @return array
 */
function thread_draft_get_freshest_draft_id_by_uid($uid) {
    $t_thread_draft = thread_draft_list($uid);
    foreach ($t_thread_draft as $key => $value) {
        $t_thread_draft[$key]['draftid'] = $key;
    }
    if (count($t_thread_draft) === 1) {
        return 0; //如果只有一个草稿，那就返回这个草稿，不用再排序
    }
    $arr_create_time = array();

    foreach ($t_thread_draft as $_draft) {
        $arr_create_time[] = $_draft['create_time'];
    }
    array_multisort($arr_create_time, SORT_DESC, $t_thread_draft);

    return $t_thread_draft[0]['draftid'];
}

/**
 * 通过用户ID与帖子ID获取草稿
 *
 * @param int $uid
 * @param int $tid
 * @return array|bool
 */
function thread_draft_find_draft_by_tid($uid, $tid) {
    $t_thread_draft = thread_draft_list($uid);
    $r = array();
    foreach ($t_thread_draft as $key => $draft) {
        $s = array_search($tid, $draft);
        if ($s !== false) {
            $r = $t_thread_draft[$key];
            $r['draftid'] = $key;
        } else {
            continue;
        }
    }
    if (empty($r)) {
        return false;
    }
    return $r;
}

/**
 * 通过用户ID与帖子名称获取草稿
 *
 * @param int $uid
 * @param int $subject
 * @return array|bool
 */
function thread_draft_find_draft_by_subject($uid, $subject) {
    $t_thread_draft = thread_draft_list($uid);
    $r = array();
    foreach ($t_thread_draft as $key => $draft) {
        $s = array_search($subject, $draft);
        if ($s !== false && $s !== 'attach_coin') {
            $r = $t_thread_draft[$key];
            $r['draftid'] = $key;
            return $r;
        } else {
            continue;
        }
    }
    //var_dump($r);
    if (empty($r)) {
        return false;
    }
    //var_dump($r);
    return $r;
}

// hook model_thread_draft_end.php