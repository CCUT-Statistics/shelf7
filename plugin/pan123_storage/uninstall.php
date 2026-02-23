<?php

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;

$sql = "DROP TABLE IF EXISTS {$tablepre}pan123_map;";
db_exec($sql);
$sql = "DROP TABLE IF EXISTS {$tablepre}pan123_task;";
db_exec($sql);

setting_set('pan123_storage', array());

?>
