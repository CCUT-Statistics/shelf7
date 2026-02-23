//<?php
    /* Stately Threadlist init for WellCMS BEGIN */

    /**
     * @var string $stately_threadlist_style 帖子列表风格
     */
    $stately_threadlist_style = '';
    if (!isset($stately_threadlist_style_override)) {
        if ($fid && isset($abs_theme_stately_setting['wellcms_ui_style']['threadlist']['style_for_forum'][$fid])) {
            if ($abs_theme_stately_setting['wellcms_ui_style']['threadlist']['style_for_forum'][$fid] === '_inherit') {
                $stately_threadlist_style = $abs_theme_stately_setting['wellcms_ui_style']['threadlist']['style_global'];
            } else {
                $stately_threadlist_style = $abs_theme_stately_setting['wellcms_ui_style']['threadlist']['style_for_forum'][$fid];
            }
        } else {
            $stately_threadlist_style = $abs_theme_stately_setting['wellcms_ui_style']['threadlist']['style_global'];
        }
    } else {
        $stately_threadlist_style = $stately_threadlist_style_override;
        unset($stately_threadlist_style_override);
    }
    if (DEBUG === 2) {
        echo ('<!-- style: ' . $stately_threadlist_style . ' -->');
    };


    /**
     * @var int $stately_threadlist_cols_count 帖子列表列数
     */
    $stately_threadlist_cols_count = 12;
    if (!isset($stately_threadlist_cols_count_override)) {
        
        if ($fid && isset($abs_theme_stately_setting['wellcms_ui_style']['threadlist']['cols_count_for_forum'][$fid])) {
            
            if ( is_numeric($abs_theme_stately_setting['wellcms_ui_style']['threadlist']['style_for_forum'][$fid]) || strcmp($abs_theme_stately_setting['wellcms_ui_style']['threadlist']['style_for_forum'][$fid], '_inherit') !== 0) {
                
                $stately_threadlist_cols_count = $abs_theme_stately_setting['wellcms_ui_style']['threadlist']['cols_count_for_forum'][$fid];

            } else {
                
                $stately_threadlist_cols_count = $abs_theme_stately_setting['wellcms_ui_style']['threadlist']['cols_count_global'];

            }
        } else {
            $stately_threadlist_cols_count = $abs_theme_stately_setting['wellcms_ui_style']['threadlist']['cols_count_global'];
        }
    } else {
        $stately_threadlist_cols_count = $stately_threadlist_cols_count_override;
    }
    if (DEBUG === 2) {
        echo ('<!-- cols: ' . $stately_threadlist_cols_count . ' -->');
    };


    /**
     * @var string $stately_threadlist_class_add 帖子列表衬底
     */
    $stately_threadlist_class_add = '';
    if (in_array($stately_threadlist_style, array(
        'super-compact_v1',
    ))) {
        $stately_threadlist_class_add = 'card card-body py-2';
    }

    /* 普通帖子 */
    if ($abs_theme_stately_setting['ui_tweek']['homepage']['show_alltopthreads'] && $route === 'index' && $page === 1) {
        if (!isset($threadlist)) {
            $threadlist = thread_find_by_fids($fids, $page, $pagesize, $order, $threads);
        }
        thread_list_access_filter($threadlist, $gid); //过滤没有权限访问的帖子
    }
/* Stately Threadlist init for WellCMS END */