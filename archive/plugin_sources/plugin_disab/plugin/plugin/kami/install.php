<?php

/*
	安装
*/

!defined('DEBUG') AND exit('Forbidden');

$sql = "CREATE TABLE IF NOT EXISTS bbs_kami (
`kahao`  int UNSIGNED NOT NULL AUTO_INCREMENT ,
`kami`  varchar(255) NOT NULL DEFAULT 0 ,
`mianzhi`  int UNSIGNED NOT NULL DEFAULT 0 ,
`uid`  int UNSIGNED NOT NULL DEFAULT 0 ,
`riqi`  char(20) NOT NULL DEFAULT 0 ,
PRIMARY KEY (`kahao`)
)DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
;";
db_exec($sql);