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

//删除附件金币字段
$sql = "ALTER TABLE {$tablepre}thread drop column attach_golds";
db_exec($sql);

//删除内容查看金币字段
$sql = "ALTER TABLE {$tablepre}thread drop column content_golds";
db_exec($sql);

//删除帖子支付表
$sql="DROP TABLE {$tablepre}ws_thread_pay";
db_exec($sql);
?>