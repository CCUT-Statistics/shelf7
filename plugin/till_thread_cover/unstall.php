<?php
defined('DEBUG') OR exit('Forbidden');
$tablepre = $db->tablepre;
//db_exec("ALTER TABLE `{$tablepre}thread` DROP COLUMN `cover`;");
setting_delete('till_thread_cover_setting');
?>