//<?php

    $till_quick_at_setting = setting_get('till_quick_at_setting');
    if (!$till_quick_at_setting['compatible_with_haya_post_info']) {
        if (function_exists("notice_send")) {
            $haya_post_info_pagesize = $conf['postlist_pagesize'];
            $haya_post_info_page = ceil(($thread['posts'] + 1) / $haya_post_info_pagesize);
            $haya_post_info_page = max(1, $haya_post_info_page);

            $notice_thread_subject = $thread['subject'];
            $notice_thread_substr_subject = notice_substr($thread['subject'], 20);
            $notice_thread_url = url('thread-' . $thread['tid']);
            $notice_thread = '<a target="_blank" href="' . $notice_thread_url . '">《' . $notice_thread_subject . '》</a>';

            $notice_post_message = $post['message'];
            $notice_post_substr_message = notice_substr($post['message'], 40, FALSE);
            $notice_post_url = url('thread-' . $thread['tid'] . '-' . $haya_post_info_page) . '#' . $post['pid'];

            $notice_user_url = url('user-' . $user['uid']);
            $notice_user_avatar_url = $user['avatar_url'];
            $notice_user_username = $user['username'];
            $notice_user = '<a href="' . $notice_user_url . '" target="_blank"><img class="avatar-1" src="' . $notice_user_avatar_url . '"> ' . $notice_user_username . '</a>';

            $notice_msg_tpl = '<div class="comment-info">在主题 <a target="_blank" href="{thread_url}" title="{thread_subject}">《{thread_substr_subject}》</a> 的回复中提到了你</div> '
                . '<div class="quote-comment"><a href="{post_url}" class="text-body">{post_substr_message}</a></div>';
            $notice_msg = str_replace(
                array(
                    '{thread_subject}', '{thread_substr_subject}', '{thread_url}', '{thread}',
                    '{post_message}', '{post_substr_message}', '{post_url}',
                    '{user_url}', '{user_avatar_url}', '{user_username}', '{user}'
                ),
                array(
                    $notice_thread_subject, $notice_thread_substr_subject, $notice_thread_url, $notice_thread,
                    $notice_post_message, $notice_post_substr_message, $notice_post_url,
                    $notice_user_url, $notice_user_avatar_url, $notice_user_username, $notice_user
                ),
                $notice_msg_tpl
            );
        }
        $pattern = '/@[\w\d\S\x{4e00}-\x{9fa5}]+ /iu';

        preg_match_all($pattern, $post['message'], $user_mentions);
        // 提到的用户数量
        $mentioned_user_count = count($user_mentions[1]);
        // 如果提到了用户
        if ($mentioned_user_count > 0) {
            for ($i = 0; $i < $mentioned_user_count; $i++) {
                // 根据提及的用户名查找用户
                $mentioned_user = user_read_by_username($user_mentions[1][$i]);
                // 如果用户不存在,跳过
                if (!$mentioned_user || empty($mentioned_user['uid'])) {
                    continue;
                }

                // 将 @ 提及用户替换为带有链接的格式
                $post['message_fmt'] = str_replace($user_mentions[0][$i], '<a href="' . url('user-' . $mentioned_user['uid']) . '" target="_blank"><em>@' . $mentioned_user['username'] . '</em></a>', $post['message_fmt']);

                // 如果存在 notice_send 函数，给对应用户发送通知
                if (function_exists("notice_send")) {
                    notice_send($user['uid'], $mentioned_user['uid'], $notice_msg, 156);
                }
            }
        }

        post__update($pid, array("message_fmt" => $post['message_fmt']));
    }
