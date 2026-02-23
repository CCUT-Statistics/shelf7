<?php 
// +----------------------------------------------------------------------
// | Author: 爱好者 <i@xiu.no>
// +----------------------------------------------------------------------
// | QQ: 951869
// +----------------------------------------------------------------------
// | 功能: 头挂插件
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