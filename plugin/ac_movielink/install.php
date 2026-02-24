<?php
!defined('DEBUG') AND exit('Forbidden');
$tablepre = $db->tablepre;
$sql = "CREATE TABLE IF NOT EXISTS {$tablepre}movielink (
  linkid bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  type smallint(11) NOT NULL DEFAULT '0',
  create_date int(11) unsigned NOT NULL DEFAULT '0',
  name varchar(64) NOT NULL DEFAULT '',
  url varchar(2048) NOT NULL DEFAULT '',
  imgurl varchar(2048) NOT NULL DEFAULT '',
  nametype  char(64) NOT NULL DEFAULT '',
  start_time varchar(64) NOT NULL DEFAULT '', 
  end_time varchar(64) NOT NULL DEFAULT '',  
  PRIMARY KEY (linkid),
  KEY type (type)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
";
$r = db_exec($sql);

$count = db_count('movielink');
if (intval($count) === 0) {
	$sql = "INSERT INTO {$tablepre}movielink SET type='0', name='示例影片', url='正片\$https://example.com/index.m3u8', imgurl='view/img/logo.png', nametype='1', start_time='00:00', end_time='00:00'";
	$r = db_exec($sql);
}
?>