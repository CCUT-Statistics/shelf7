<?php !defined('DEBUG') and exit('Access Denied.'); ?>
<template include="./plugin/abs_theme_stately/overwrite/plugin/fox_alipay/oddfox/template/mypay.template.php">
    <slot name="my_body">
            <form action="<?php echo url('my-pay'); ?>" method="post" id="formpay">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="alert alert-info" role="alert">
                        <i class="icon-bell"></i> <?php echo $fox_tips; ?>
                        <!---->

            
                        <?php

                        // hook fox_pay_my_pay_tips_after.php
                        
                        ?>
                        <!---->

                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="basic-default-fullname">充值金额</label>
                        <div class="input-group">
                            <input type="number" name="amount" id="amount" value="<?php echo $pay_rmbstr_arr[0]; ?>" placeholder="请输入金额" value="<?= isset($kwd) && !empty($kwd) ? $kwd : '' ?>" min="1" step="1" maxlength="4" class="form-control" />
                            <div class="input-group-append"><button id="submit" class="btn btn-primary" data-loading-text="请稍候……">立即充值</button></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">快捷金额</label>
                        <div class="btn-group" role="group">
                            <?php foreach ($pay_rmbstr_arr as $k => $v) { ?>
                                <span class="payamount btn btn-sm btn-outline-warning <?php if (empty($k)) { ?>active<?php } ?>" payamount="<?php echo $v; ?>"><?php echo $v; ?>元</span>
                            <?php } ?>
                            <span class="payamount btn btn-sm btn-outline-warning other" payamount="">其他</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div id="picbox" class="foxpay-box w-100 mb-2 collapse">
                        <div class="w-100 mb-2"><b>扫码付款：</b></div>
                        <div class="clearfix">
                            <div class="mb-3"><img id="piccode" src="plugin/fox_alipay/oddfox/static/img/wait_qr.png" class="img-fluid border" width="300" /></div>
                        </div>
                    </div>
                    <div class="queryfeedback mb-3" style="display:none"></div>

                    <button type="button" id="payquery" class="btn btn-warning" data-loading-text="正在查询支付状态..." data-orderid="0" style="display:none">已完成付款</button>
                </div>
            </div>
        </form>
    </slot>
</template>
<script>
    $('a[data-active="my-pay"]').addClass('active');
    var pay_default = <?php echo $fox_alipay_arr['pay_min']; ?>;
</script>
<script src="plugin/fox_alipay/oddfox/static/js/fox_paycheck.js"></script>