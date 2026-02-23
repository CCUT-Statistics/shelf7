<?php

!defined('DEBUG') and exit('Forbidden');
$setting = setting_get('till_thread_draft_setting');
if ($setting['delete_all_settings_and_drafts_after_uninst']) {
    setting_delete('till_thread_draft_setting');
}