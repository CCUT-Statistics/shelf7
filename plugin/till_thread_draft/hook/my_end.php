?>

<?php
if ($action == 'draft') {

    $sub_action = param(2, '');
    switch ($sub_action) {

        case 'create':
            $args = array(
                'fid' => param('fid', 1),
                'subject' => param('subject', 'Untitled'),
                'message' => param('message', '')
            );
            if ($till_thread_draft_setting['plugin_compatibility']) {
                $args['attach_coin_status'] = param('attach_coin_status', '');
                $args['attach_coin'] =  param('attach_coin', 0);
                $args['tagid'] = param('tagid', array());
                $args['VIPonly'] = param('VIPonly', 0);
                $args['VIPonlyA'] = param('VIPonlyA', 0);
                $args['content_num_status'] = param('content_num_status', 0);
                $args['content_num'] = param('content_num', 0);
                $args['content_type'] = param('content_type', '');
                $args['offer_status'] = param('offer_status', 0);
                $args['offer_num'] = param('offer_num', 0);
                $args['readp_status'] = param('readp_status', 0);
                $args['user_group_select'] = param('user_group_select', '');
                $args['readp'] = param('readp', 0);
                $args['post_red'] = param('post_red', 0);
                $args['red_type'] = param('red_type', 0);
                $args['red_num'] = param('red_num', 0);
                $args['red_total_money'] = param('red_total_money', 0);
                $args['red_command'] = param('red_command', 0);
                //*
                $args['this_thread_tip_status'] = param('this_thread_tip_status', 0);
                $args['this_thread_is_transcription'] = param('this_thread_is_transcription', 0);
                $args['this_thread_cite'] = param('this_thread_cite', '');
                $args['this_thread_allow_republications'] = param('this_thread_allow_republications', 0);
                //*/
            }


            if (empty($args['subject']) || empty($args['message'])) {
                message(2, '输入一些内容才会保存草稿');
            }


            if ($method == 'POST' && !empty($args)) {
                if ($till_thread_draft_setting['plugin_compatibility']) {
                    //tag插件兼容性
                    $forum = $args['fid'] ? forum_read($args['fid']) : array();
                    $tagids = param('tagid', array(0));

                    $tagcatemap = $forum['tagcatemap'];
                    foreach ($forum['tagcatemap'] as $cate) {
                        $defaulttagid = $cate['defaulttagid'];
                        $isforce = $cate['isforce'];
                        $catetags = array_keys($cate['tagmap']);
                        $intersect = array_intersect($catetags, $tagids); // 比较数组交集
                        // 判断是否强制
                        if ($isforce) {
                            if (empty($intersect)) {
                                if (param('way', '') == 'manual') {
                                    $args['tagid'] = $tagids;
                                    message(-1, '请选择' . $cate['name']);
                                } else {
                                    $args['tagid'] = array(0 => '1');
                                }
                            }
                        }
                        // 判断是否默认
                        if ($defaulttagid) {
                            if (empty($intersect)) {
                                array_push($tagids, $defaulttagid);
                                $args['tagid'] = $tagids;
                            }
                        }
                    }
                }

                //$user_draft = thread_draft_find_draft_by_tid($uid, thread_maxid());
                $user_draft = thread_draft_find_draft_by_subject($uid, param('subject', 'Untitled'));

                if ($user_draft) {
                    $r = thread_draft_update($uid, $user_draft['draftid'], $args);
                } else {
                    $r = thread_draft_create($uid, $args);
                }
                if ($r) {
                    message(0, '草稿已于' . date("Y-m-d H:i:s", time()) . '保存');
                } else {
                    message(3, '草稿栏位已满，本草稿未保存');
                    thread_draft_delete_expired($uid, $till_thread_draft_setting['draft_shelf_life']);
                }
            } else {
                message(1, 'Bad Request');
            }
            break;

        case 'edit': //编辑
            $slot = param(3, 0);
            $user_draft = thread_draft_read($uid, $slot);
            if ($method == 'GET') {

                // hook thread_create_get_start.php

                $fid = $user_draft['fid'];
                $forum = $fid ? forum_read($fid) : array();
                $forumlist_allowthread = forum_list_access_filter($forumlist, $gid, 'allowthread');
                $forumarr = xn_json_encode(arrlist_key_values($forumlist_allowthread, 'fid', 'name'));
                if (empty($forumlist_allowthread)) {
                    message(-1, lang('user_group_insufficient_privilege'));
                }

                $header['title'] = lang('create_thread');
                $header['mobile_title'] = $fid ? $forum['name'] : '';
                $header['mobile_linke'] = url('forum-' . $fid);

                // hook thread_create_get_end.php
                $form_title = lang('edit') . ' / ' . lang('publish') . ' ' . lang('draft');
                $form_action = url("thread-create");
                $form_doctype = 1;
                $form_subject = $user_draft['subject'];
                $form_message = $user_draft['message'];
                $form_submit_txt = lang('thread_create');

                $filelist = array();
                $isfirst = true;
                $isdraft = true;
                $quotepid = 0;

                $location = url("forum-'+jfid.checked()+'");

                include _include(APP_PATH . 'view/htm/post.htm');
                //读取
            } else {
                //保存
            }
            break;

        case 'publish': //发布；单个或多个
            $the_uid = param('uid', 0);
            $the_slot = param('slot', array());
            if ($method == 'POST' && !empty($the_slot)) {
                if ($user && ($the_uid == $user['uid'])) {
                    foreach ($the_slot as $key => $value) {
                        thread_draft_publish($the_uid, $value);
                    }
                    thread_draft_delete_expired($uid, $till_thread_draft_setting['draft_shelf_life']);
                }
            } else {
                message(1, 'Bad Request');
            }
            break;

        case 'delete': //删除；单个或多个
            $the_uid = param('uid', 0);
            $the_slot = param('slot', array());
            if ($method == 'POST' && !empty($the_slot)) {
                if ($user && ($the_uid == $user['uid'])) {
                    thread_draft_delete($the_uid, $the_slot);
                    message(0, '草稿已删除');
                } else {
                    message(1, 'Bad Request');
                }
            } else {
                message(1, 'Bad Request');
            }
            break;

        case 'delete_all': //删除全部
            if ($method == 'POST') {
                $the_uid = param('uid', 0);
                if ($user && ($the_uid == $user['uid'])) {
                    thread_draft_delete_all($the_uid);
                    message(0, '草稿已全部删除');
                } else {
                    message(1, 'Bad Request');
                }
            } else {
                message(1, 'Bad Request');
            }
            break;

        default: //获取列表
            thread_draft_delete_expired($uid, $till_thread_draft_setting['draft_shelf_life']);

            $draftlist = thread_draft_list($uid);
            if ($method == 'GET') {
                include _include(APP_PATH . 'plugin/till_thread_draft/view/htm/my_draft.htm');
            } else if ($ajax) {
                message(0, $draftlist);
            }
            break;
    }
}