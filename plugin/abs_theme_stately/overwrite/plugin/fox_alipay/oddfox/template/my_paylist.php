<?php !defined('DEBUG') AND exit('Access Denied.');?>
<template include="./plugin/abs_theme_stately/overwrite/plugin/fox_alipay/oddfox/template/mypay.template.php">
<slot name="my_body">
<table class="table table-hover mb-0">
    <thead>
    <tr>
        <th>订单号</th>
        <th>支付宝订单号</th>
        <th class="text-lg-right">支付金额</th>
        <?php if($fox_alipay_arr['pay_ratio'] > 1){?><th class="text-lg-right">到账金额</th><?php }?>
        <th>付款时间</th>
        <th class="text-lg-right">支付状态</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($paylist as $val){?>
    <tr>
        <td data-label="订单号"><?php echo $val['orderid'];?></td>
        <td data-label="支付宝订单号"><?php echo $val['pay_trade_no_fmt'];?></td>
        <td data-label="支付金额" class="text-lg-right"><?php echo $val['money'];?>元</td>
        <?php if($fox_alipay_arr['pay_ratio'] > 1){?><td data-label="到账金额" class="text-lg-right"><?php echo $val['pay_rmbs_fmt']/100.0;?>元</td><?php }?>
        <td data-label="付款时间"><?php echo $val['pay_date_fmt'];?></td>
        <td data-label="支付状态" class="text-lg-right"><?php echo $val['pay_status_fmt'];?></td>
    </tr>
    <?php }?>
    </tbody>
</table>
<?php if($pagination){?>
<nav class="border-top pt-3"><ul class="pagination justify-content-center flex-wrap mb-0"><?php echo $pagination;?></ul></nav>
<?php }?>
</slot>
</template>
<script>$('a[data-active="my-paylist"]').addClass('active');</script>