<?php
!defined('DEBUG') AND exit('Forbidden');
$tablepre = $db->tablepre;
$sql = "ALTER TABLE ".$tablepre."group ADD reward_from1 INT(10) NOT NULL default '0';";
db_exec($sql);
$sql = "ALTER TABLE ".$tablepre."group ADD reward_from2 INT(10) NOT NULL default '0';";
db_exec($sql);
$sql = "ALTER TABLE ".$tablepre."group ADD reward_from3 INT(10) NOT NULL default '0';";
db_exec($sql);
$sql = "ALTER TABLE ".$tablepre."group ADD reward_to1 INT(10) NOT NULL default '0';";
db_exec($sql);
$sql = "ALTER TABLE ".$tablepre."group ADD reward_to2 INT(10) NOT NULL default '0';";
db_exec($sql);
$sql = "ALTER TABLE ".$tablepre."group ADD reward_to3 INT(10) NOT NULL default '0';";
db_exec($sql);
$sql = "ALTER TABLE ".$tablepre."thread ADD have_reward INT(5) NOT NULL default '0';";
db_exec($sql);
group_list_cache_delete();
setting_set('tt_reward',array('self_use'=>1,'limit'=>3));

$sql="CREATE TABLE IF NOT EXISTS `{$tablepre}reward` (
  `reward_id` int(10) NOT NULL AUTO_INCREMENT,
  `tid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `credits` int(10) NOT NULL,
  `golds` int(10) NOT NULL,
  `rmbs` int(10) NOT NULL,
  `time` int(20) NOT NULL,
  PRIMARY KEY (reward_id),					# 
	KEY (reward_id),						# 
	UNIQUE KEY (reward_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
db_exec($sql);
?>