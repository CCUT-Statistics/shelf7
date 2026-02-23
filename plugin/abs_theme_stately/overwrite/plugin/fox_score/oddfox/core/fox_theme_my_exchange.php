<?php !defined('DEBUG') and exit('Access Denied.');?>
<template include="./plugin/abs_theme_stately/overwrite/plugin/fox_score/oddfox/core/fox_theme_my_score.template.php">
<slot name="my_body">
	<?php $col_width = 'col-md-12';if (!empty($conf['exchange']) && !empty($conf['disexchange'])) {$col_width = 'col-md-6';}?>
		<div class="row">
			<?php if (!empty($conf['exchange'])) {?>
				<div class="<?php echo $col_width; ?>">
					<div class="card">
						<div class="card-header">
							<h5 class="text-info mb-0"><?php echo $conf['rmb_name'] . lang('score_exchange') . $conf['gold_name']; ?>(<?php echo lang('score_exchange_min_num'); ?><span class="text-info"><?php echo $conf['exchange_min_money'] * $conf['exchange_r2g_ratio'] . $conf['gold_unit']; ?></span><?php echo $conf['gold_name']; ?>)</h5>
						</div>
						<form role="gform" action="<?php echo url('my-exchange-r2g'); ?>" method="post" id="gform" class="card-body">
							<div class="input-group mb-3">
								<div class="input-group-prepend"><span class="input-group-text"><?php echo lang('score_exchange') . lang('score_exchange_ratio_m'); ?></span></div>
								<div class="custom-input form-control">
									<span class="text-info"><?php echo '1' . $conf['rmb_unit'] . $conf['rmb_name']; ?></span> <?php echo lang('score_exchange'); ?>
									<span class="text-info"><?php echo $conf['exchange_r2g_ratio'] . $conf['gold_unit'] . $conf['gold_name']; ?></span>。
								</div>
							</div>

							<div class="form-group input-group" id="content_num_input">
								<div class="input-group-prepend"><span class="input-group-text"><?php echo $conf['gold_name'] . lang('score_exchange_golds'); ?></span></div>
								<input type="number" min="<?= $conf['exchange_min_money'] * $conf['exchange_r2g_ratio'] ?>" name="golds_num" id="golds_num" maxlength="5" required="" onblur="r2g(this.value,<?php echo $conf['exchange_min_money'] * $conf['exchange_r2g_ratio']; ?>);" class="form-control" />
							</div>

							<div class="input-group mb-3">
								<div class="custom-input form-control">
									<i class="icon icon-bell icon-fw"></i>
									<?php echo lang('score_exchange'); ?> <span style="color:red;" id="fox_g_tips">0</span> <?php echo $conf['gold_unit'] . $conf['gold_name']; ?>，需要扣除 <span style="color:red;" id="fox_g_tips2">0</span> <?php echo $conf['rmb_unit'] . $conf['rmb_name']; ?>
								</div>
							</div>
							<button type="submit" id="gsubmit" class="btn btn-primary btn-block"><?php echo lang('confirm') . lang('score_exchange'); ?></button>
						</form>
					</div>
				</div>
				<?php }?>
				<?php if (!empty($conf['disexchange'])) {?>

				<div class="<?php echo $col_width; ?>">
					<div class="card">
						<div class="card-header">
							<h5 class="text-info mb-0"><?php echo $conf['gold_name'] . lang('score_exchange') . $conf['rmb_name']; ?>(<?php echo lang('score_exchange_min_num'); ?><span class="text-info"><?php echo $conf['exchange_min_money'] . $conf['rmb_unit']; ?></span><?php echo $conf['rmb_name']; ?>)</h5>
						</div>
						<form role="rform" action="<?php echo url('my-exchange-g2r'); ?>" method="post" id="rform" class="card-body">
							<div class="input-group mb-3">
								<div class="input-group-prepend"><span class="input-group-text"><?php echo lang('score_exchange') . lang('score_exchange_ratio_m'); ?></span></div>
								<div class="custom-input form-control">
									<span class="text-info"><?php echo $conf['exchange_g2r_ratio'] . $conf['gold_unit'] . $conf['gold_name']; ?></span>
									<?php echo lang('score_exchange'); ?>
									<span class="text-info"><?php echo '1' . $conf['rmb_unit'] . $conf['rmb_name']; ?></span>。
								</div>
							</div>

							<div class="form-group">
								<div class="form-group input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><?php echo lang('score_exchange') . lang('score_exchange_rmbs'); ?></span>
									</div>
									<input type="number" min="<?= $conf['exchange_min_money'] ?>" name="rmb_num" id="rmb_num" maxlength="5" required="" onblur="g2r(this.value,<?php echo $conf['exchange_min_money']; ?>);" class="form-control" />
								</div>
							</div>

							<div class="input-group mb-3">
								<div class="custom-input form-control">
									<i class="icon icon-bell icon-fw"></i>
									<?php echo lang('score_exchange'); ?> <span style="color:red;" id="fox_r_tips">0</span> <?php echo $conf['rmb_unit'] . $conf['rmb_name']; ?>，需要扣除 <span style="color:red;" id="fox_r_tips2">0</span> <?php echo $conf['gold_unit'] . $conf['gold_name']; ?>
								</div>
							</div>
							<button type="submit" id="rsubmit" class="btn btn-primary btn-block"><?php echo lang('confirm') . lang('score_exchange'); ?></button>
						</form>
					</div>
				</div>
				<?php }?>

			</div>
</slot>
</template>
<?php if (!empty($conf['exchange'])) {?>
<script>var d_g_n = "<?php echo $conf['exchange_min_money'] * $conf['exchange_r2g_ratio']; ?>";var d_g_r = "<?php echo $conf['exchange_r2g_ratio']; ?>";</script>
<script src="plugin/fox_score/oddfox/static/js/fox_exchange.js"></script>
<?php }?>
<?php if (!empty($conf['disexchange'])) {?>
<script>var d_r_n = <?php echo $conf['exchange_min_money']; ?>;var d_r_r = "<?php echo $conf['exchange_g2r_ratio']; ?>";</script>
<script src="plugin/fox_score/oddfox/static/js/fox_disexchange.js"></script>
<?php }?>
<script>$('a[data-active="my-exchange"]').addClass('active');</script>