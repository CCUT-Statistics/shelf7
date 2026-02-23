<?php !defined('DEBUG') and exit('Access Denied.');?>
<template include="./plugin/abs_theme_stately/overwrite/view/htm/my.common.template.htm">
    <slot name="my_nav">
        <ul class="nav nav-pills">
            <!--{hook my_nav_score_before.htm}-->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo url("my-score"); ?>" data-active="my-score"><?php echo lang('my_score'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo url("my-record"); ?>" data-active="my-record"><?php echo lang('my_record'); ?></a>
            </li>

            <?php if (!empty($conf['exchange']) || !empty($conf['disexchange'])) {?>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo url("my-exchange"); ?>" data-active="my-exchange"><?php echo lang('my_exchange'); ?></a>
            </li>
            <?php }?>

            <?php if ($group['allowtrade'] == '1') {?>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo url("my-trade"); ?>" data-active="my-trade"><?php echo lang('my_trade'); ?></a>
            </li>
            <?php }?>
            <!-- 提现 -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo url("my-withdrawal"); ?>" data-active="my-withdrawal"><?php echo lang('my_withdrawal'); ?></a>
            </li>
            <!--{hook my_nav_score_after.htm}-->
        </ul>
    </slot>
</template>
<script>$('a[data-active="menu-my-score"]').addClass('active');</script>