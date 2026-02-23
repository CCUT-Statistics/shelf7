//<?php
if($action == 'wat'){}
elseif($action == 'show_all_reply') {
    $this_pid = param(2,0);
    $page = param(3,1);
    $this_post = post_read_cache($this_pid);
    $postlist = post_find(
        array('quotepid' => $this_pid),
        array('create_date' => 1),
        $page
    );

    /**
     * 回帖引用链（从当前层到顶层）
     * 
     * 寻找与指定回帖ID相关的回帖ID
     * 从最后一个回帖开始，一路回溯到一开始的回帖
     * 
     * @param int $pid 
     * @return array
     */
    function pid_chain_upwards($pid) {
        $r = array();
        if(is_array($pid) && $pid[count($pid) - 1]['pid'] === 0) {
            array_pop($pid);
            $r = $pid;
        } elseif (is_array($pid)) {
            $r = $pid;
            $this_pid = $r[count($r) - 1]['pid'];
            $this_depth = $r[count($r) - 1]['depth'];
            $this_post = post_read_cache((int)$this_pid);
            $r[] = array(
                'pid' => (int)$this_post['quotepid'],
                'depth' => $this_depth - 1,
            );
            return pid_chain_upwards($r);
        } elseif(is_numeric($pid)) {
            $r[] = array(
                'pid' => $pid,
                'depth' => 0,
            );
            $this_post = post_read_cache((int)$pid);
            $r[] = array(
                'pid' => (int)$this_post['quotepid'],
                'depth' => -1,
            );
            return pid_chain_upwards($r);
        }
        return $r;
    }

    /**
     * 回帖引用链（从当前层到底层）
     * 
     * 寻找与指定回帖ID相关的回帖ID
     * 从当前回帖开始，一路挖掘到最后一个回帖
     * 
     * @param int $pid 
     * @return array
     */
    function pid_chain_downwards($pid) {
        $r = array();
        if (is_array($pid)) {
            $r = $pid;
            $this_pid = $r[count($r) - 1]['pid'];
            $this_depth = $r[count($r) - 1]['depth'];
            $next_post = post_find(
                array('quotepid' => $this_pid),
                array('create_date' => 1),
                1
            );
            if (!empty($next_post)) {
                if(count($next_post) > 1) {
                    $next_post = end($next_post);
                } else {
                    $next_post = reset($next_post);
                }
                
                $r[] = array(
                    'pid' => (int)$next_post['pid'],
                    'depth' => $this_depth + 1,
                );
                return pid_chain_downwards($r);
            }
        } elseif(is_numeric($pid)) {
            $r[] = array(
                'pid' => $pid,
                'depth' => 0,
            );
            $next_post = post_find(
                array('quotepid' => $pid),
                array('create_date' => 1),
                1
            );
            if (!empty($next_post)) {
                if(count($next_post) > 1) {
                    $next_post = end($next_post);
                } else {
                    $next_post = reset($next_post);
                }
                $r[] = array(
                    'pid' => (int)$next_post['pid'],
                    'depth' => 1,
                );
                return pid_chain_downwards($r);
            }
        }
        return $r;
    }

    /**
     * 重新排序“回帖引用链”，让源头回帖在最前
     * @param array $arr 
     * @return array 重组后的数组
     */
    function pid_chain_reformat($arr) {
        if (isset($arr[1]) && $arr[1]['depth'] < 0) {
            // 0, -1, -2...倒序需要处理
            usort($arr, function ($a, $b) {
                if ($a['depth'] == $b['depth']) {
                    return $a['pid'] <=> $b['pid'];
                }
                return $a['depth'] <=> $b['depth'];
            });
        } else {
            // 0, 1, 2...正序不需要处理
        }
        return array_column($arr, 'pid');
    }

    /**
     * 删除第一个blockquote标签
     * 一般来说，引用回帖的第一个blockquote标签为引用的内容，我们不需要它。
     * 如果没有blockquote标签的话，就直通输出
     * 
     * @param string $content 要解析的消息。
     * @return string
     */
    function message_fmt_strip_first_blockquote($content) {
        $result_content = '';
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">'. $content,LIBXML_NOERROR);
        $blockquoteElements = $dom->getElementsByTagName('blockquote');
        $blockquoteElement = $blockquoteElements->item(0);
        if (!is_null($blockquoteElement)) {
            $blockquoteElement->parentNode->removeChild($blockquoteElement);
            $result_content = $dom->saveHTML();
            preg_match('/<body>(.*?)<\/body>/s', $result_content, $match);
            $result_content = $match[1];
            return $result_content;
        } else {
            unset($blockquoteElement,$blockquoteElements,$dom);
            return $content;
        }
    }
    
    if($this_post['quotepid'] == 0) {
        $parent_pids = pid_chain_reformat(pid_chain_downwards($this_pid));
    } else {
        $parent_pids = pid_chain_reformat(pid_chain_upwards($this_pid));
    }
    $chain_postlist = post_find_by_pids($parent_pids);
    foreach($chain_postlist as &$__post) {
        $__post['message_fmt'] = message_fmt_strip_first_blockquote($__post['message_fmt']);
        $__post['classname'] = $__post['pid'] == $this_pid ? 'border border-primary rounded ' : '';

    }

    if(count($chain_postlist) > 1) {
        $chain_postlist = arrlist_multisort($chain_postlist,'create_date');
    }

    $chain_postlist_simp =  array_column($chain_postlist, 'pid');

    include _include(APP_PATH.'plugin/till_post_view_chain/view/htm/post_chain.htm');
}