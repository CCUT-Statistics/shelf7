<?php
!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;
#--»ШМы--
db_exec("ALTER TABLE {$tablepre}post DROP INDEX uid_pid;");



?>