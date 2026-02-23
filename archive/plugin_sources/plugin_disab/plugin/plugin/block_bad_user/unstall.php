<?php
/*** @技术支持 一起smart https://www.iqismart.com***/
!defined('DEBUG') AND exit('Forbidden');$r = kv_delete('block_bad_user');message(0, '<p>这就走了吗?有点不舍，但我还是得放手的吧。再见啦。</p><a role="button" class="btn btn-secondary btn-block m-t-1" href="javascript:history.back();">返回</a>');$r === FALSE AND message(-1, '删除表结构失败');?>