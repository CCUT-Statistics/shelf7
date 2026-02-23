<?php
!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;
#--用户中心回帖展示--
db_exec("ALTER TABLE {$tablepre}post ADD INDEX uid_pid(uid, pid);");

#--插件预设值和--
#$cf_theme_modern = array();
#setting_set('cf_theme_modern', $cf_theme_modern); 
?>