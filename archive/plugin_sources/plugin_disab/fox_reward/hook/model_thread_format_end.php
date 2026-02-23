<?php exit;
    $count_golds = fox_rewardlog_count_golds($thread['tid']);
    $thread['reward'] = !empty($count_golds) ? $count_golds : 0;
    unset($count_golds);
?>