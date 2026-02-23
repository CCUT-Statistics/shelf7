<?php

/**
 * 帖子收藏 更新文件
 *
 * @create 2018-2-24
 * @author deatil
 */
 
!defined('DEBUG') AND exit('Forbidden');

try{
  $sql = "ALTER TABLE ".$tablepre."v_apply MODIFY status int(11) NOT NULL default 0;";
  db_exec($sql);
 
}catch(Exception $e){}

 

?>