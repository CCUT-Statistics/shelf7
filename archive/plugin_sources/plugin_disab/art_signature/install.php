<?php
/**
 * 用户签名插件安装文件
 */ 
!defined('DEBUG') and exit('Forbidden');
$tablepre = $db->tablepre;
$sql = "ALTER TABLE {$tablepre}user ADD COLUMN signature VARCHAR(255) NOT NULL DEFAULT '' COMMENT '用户签名'";
$r = db_exec($sql);
$get_signature = kv_get('user_signature');
if (!$get_signature) { $get_signature = array('position'=>'1', 'html'=>'1', 'characters'=>'120', 'report'=>'柒月笔记'); kv_set('user_signature', $get_signature); }
$r === false and message(-1, '<p>创建表结构失败，请检查数据库是否已存在相同字段。</p> <a role="button" class="btn btn-secondary btn-block m-t-1" href="javascript:history.back();">返回</a>');