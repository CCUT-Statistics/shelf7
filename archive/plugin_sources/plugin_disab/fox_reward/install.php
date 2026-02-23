<?php
/*
 * 奇狐插件 安装文件
 * QQ:77798085
 */

!defined('DEBUG') AND exit('Forbidden');
$tablepre = $db->tablepre;

$sql = "ALTER TABLE `{$tablepre}forum` ADD COLUMN `is_reward` tinyint(1) NOT NULL DEFAULT '0';";
db_exec($sql);

$sql = "UPDATE `{$tablepre}forum` SET `is_reward` = '1' WHERE `fid` =1;";
db_exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS `{$tablepre}fox_rewardlog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) unsigned NOT NULL DEFAULT '0',
  `oid` int(11) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `num` int(11) NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  `time` int(11) unsigned NOT NULL DEFAULT '0',
  `uip` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY (uid),
  KEY (tid, uid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
db_exec($sql);

$fox_reward_arr = kv_get('fox_reward');
if(empty($fox_reward_arr)) {
    $fox_reward_arr = array(
        'fox_golds_num_max' => 10,
        'fox_reward_max_num' => 10,
        'fox_golds_reduce' => 1,
        'fox_reward_reason' => '与人为善, 好运常伴！$$$赠人玫瑰, 手留余香！$$$谢谢@Thanks！$$$激动的心，颤抖的手，就想跟你喝杯酒！$$$黑凤梨！$$$激动人心, 无以言表！',
    );
    kv_cache_set('fox_reward', $fox_reward_arr);
}?>