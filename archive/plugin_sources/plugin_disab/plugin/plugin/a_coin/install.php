<?php 
// +----------------------------------------------------------------------
// | Author: 无双君 <1718905538@qq.com>
// +----------------------------------------------------------------------
// | QQ: 1718905538
// +----------------------------------------------------------------------
// | 功能: 金币插件
// +----------------------------------------------------------------------

!defined('DEBUG') AND exit('Forbidden');
$tablepre = $db->tablepre;

$sql = "ALTER TABLE {$tablepre}thread ADD COLUMN attach_golds INT(10) DEFAULT '0'";//添加附件下载金币
db_exec($sql);

$sql = "ALTER TABLE {$tablepre}thread ADD COLUMN content_golds INT(10) DEFAULT '0'";//添加内容查看金币
db_exec($sql);

//新建帖子支付表
$sql="CREATE TABLE IF NOT EXISTS `{$tablepre}ws_thread_pay` (
  `tid` int(10) NOT NULL COMMENT '帖子id',
  `uid` int(10) NOT NULL COMMENT '用户id',
  `coin` int(10) COMMENT '支付金币',
  `type` int(2) DEFAULT '0' COMMENT '支付类型1内容付费2附件付费',
  `paytime` int(10) COMMENT '支付时间'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
db_exec($sql);
?>