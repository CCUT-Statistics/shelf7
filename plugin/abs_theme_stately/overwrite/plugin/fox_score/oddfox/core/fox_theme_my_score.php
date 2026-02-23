<?php !defined('DEBUG') and exit('Access Denied.'); ?>
<template include="./plugin/abs_theme_stately/overwrite/plugin/fox_score/oddfox/core/fox_theme_my_score.template.php">
	<slot name="my_body">

		<?php
		$progress = 100;
		if ($user['gid'] > 100) {
			$progress = (int)($now / $max * 100.0);
		}
		?>
		<div class="row">
			<div class="col-lg-6">
				<h2>我的积分</h2>
				<div class="row my-2">
					<div class="col-6">
						<div class="card bg-label-warning bg-gradient">
							<div class="card-body">
								<span class="fs-1 float-end"><i class="la la-coins"></i></span>
								<p class="fs-5 mb-1"><?= $credits2_name; ?></p>
								<p><data class="fs-3"><?= $user['golds'] . $conf['gold_unit'] ?></data></p>
								<p class="m-0">
									<a href="<?php echo url('my-exchange') ?>" class="btn btn-outline-warning "><?php echo lang('score_exchange'); ?></a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="card bg-label-info bg-gradient">
							<div class="card-body">
								<span class="fs-1 float-end"><i class="la la-money-bill-alt"></i></span>
								<p class="fs-5 mb-1"><?= $credits3_name; ?></p>
								<p><data class="fs-3"><?= $user['rmbs'] . $conf['rmb_unit'] ?></data></p>
								<a href="<?php echo url('my-withdrawal') ?>" class="btn btn-outline-info"><?php echo lang('my_withdrawal'); ?></a>
								<!--{hook fox_score_user_pay.htm}-->
							</div>
						</div>
					</div>
					<div class="col-md-12 order-first order-lg-last ">
						<div class="card bg-label-primary bg-gradient">
							<div class="card-body">
								<span class="fs-3 float-end"><?php echo $progress . '%'; ?></span>
								<p class="fs-3"><?= $user['groupname']; ?></p>
								<p><i class="la la-flask" aria-hidden="true"></i> <?= $credits1_name; ?>：<data><?= $user['credits']; ?></data></p>

								<div class="d-flex align-items-center">
									<div class="progress flex-grow-1 ml-1">
										<div class="progress-bar" role="progressbar" style="width: <?= $progress; ?>%" aria-valuenow="<?= $progress; ?>" aria-valuemin="0" aria-valuemax="100"> </div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 order-last">
						<?php if ($conf['vip_on'] == 1) : ?>
							<div class="card card-body border-warning">
								<?php if (vip_isvip($uid)) {
									$vip_info = vip_read($uid);
									$progress = 100;
									$now = $vip_info['grow'];
									$max = vip_get_maxgrow($now);
									$progress = (int) ($now / $max * 100.0);
									$btn_txt = '立即续费';
								} else {
									$vip_info = array(
										'level' => 0,
										'grow' => 0,
										'not_have_vip' => true
									);
									$progress = 0;
									$btn_txt = '立即开通';
								}
								?>

								<?php if (vip_isvip($uid)) : ?>
									<div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
										<span class="fs-3 text-warning my-2">VIP Lv.
											<?php echo $vip_info['level']; ?>
										</span>
										<button type="button" class="btn btn-warning" data-modal-url="<?php echo url('my-vip_open'); ?>" data-modal-title="开通VIP" data-modal-size="lg">
											<?php echo $btn_txt; ?>
										</button>
									</div>

									<div class="progress flex-grow-1">
										<div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
											<?php echo ($progress . '%'); ?>
										</div>
									</div>


									<div class="row mt-3 mb-0">
										<div class="col-6">
											<h5 class="h6 mb-2">到期时间：</h5>
											<p class="lead mb-0">
												<data>
													<?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_only'], $user['vip_end']); ?>
												</data>
											</p>
										</div>
										<div class="col-6">
											<h5 class="h6 mb-2">成长值 / 升级成长值：</h5>
											<p class="lead mb-0">
												<data>
													<?php echo $vip_info['grow'] . ' / ' . $max; ?>
												</data>
											</p>
										</div>
									<?php else : ?>
										<p class="fs-3 text-warning mb-2">
											开通VIP即可尽享如下特权：
										</p>
										<p>专属彩色名称、增加帖子曝光、无条件查看加密内容！</p>
										<button type="button" class="btn btn-warning" data-modal-url="<?php echo url('my-vip_open'); ?>" data-modal-title="开通VIP" data-modal-size="lg">
											<?php echo $btn_txt; ?>
										</button>

									<?php endif; ?>

									</div>

							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<h4><?php echo lang('score_rule'); ?></h4>
				<p class="lead">每日可获得<?php echo $conf['exp_name'] . $day_exp_total . $conf['exp_unit']; ?>，<?php echo $conf['gold_name'] . $day_gold_total . $conf['gold_unit']; ?>。</p>
				<ol class="list-unstyled row">
					<li class="col-md-6 col-lg-4">
						<div class="card p-2">
							<h5 class="text-success"><?php echo lang('score_sign'); ?></h5>
							<ul class="list-unstyled">
								<li>
									<i class="text-primary la la-flask"></i>
									<?php if ($conf['exp_sign_give']) {
										echo $conf['exp_name'] . " +" . $conf['exp_sign_give'] . " " . $conf['exp_unit'] . lang('score_left') . '1' . lang('score_right');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-warning la la-coins"></i>
									<?php if ($conf['gold_sign_give']) {
										echo $conf['gold_name'] . " +" . $conf['gold_sign_give'] . " " . $conf['gold_unit'] . lang('score_left') . '1' . lang('score_right');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-info la la-money-bill-alt"></i>
									<?php if ($conf['rmb_sign_give']) {
										echo $conf['rmb_name'] . " +" . $conf['rmb_sign_give'] . " " . $conf['rmb_unit'] . lang('score_left') . '1' . lang('score_right');
									} else {
										echo "-----";
									} ?>
								</li>
							</ul>
						</div>
					</li>
					<li class="col-md-6 col-lg-4">
						<div class="card p-2">
							<h5 class="text-success"><?php echo lang('score_digest1'); ?></h5>
							<ul class="list-unstyled">
								<li>
									<i class="text-primary la la-flask"></i>
									<?php if ($conf['exp_digest_num1']) {
										echo $conf['exp_name'] . " +" . $conf['exp_digest_num1'] . " " . $conf['exp_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-warning la la-coins"></i>
									<?php if ($conf['gold_digest_num1']) {
										echo $conf['gold_name'] . " +" . $conf['gold_digest_num1'] . " " . $conf['gold_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-info la la-money-bill-alt"></i>
									<?php if ($conf['rmb_digest_num1']) {
										echo $conf['rmb_name'] . " +" . $conf['rmb_digest_num1'] . " " . $conf['rmb_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
							</ul>
						</div>
					</li>
					<li class="col-md-6 col-lg-4">
						<div class="card p-2">
							<h5 class="text-success"><?php echo lang('score_digest2'); ?></h5>
							<ul class="list-unstyled">
								<li>
									<i class="text-primary la la-flask"></i>
									<?php if ($conf['exp_digest_num2']) {
										echo $conf['exp_name'] . " +" . $conf['exp_digest_num2'] . " " . $conf['exp_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-warning la la-coins"></i>
									<?php if ($conf['gold_digest_num2']) {
										echo $conf['gold_name'] . " +" . $conf['gold_digest_num2'] . " " . $conf['gold_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-info la la-money-bill-alt"></i>
									<?php if ($conf['rmb_digest_num2']) {
										echo $conf['rmb_name'] . " +" . $conf['rmb_digest_num2'] . " " . $conf['rmb_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
							</ul>
						</div>
					</li>
					<li class="col-md-6 col-lg-4">
						<div class="card p-2">
							<h5 class="text-success"><?php echo lang('score_digest3'); ?></h5>
							<ul class="list-unstyled">
								<li>
									<i class="text-primary la la-flask"></i>
									<?php if ($conf['exp_digest_num3']) {
										echo $conf['exp_name'] . " +" . $conf['exp_digest_num3'] . " " . $conf['exp_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-warning la la-coins"></i>
									<?php if ($conf['gold_digest_num3']) {
										echo $conf['gold_name'] . " +" . $conf['gold_digest_num3'] . " " . $conf['gold_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-info la la-money-bill-alt"></i>
									<?php if ($conf['rmb_digest_num3']) {
										echo $conf['rmb_name'] . " +" . $conf['rmb_digest_num3'] . " " . $conf['rmb_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
							</ul>
						</div>
					</li>
					<li class="col-md-6 col-lg-4">
						<div class="card p-2">
							<h5 class="text-danger"><?php echo lang('score_attach'); ?></h5>
							<ul class="list-unstyled">
								<li>
									<i class="text-primary la la-flask"></i>
									<?php if ($conf['exp_attach_num']) {
										echo $conf['exp_name'] . " -" . $conf['exp_attach_num'] . " " . $conf['exp_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-warning la la-coins"></i>
									<?php if ($conf['gold_attach_num']) {
										echo $conf['gold_name'] . " -" . $conf['gold_attach_num'] . " " . $conf['gold_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-info la la-money-bill-alt"></i>
									<?php if ($conf['rmb_attach_num']) {
										echo $conf['rmb_name'] . " -" . $conf['rmb_attach_num'] . " " . $conf['rmb_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
							</ul>
						</div>
					</li>
					<li class="col-md-6 col-lg-4">
						<div class="card p-2">
							<h5 class="text-danger"><?php echo lang('score_editname'); ?></h5>
							<ul class="list-unstyled">
								<li>
									<i class="text-primary la la-flask"></i>
									<?php if ($conf['exp_editname_num']) {
										echo $conf['exp_name'] . " -" . $conf['exp_editname_num'] . " " . $conf['exp_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-warning la la-coins"></i>
									<?php if ($conf['gold_editname_num']) {
										echo $conf['gold_name'] . " -" . $conf['gold_editname_num'] . " " . $conf['gold_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
								<li>
									<i class="text-info la la-money-bill-alt"></i>
									<?php if ($conf['rmb_editname_num']) {
										echo $conf['rmb_name'] . " -" . $conf['rmb_editname_num'] . " " . $conf['rmb_unit'] . lang('score_num_no');
									} else {
										echo "-----";
									} ?>
								</li>
							</ul>
						</div>
					</li>
				</ol>
				<h4>各版块发布主题与回帖奖励，及交易分成
				</h4>
				<p><strong class="text-danger">特别提示:</strong>主题与回帖<b>正向奖励有次数限制</b>！删除内容后将<b>扣除奖励</b>，但奖励次数不返还！负向无次数限制，且<b>删除内容不返还积分</b>！</p>
				<section class="table-responsive">
					<table class="table ">
						<?php $ForumScoreList = ForumScoreFind(); ?>
						<thead>
							<tr>
								<th>版块名称</th>
								<th>发帖所得</th>
								<th>回帖所得</th>
								<th>交易服务费</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($ForumScoreList as $key => $F) { ?>
								<tr>
									<td class="text-success"><?php echo $F['name']; ?></td>
									<td>
										<ul class="list-unstyled">
											<li>
												<i class="text-primary la la-flask"></i>
												<?php echo FoxForumScoreFmt($F['credits_t_get'], '{exp1}'); ?>
											</li>
											<li>
												<i class="text-warning la la-coins"></i>
												<?php echo FoxForumScoreFmt($F['golds_t_get'], '{exp2}'); ?>
											</li>
											<li>
												<i class="text-info la la-money-bill-alt"></i>
												<?php echo FoxForumScoreFmt($F['rmbs_t_get'], '{exp3}'); ?>
											</li>
										</ul>
									</td>
									<td>
										<ul class="list-unstyled">
											<li>
												<i class="text-primary la la-flask"></i>
												<?php echo FoxForumScoreFmt($F['credits_p_get'], '{exp1}'); ?>
											</li>
											<li>
												<i class="text-warning la la-coins"></i>
												<?php echo FoxForumScoreFmt($F['golds_p_get'], '{exp2}'); ?>
											</li>
											<li>
												<i class="text-info la la-money-bill-alt"></i>
												<?php echo FoxForumScoreFmt($F['rmbs_p_get'], '{exp3}'); ?>
											</li>
										</ul>
									</td>
									<td>
										<?php
										if ($F['t_divide'] > 0 && $F['t_divide'] <= 10) {
											echo 10 * (10 - $F['t_divide']) . '%';
										} else {
											echo '----';
										}
										?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</section>
			</div>
		</div>
	</slot>
</template>
<script>
	$('a[data-active="my-score"]').addClass('active');
</script>
<!--{hook my_score_script_after.htm}-->