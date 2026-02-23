<?php

!defined('DEBUG') AND exit('Forbidden');
$setting = setting_get('till_news_ticker_setting');

 
if($setting['delete_setting_on_uninstall'] == 1){
setting_delete('till_news_ticker_setting');
}