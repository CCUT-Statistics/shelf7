<?php
!defined('DEBUG') and exit('Forbidden');

$tablepre = $db->tablepre;
$sql = "ALTER TABLE {$tablepre}forum ADD COLUMN cover_url TEXT DEFAULT '' COMMENT '封面图网址'";
db_exec($sql);
