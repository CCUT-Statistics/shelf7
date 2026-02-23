<?php !defined('DEBUG') and exit('Access Denied.');
if ($first['buy_ok'] == '0') {
    $str = '<div style="margin-bottom:8px;text-align:center;width:100%;">确定支付 <span class="total font-weight-bold text-danger">' . $thread['price'] . '</span> ' . $price_name . '?</div>';
    if ($conf['vip_on'] == 1 && $conf['vip_dis_on'] == 1) {
        if (vip_isvip($uid)) {
            $now_discount = $conf['dis_forum'][$fid];
            if ($now_discount > 0 && $now_discount <= 10) {
                $buy_discount = $now_discount / 10;
            } else {
                $buy_discount = 1;
            }

            $str = '<div style="margin-bottom:8px;text-align:center;width:100%;">尊敬的vip用户特权,本次下载将享受' . $now_discount . '折优惠,确定支付 <span class="total font-weight-bold text-danger">' . ceil($thread['price'] * $buy_discount) . '</span> ' . $price_name . '?</div>';
        }
    }
    ?>
<script>
  var fox_js_str = '<?php echo $str; ?>',
    fox_js_login = '<?php echo lang('login'); ?>',
    fox_js_my_score = '<?php echo lang('my_score'); ?>';
</script>
<script src="plugin/fox_score/oddfox/static/js/fox_thread.js"></script>
<?php }?>