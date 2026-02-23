<?php

 

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;
$sql = "CREATE TABLE IF NOT EXISTS `{$tablepre}attach_buy` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
    `uid` int(11) NOT NULL COMMENT '用户ID',
    `aid` int(11) NOT NULL COMMENT 'aid',
    `create_date` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件购买'";
db_exec($sql);

 