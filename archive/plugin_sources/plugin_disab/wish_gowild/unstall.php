<?php

/*
	Xiuno BBS 4.0 URL别名
	admin/plugin-unstall-wish_aliasname.htm
*/

!defined('DEBUG') AND exit('Forbidden');

//删除数据库配置
if(setting_get('wish_gowild')){
    setting_delete('wish_gowild');
}

//删除统计数据
//if(kv_cache_get('wish_gowild_count_data')){
//    kv_cache_delete('wish_gowild_count_data');
//}

?>