//<?php

/**
 * 帖子扩展 ghx_threadext 插件数据
 * 由魔法驱动
 */
if (function_exists('GetPostFlagEnable')) {
    if (!isset($PostFlagEnabled)) $PostFlagEnabled = GetPostFlagEnable();
    if (!isset($IsDisplaySummary)) $IsDisplaySummary = GetPluginCfgNode('ThreadBehavior/DisplaySummary', null, false);
    if (!isset($theadext_table)) $theadext_table = $ghx_cache->get_share_var(VAR_THREADEXT_TB);
    if (!isset($IsThreadExtension)) $IsThreadExtension = IsThreadExtensionAuthGroup($gid);
    if (!isset($IsAdjustViewTemplate)) $IsAdjustViewTemplate = (IsAdjustViewTemplateAuthGroup($gid) and $IsThreadExtension);
}

    /* Stately Threadlist init BEGIN */

    /**
     * @var string $stately_threadlist_style 帖子列表风格
     */
    $stately_threadlist_style = '';
    if (!isset($stately_threadlist_style_override)) {
        if ($fid && isset($abs_theme_stately_setting['ui_style']['threadlist']['style_for_forum'][$fid])) {
            if ($abs_theme_stately_setting['ui_style']['threadlist']['style_for_forum'][$fid] === '_inherit') {
                $stately_threadlist_style = $abs_theme_stately_setting['ui_style']['threadlist']['style_global'];
            } else {
                $stately_threadlist_style = $abs_theme_stately_setting['ui_style']['threadlist']['style_for_forum'][$fid];
            }
        } else {
            $stately_threadlist_style = $abs_theme_stately_setting['ui_style']['threadlist']['style_global'];
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
        
        if ($fid && isset($abs_theme_stately_setting['ui_style']['threadlist']['cols_count_for_forum'][$fid])) {
            
            if ( is_numeric($abs_theme_stately_setting['ui_style']['threadlist']['style_for_forum'][$fid]) || strcmp($abs_theme_stately_setting['ui_style']['threadlist']['style_for_forum'][$fid], '_inherit') !== 0) {
                
                $stately_threadlist_cols_count = $abs_theme_stately_setting['ui_style']['threadlist']['cols_count_for_forum'][$fid];
            } else {
                
                $stately_threadlist_cols_count = $abs_theme_stately_setting['ui_style']['threadlist']['cols_count_global'];
            }
        } else {
            $stately_threadlist_cols_count = $abs_theme_stately_setting['ui_style']['threadlist']['cols_count_global'];
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
        'classic_v1',
        'classic_v2',
        'classic_v3',
        'classic_v4',
        'super-compact_v1',
        'super-compact_v2',
        'super-compact_v3',
        'qa_v1',
    ))) {
        $stately_threadlist_class_add = ' card card-body py-2';
    }
    if (in_array($stately_threadlist_style, array(
        'special-timeline_v1'
    ))) {
        $stately_threadlist_class_add = ' timeline';
    }

    /* 普通帖子 */
    if ($abs_theme_stately_setting['ui_tweek']['homepage']['show_alltopthreads'] && $route === 'index' && $page === 1) {
        if (!isset($threadlist)) {
            $threadlist = thread_find_by_fids($fids, $page, $pagesize, $order, $threads);
        }
        thread_list_access_filter($threadlist, $gid); //过滤没有权限访问的帖子
    }
/* Stately Threadlist init END */