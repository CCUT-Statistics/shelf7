<?php exit;
if ($action == 'rfloor') {
    /**
     * r_f_c 楼中楼的数量
     * r_f_a 楼中楼的最新楼层数（总数）
     */

    $pid = param(2, 0);
    $action = param('action', '');
    $pageno = param('pageno', 0);
    $return_html = param('return_html', false);
    $separator = ',';

    $_post = post_read($pid);
    if (empty($_post)) {
        message(-1, lang('post_not_exists') . __LINE__);
        die;
    }
    if (!empty($_post['repeat_follow'])) {
        $post_replies_array = json_decode($_post['repeat_follow'], true);
        $post_replies_array_error = json_last_error();
    } else {
        $post_replies_array = [];
        $post_replies_array_error = JSON_ERROR_NONE;
    }
    $till_post_replies_setting = setting_get('till_post_replies_setting');

    if (empty($_post['repeat_follow']) || $post_replies_array_error !== JSON_ERROR_NONE) {
        $separator = '';
        if ($pageno > 0) {
            message(-2, lang('post_not_exists') . __LINE__);
            die;
        }
    }

    switch ($action) {
        case 'delfloor':
            // * 删除楼层
            // post-rfloor-{pid}.htm?action=delfloor&where=6
            $floor_id_wants_to_delete = param('where', 0);
            if (empty($post_replies_array)) {
                message(-1, lang('post_not_exists'));
                die;
            }

            foreach ($post_replies_array as $key => $reply_item) {
                if (intval($reply_item['fl']) === $floor_id_wants_to_delete) {
                    unset($post_replies_array[$key]);
                    break;
                } else {
                    continue;
                }
            }
            $post_replies_array = array_values($post_replies_array); //需要用这个重置键，否则转换成 json后会是{0:{}}而不是[{}]

            $post_replies_count = count($post_replies_array);

            $post_replies_json_string = json_encode($post_replies_array, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

            if (!empty($post_replies_array)) {
                $r = db_update('post', array('pid' => $pid), array('repeat_follow' => $post_replies_json_string, 'r_f_c' => $post_replies_count));
            } else {
                $r = db_update('post', array('pid' => $pid), array('repeat_follow' => '', 'r_f_c' => 0, 'r_f_a' => 0));
            }

            if ($r === FALSE) {
                message(-1, lang('update_post_failed'));
            } else {
                message(0, lang('delete_successfully'));
            }
            break;
        case 'list':
            // * 获取楼中楼列表
            // post-rfloor-{pid}.htm?action=list&page=1
            $post_replies_count = $_post['r_f_c'];
            $pageno = max(min($pageno, $post_replies_count), 1); // 确保页码既不大于楼中楼数量，也不小于1
            $post_replies_max_page = ceil($post_replies_count / $till_post_replies_setting['replies_per_page']);

            $post_replies_array__offset_begin = max(0, $pageno - 1) * $till_post_replies_setting['replies_per_page'];
            $post_replies_array = array_slice($post_replies_array, $post_replies_array__offset_begin, $till_post_replies_setting['replies_per_page']);

            foreach ($post_replies_array as $reply_item){
                $__user = user_read_cache($reply_item['uid']);
                if(intval($__user['gid']) === 7) {
                    $reply_item['message'] = '*已移除*';
                }
            } unset($__user);

            if ($return_html) {
                $post_replies_html = '';
                $_post_replies_array = $post_replies_array;
                ob_start();
                include _include(APP_PATH . 'plugin/till_post_replies/view/htm/post_reply_list.inc.htm');
                $post_replies_html = ob_get_clean();

                message(0, ['message' => 'Success', 'max_page' => $post_replies_max_page, 'data' => $post_replies_html]);
            } else {
                message(0, ['message' => 'Success', 'max_page' => $post_replies_max_page, 'data' => $post_replies_array]);
            }


            break;
        case 'add':
            // * 发布回复
            // post-rfloor-{pid}.htm?action=add&post_reply_content={message}&to_id={fl}

            /*
				[
					{
						"fl":该回复的楼层,
						"uid":发布者UID,
						"username":发布者用户名,
						"avatar_url":头像地址,
						"t_uid":发布者回复给谁UID,
						"t_username":发布者回复给谁用户名,
						"message":回复内容,
						"update":更新时间 时间戳
					}
				]
				*/
            $post_reply_content = trim(xn_html_safe(htmlspecialchars(param('post_reply_content', ''))));

            $post_reply_to_id = param('to_reply_id', 0);
            $post_reply_to_uid = 0;

            if (count($post_replies_array) !== 0) {
                foreach ($post_replies_array as $post_replies_item) {
                    if (intval($post_replies_item['fl']) === $post_reply_to_id) {
                        $post_reply_to_uid = $post_replies_item['uid'];
                        break;
                    } else {
                        continue;
                    }
                }
                $post_reply_to_user = user_read_cache($post_reply_to_uid);
                if ($post_reply_to_uid !== 0 && empty($post_reply_to_user)) {
                    message(3, lang('user_not_exists'));
                    die;
                } elseif ($post_reply_to_uid == 0 && $post_reply_to_user['gid'] == 0) {
                    $post_reply_to_user['username'] = '';
                }
            } else {
                $post_reply_to_user = user_guest();
                $post_reply_to_user['username'] = '';
            }

            $notice_send_to_uid = $_post['uid'];

            if ($post_reply_to_uid != 0) {
                $notice_send_to_uid = $post_reply_to_uid;
            }

            if (empty($post_reply_content)) {
                message(1, lang('please_input_message'));
                die;
            }
            if (xn_strlen($post_reply_content) > $till_post_replies_setting['max_reply_length']) {
                message(2, lang('message_too_long'));
                die;
            }

            $post_replies_count = $_post['r_f_c'] + 1;
            $post_replies_count_total = $_post['r_f_a'] + 1;

            $new_post_reply_array = [
                "fl" => $post_replies_count_total,
                "uid" => $uid,
                "username" => $user['username'],
                "avatar_url" => $user['avatar_url'],
                "t_uid" => $post_reply_to_uid,
                "t_username" => $post_reply_to_user['username'],
                "message" =>  $post_reply_content,
                "update" => time(),
            ];

            $post_replies_array[] = $new_post_reply_array;

            $post_replies_json_string = json_encode($post_replies_array, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

            $r = db_update('post', array('pid' => $pid), array('repeat_follow' => $post_replies_json_string, 'r_f_c' => $post_replies_count, 'r_f_a' => $post_replies_count_total));
            if ($r) {
                if (function_exists("notice_send")) {
                    $notice_message = '<div class="comment-info">'
                        . '<a class="mr-1 text-grey" href="' . url("thread-" . $_post['tid']) . '#' . $pid . '">'
                        . lang('notice_lang_comment')
                        . '</a>'
                        . lang('notice_message_replytoyou')
                        . '<a href="' . url("thread-" . $_post['tid']) . '#' . $pid . '">'
                        . '《回帖：' . $_post['message_fmt'] . '》'
                        . '</a>'
                        . '</div>'
                        . '<div class="single-comment">'
                        . mb_substr($post_reply_content, 0, 40)
                        . '...'
                        . '</div>';
                    notice_send($uid, $notice_send_to_uid, $notice_message, 2);
                }
                if ($return_html) {
                    $post_replies_html = '';
                    $_post_replies_array = [$new_post_reply_array];
                    ob_start();
                    include _include(APP_PATH . 'plugin/till_post_replies/view/htm/post_reply_list.inc.htm');
                    $post_replies_html = ob_get_clean();

                    message(0, ['message' => '回复成功', 'data' => $post_replies_html]);
                } else {
                    message(0, ['message' => '回复成功', 'data' => [$new_post_reply_array]]);
                }
            } else {
                message(-1, lang('update_post_failed'));
            }

            break;
        default:
            message(1, 'Bad Request' . __LINE__);
            break;
    }
}
