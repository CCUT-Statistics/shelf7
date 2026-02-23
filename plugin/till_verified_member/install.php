<?php
!defined('DEBUG') and exit('Forbidden');
$tablepre = $db->tablepre;

try {

  if (!isset($user["v"])) { //如果缺少v
    $sql = "ALTER TABLE " . $tablepre . "user ADD v tinyint(3) NOT NULL default '0' COMMENT '认证级别';";
    $r = db_exec($sql);
    $r === FALSE and message(-1, '创建用户表结构失败_v');
  }
  if (!isset($user["v_title"])) { //如果缺少v_title
    $sql = "ALTER TABLE " . $tablepre . "user ADD v_title CHAR(255) NOT NULL default '' COMMENT '认证头衔';";
    $r = db_exec($sql);
    $r === FALSE and message(-1, '创建用户表结构失败_t');
  }

  $sq2 = "CREATE TABLE IF NOT EXISTS {$tablepre}till_v_apply (
    `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
    `create_time` bigint(11) unsigned DEFAULT NULL COMMENT '创建时间',
    `v` tinyint(3) DEFAULT NULL COMMENT '认证级别',
    `v_title` varchar(255) DEFAULT NULL COMMENT '认证头衔',
    `v_info` varchar(255) DEFAULT NULL COMMENT '证明信息',
    `v_file` varchar(255) DEFAULT NULL COMMENT '证明文件；二次开发用',
    `status` tinyint(3) NOT NULL COMMENT '审核状态 -1拒绝 0待审核 1成功',
    `remark` varchar(255)  DEFAULT NULL COMMENT '备注，拒绝原因',
    PRIMARY KEY (`uid`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
  $s = db_exec($sq2);
  $s === FALSE and message(-1, '创建加V认证审核表结构失败');
} catch (Exception $e) {
  message(-1, $e);
}

$PLUGIN_SETTING = setting_get('till_verified_member_setting');
if (empty($PLUGIN_SETTING)) {

  $PLUGIN_SETTING = array(
    // ========== 认证类型 ==========
    'v_type_1_activated' => true, //允许用户选择这种认证类型？（下同）
    'v_type_1_name' => '个人认证', //认证等级名称
    'v_type_1_description' => '大V达人', //认证等级名称
    'v_type_1_color' => 'warning', //认证等级颜色
    'v_type_1_color_custom' => '#ffc107', //自定义颜色
    'v_type_1_shape' => 'circle', //自定义形状
    'v_type_1_requirement' => '1. 粉丝数量>=500000；2. 提交实名认证；请联系站长了解详情', //认证等级要求（只是文字）
    'v_type_1_credit_use' => true, //申请使用积分吗
    'v_type_1_credit_type' => 'golds', //申请使用积分类型
    'v_type_1_credit_amount' => 1, //申请使用积分数量
    'v_type_1_icon' => 'check', //图标名称

    'v_type_2_activated' => true,
    'v_type_2_name' => '知名用户认证',
    'v_type_2_description' => '',
    'v_type_2_color' => 'secondary',
    'v_type_2_color_custom' => '#9a5ce5',
    'v_type_2_shape' => 'circle',
    'v_type_2_requirement' => '1. 粉丝数量累计>=100000；2. 提交实名认证；3. 发帖数量大于100；请联系站长了解详情',
    'v_type_2_credit_use' => true,
    'v_type_2_credit_type' => 'golds',
    'v_type_2_credit_amount' => 10,
    'v_type_2_icon' => 'check',


    'v_type_3_activated' => true,
    'v_type_3_name' => '社会名人认证',
    'v_type_3_description' => '社会知名人士',
    'v_type_3_color' => 'primary',
    'v_type_3_color_custom' => '#007bff',
    'v_type_3_shape' => 'circle',
    'v_type_3_requirement' => '1. 提交实名认证；请联系站长了解详情',
    'v_type_3_credit_use' => true,
    'v_type_3_credit_type' => 'golds',
    'v_type_3_credit_amount' => 100,
    'v_type_3_icon' => 'check',

    'v_type_4_activated' => true,
    'v_type_4_name' => '企业认证',
    'v_type_4_description' => '企业官方帐号',
    'v_type_4_color' => 'info',
    'v_type_4_color_custom' => '#17a2b8',
    'v_type_4_shape' => 'circle',
    'v_type_4_requirement' => '请联系站长了解详情',
    'v_type_4_credit_use' => true,
    'v_type_4_credit_type' => 'golds',
    'v_type_4_credit_amount' => 1000,
    'v_type_4_icon' => 'check',

    'v_type_5_activated' => true,
    'v_type_5_name' => '机构认证',
    'v_type_5_description' => '机构、媒体等可申请',
    'v_type_5_color' => 'info',
    'v_type_5_color_custom' => '#f15bb5',
    'v_type_5_shape' => 'circle',
    'v_type_5_requirement' => '请联系站长了解详情',
    'v_type_5_credit_use' => true,
    'v_type_5_credit_type' => 'golds',
    'v_type_5_credit_amount' => 10000,
    'v_type_5_icon' => 'check',

    // ========== 全局设置 ==========
    'v_allow_user_apply' => true, //允许用户前台申请
    'v_lock_user_apply' => false, //用户申请后不可再次申请
    'v_return_credits_when_reject' => false, //审核拒绝时返还积分

    // ===== 显示位置，true为显示 =====
    //用户名旁
    'v_show_header_nav_username_after' => true,
    'v_show_post_list_inc_username_after' => true,
    'v_show_my_common_username_after' => true,
    'v_show_thread_list_inc_username_before' => true,
    //'v_show_thread_quick_reply_message_before' => true,
    'v_show_thread_username_before' => true,
    'v_show_thread_user_username_after' => true,
    'v_show_user_profile_username_after' => true,

    //头像旁
    'v_show_thread_list_inc_avatar_after' => false,
    'v_show_thread_user_avatar_after' => false,
    'v_show_post_list_inc_avatar_after' => false,
    'v_show_user_profile_avatar_after' => false,
    'v_show_my_common_avatar_after' => false,

    // ===== 申请验证页面 =====
    'v_page_my_apply_before_select_title' => '申请认证',
    'v_page_my_apply_before_select_text' => '请选择要申请的认证类型',
    'v_page_my_apply_after_select_title' => '认证优势',
    'v_page_my_apply_after_select_text' => '认证专属标识——彰显身份',
    'v_page_my_apply_before_form_title' => '认证须知',
  );

  setting_set('till_verified_member_setting', $PLUGIN_SETTING);
}