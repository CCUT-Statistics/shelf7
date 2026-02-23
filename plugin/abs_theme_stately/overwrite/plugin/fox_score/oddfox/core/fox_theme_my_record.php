<?php !defined('DEBUG') and exit('Access Denied.');?>
<template include="./plugin/abs_theme_stately/overwrite/plugin/fox_score/oddfox/core/fox_theme_my_score.template.php">
  <slot name="my_body">
  <table class="table table-hover table-condensed">
            <thead>
              <tr>
                <th><?php echo lang('score_time'); ?></th>
                <th><?php echo lang('score_from'); ?></th>
                <th><?php echo lang('score_state'); ?></th>
                <th><?php echo lang('score_old'); ?></th>
                <th><?php echo lang('score_new'); ?></th>
                <th><?php echo lang('score_msg'); ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($scorelist as $val) {?>

              <tr>
                <td data-label="<?php echo lang('score_time'); ?>"><?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_and_time'], $val['time']); ?></td>
                <td data-label="<?php echo lang('score_from'); ?>"><?php echo lang('msg' . $val['msg_type']); ?></td>

                <td data-label="<?php echo lang('score_state'); ?>"><?php echo lang('score_state_' . $val['state']); ?></td>
                <td data-label="<?php echo lang('score_old'); ?>"><?php echo $val['old_num']; ?> <?php if ($val['exp_type'] == '1') {echo $conf['exp_unit'] . $conf['exp_name'];} elseif ($val['exp_type'] == '2') {echo $conf['gold_unit'] . $conf['gold_name'];} else {echo $conf['rmb_unit'] . $conf['rmb_name'];}?></td>

                <td data-label="<?php echo lang('score_new'); ?>"><?php echo $val['num']; ?> <?php if ($val['exp_type'] == '1') {echo $conf['exp_unit'] . $conf['exp_name'];} elseif ($val['exp_type'] == '2') {echo $conf['gold_unit'] . $conf['gold_name'];} else {echo $conf['rmb_unit'] . $conf['rmb_name'];}?></td>
                <td data-label="<?php echo lang('score_msg'); ?>"><?php echo $val['message']; ?></td>
              </tr>
            <?php }?>

            </tbody>
          </table>
          <?php if ($pagination) {?><nav><ul class="pagination justify-content-center flex-wrap"><?php echo $pagination; ?></ul></nav><?php }?>

  </slot>
</template>
<script>$('a[data-active="my-record"]').addClass('active');</script>
<!--{hook my_record_script_after.htm}-->