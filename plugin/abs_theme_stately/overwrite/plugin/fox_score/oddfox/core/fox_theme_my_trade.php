<?php !defined('DEBUG') and exit('Access Denied.'); ?>
<template include="./plugin/abs_theme_stately/overwrite/plugin/fox_score/oddfox/core/fox_theme_my_score.template.php">
  <slot name="my_body">
    <?php if (!empty($group['allowtrade'])) { ?>
      <form role="form" action="<?php echo url('my-trade'); ?>" method="post" id="form" class="row">
        <div class="col-12">
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><?php echo lang('score_trade_other_party'); ?></span></div>
            <input type="text" name="trade_username" id="trade_username" maxlength="16" placeholder="<?php echo lang('score_trade_please_input') . lang('score_trade_other_party'); ?>" class="form-control" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><?php echo lang('score_trade_select'); ?></span></div>
            <select name="score_type" class="form-select" id="score_type">
              <option value="1"><?php echo $conf['exp_name']; ?></option>
              <option value="2" selected><?php echo $conf['gold_name']; ?></option>
              <option value="3"><?php echo $conf['rmb_name']; ?></option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><?php echo lang('score_exchange_golds') . lang('score_trade_or') . lang('score_exchange_rmbs'); ?></span></div>
            <input type="text" name="trade_num" id="trade_num" maxlength="5" placeholder="<?php echo lang('score_trade_please_input') . lang('score_trade') . lang('score_exchange_golds') . lang('score_trade_or') . lang('score_exchange_rmbs'); ?>" class="form-control" />
          </div>
        </div>
        <div class="col-12">
          <button type="submit" id="submit" class="btn btn-primary btn-block my-3"><?php echo lang('confirm') . lang('submit'); ?></button>
        </div>
      </form>
    <?php } ?>

  </slot>
</template>
<script>
  <?php if (!empty($group['allowtrade'])) { ?>
    $("#trade_num").bind("input propertychange", function(event) {
      if (this.value.length == 1) {
        this.value = this.value.replace(/[^1-9]/g, '');
      } else {
        this.value = this.value.replace(/\D/g, '');
      }
    });
    var jform = $('#form');
    var jsubmit = $('#submit');
    jform.on('submit', function() {
      jform.reset();
      jsubmit.button('loading');
      var postdata = jform.serializeObject();
      $.xpost(jform.attr('action'), postdata, function(code, message) {
        if (code == 0) {
          $.alert(message);
          jsubmit.button(message).delay(3000).button('reset').location(xn.url("my-record"));
        } else if (xn.is_number(code)) {
          alert(message);
          jsubmit.button('reset');
        } else {
          jform.find('[name="' + code + '"]').alert(message).focus();
          jsubmit.button('reset');
        }
      });
      return false;
    });
  <?php } ?>
  $('a[data-active="my-trade"]').addClass('active');
</script>