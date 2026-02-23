<?php

/*
	Xiuno BBS 4.0 URL别名
	admin/plugin-unstall-wish_aliasname.htm
*/

!defined('DEBUG') AND exit('Forbidden');

//初始化插件配置
$wish_gowild = setting_get('wish_gowild');
if(empty($wish_gowild)){
    $data['main_title'] = '即将离开NT社区';
    $data['sub_title'] = '您即将离开NT社区，请注意您的帐号和财产安全。';
    $data['btn_text'] = '继续访问';
    $data['blank'] = 'yes';
    $data['safe_tips'] = 'yes';
    $data['is_count'] = 'yes';
    $data['is_count_detail'] = 'yes';
    $data['jump_now'] = 'no';
    $data['add_nofollow'] = 'yes';
    $data['group'] = '1,2,4.5';
    setting_set('wish_gowild', $data);
}

//初始化数据库
$tablepre = $db->tablepre;
$sql="CREATE TABLE IF NOT EXISTS {$tablepre}go_wild  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `url` varchar(255) NOT NULL DEFAULT '',
  `from_url` varchar(255) NOT NULL DEFAULT '',
  `ip` char(15) NOT NULL DEFAULT '',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_uid_url_create_time`(`uid`, `url`, `create_time`),
  INDEX `idx_url`(`url`),
  INDEX `idx_from_url`(`from_url`),
  INDEX `idx_create_time`(`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
db_exec($sql);
?>