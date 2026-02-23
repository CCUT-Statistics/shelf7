<?php !defined('DEBUG') AND exit('Access Denied.');?>
<template include="./plugin/abs_theme_stately/overwrite/view/htm/my.common.template.htm">
    <slot name="my_nav">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link " href="<?php echo url("my-pay");?>" data-active="my-pay">帐户充值</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo url("my-paylist");?>" data-active="my-paylist">充值记录</a>
            </li>
<li class="nav-item">
                <a class="nav-link " href="<?php echo url("my-phelp");?>" data-active="my-phelp">金币兑换</a>
            </li>
        </ul>
    </slot>
</template>
<script>$('a[data-active="menu-my-pay"]').addClass('active');</script>