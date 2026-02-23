<?php !defined('DEBUG') and exit('Access Denied.');
if ($thread['sell_type'] == 1 && $thread['uid'] == $uid && $gid == 1 && $page == 1) {
    if (!empty($paylog_text)) {
        echo '<div class="alert fox_fieldset alert-success mt-2 text-success" role="alert"> <i class="icon-shopping-cart"></i> 收费附件' . $paylog_text . '</div>';
    }
}
if ($thread['sell_type'] == 1 && $thread['uid'] != $uid && $gid != 1 && $page == 1 && $first['buy_ok'] == 1) {
    echo '<div class="alert fox_fieldset alert-success mt-2 text-success" role="alert"> <i class="icon-shopping-cart"></i>您已付费</div>';
}
