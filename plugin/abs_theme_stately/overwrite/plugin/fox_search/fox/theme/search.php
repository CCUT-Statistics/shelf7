<?php !defined('DEBUG') and exit('Access Denied.');
include _include(APP_PATH . 'view/htm/header.inc.htm'); ?>

<!--{hook search_start.htm}-->

<section class="card col-12 col-md-8 col-lg-6 mx-auto mt-0 mb-3">
	<div class="card-body">
		<div class="d-flex align-items-center  justify-content-center  text-center mb-3">
			<!--{hook stately_navlogo_side.htm}-->

			<span class="lead mx-3"><?= lang('search') ?></span>
		</div>

		<form action="<?php echo url('search'); ?>" id="fox_search_form">

			<div class="input-group mb-3">
				<input type="text" class="form-control" placeholder="<?php echo lang('keyword'); ?>" name="keyword" value="<?php echo $keyword_decode; ?>">
				<div class="input-group-append">
					<button class="btn btn-primary" type="submit" id="submit"><?php echo lang('search'); ?></button>
				</div>
			</div>
			<?php if ($search_type == 'like' || $search_type == 'fulltext') { ?>
				<div class="text-center">
					<label>搜索范围：</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="range" id="range_0" value="0" <?php echo $range == '0' ? 'checked' : ''; ?>>
						<label class="form-check-label" for="range_0">内容</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="range" id="range_1" value="1" <?php echo $range == '1' ? 'checked' : ''; ?>>
						<label class="form-check-label" for="range_1">标题</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="range" id="range_2" value="2" <?php echo $range == '2' ? 'checked' : ''; ?>>
						<label class="form-check-label" for="range_2">用户</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" value="1" name="exact" id="exact_checkbox" <?php echo $exact == '1' ? 'checked' : ''; ?>>
						<label class="form-check-label" for="exact_checkbox">
							精确搜索
						</label>
					</div>
				</div>
			<?php } ?>
		</form>
	</div>
</section>


<?php if ($keyword) : ?>
	<?php switch ($range):
		case 1: ?>
			<?php if ($threadlist) : ?>

				<!--{hook stately_threadlist_before.htm}-->
				<div class="<?= $stately_threadlist_class_add ?>">
					<ul class="list-unstyled threadlist row g-0 mb-0" data-style="<?= $stately_threadlist_style ?>">
						<!--{hook search_threadlist_before.htm}-->
						<?php include _include(APP_PATH . 'view/htm/thread_list.inc.htm'); ?>
						<!--{hook search_threadlist_after.htm}-->
					</ul>
				</div>

				<?php include _include(APP_PATH . 'view/htm/thread_list_mod.inc.htm'); ?>

			<?php else : ?>

				<div class="card card-body">
					<div class="card-body">
						<div class="empty p-3 text-center">
							<span class="empty-icon badge rounded-pill bg-label-secondary fs-xlarge mb-4">
								<i class="la la-search fs-1"></i>
							</span>
							<p> 无结果 </p>
						</div>
					</div>

				<?php endif; ?>


				<!--{hook search_page_before.htm}-->
				<?php if ($pagination) { ?>
					<nav>
						<ul class="pagination justify-content-center"><?php echo $pagination; ?></ul>
					</nav>
				<?php } ?>
				<!--{hook search_page_end.htm}-->

			<?php break;
		case 0:
		case 9: ?>

				<div class="card">
					<div class="card-body">
						<ul class="list-unstyled postlist">
							<!--{hook search_postlist_before.htm}-->
							<?php include _include(APP_PATH . 'view/htm/post_list.inc.htm'); ?>
							<!--{hook search_postlist_before.htm}-->
						</ul>
					</div>
				</div>

				<!--{hook search_page_before.htm}-->
				<?php if ($pagination) { ?>
					<nav>
						<ul class="pagination justify-content-center"><?php echo $pagination; ?></ul>
					</nav>
				<?php } ?>
				<!--{hook search_page_end.htm}-->

			<?php
		case 2: ?>

				<div class="row">
					<?php foreach ($userlist as $users) : ?>
						<li class="d-block col-sm-6 col-md-4 col-lg-3" data-uid="<?= $users['uid']; ?>">
							<div class="card mb-4">
								<div class="user-profile-header-banner rounded-top h-px-100">
								</div>
								<div class="user-profile-header d-flex flex-column text-center mb-4">
									<div class="flex-shrink-0 mt-n2 mx-auto">
										<div class="v_avatar v_avatar-user">
											<a href="<?= url('user-' . $users['uid']); ?>">
												<img loading="lazy" decoding="async" src="<?= $users['avatar_url']; ?>" alt="user image" class="d-block h-auto ms-0  rounded user-profile-img w-px-75">
											</a>
										</div>
									</div>
									<div class="flex-grow-1 mt-3 ">
										<div class="d-flex flex-column align-items-center justify-content-center gap-4">
											<div class="user-profile-info">
												<h4>
													<a href="<?= url('user-' . $users['uid']); ?>">
														<?= $users['username']; ?>
													</a>
												</h4>
												<ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-center gap-2">
													<li>
														<span class="d-block text-muted">
															<?= lang('threads') ?>
														</span>
														<span>
															<?= $users['threads'] ?>
														</span>
													</li>
													<li>
														<span class="d-block text-muted">
															<?= lang('posts') ?>
														</span>
														<span>
															<?= $users['posts'] ?>
														</span>
													</li>
												</ul>

											</div>
										</div>
									</div>
								</div>
							</div>
						</li>
					<?php endforeach ?>
				</div>

				<!--{hook search_page_before.htm}-->
				<?php if ($pagination) { ?>
					<nav>
						<ul class="pagination justify-content-center"><?php echo $pagination; ?></ul>
					</nav>
				<?php } ?>
				<!--{hook search_page_end.htm}-->

			<?php break;
		default: ?>
		<?php break;
	endswitch; ?>
	<?php else : ?>
		<div class="card col-12 col-md-8 col-lg-6 mx-auto mt-0 mb-3">
			<div class="pt-3">
				<!--{hook stately_fox_search_after_searchbar.htm}-->
			</div>
		</div>
	<?php endif; ?>

	<!--{hook search_end.htm}-->

	<?php include _include(APP_PATH . 'view/htm/footer.inc.htm'); ?>

	<script>
		var jform = $('#form');
		var jsubmit = $('#submit');
		var jrange = jform.find('input[name="range"]');
		var jexact = jform.find('input[name="exact"]');
		var jkeyword = jform.find('input[name="keyword"]');
		jform.on('submit', function() {
			var range = jrange.checked();
			var exact = jexact.checked();
			if (exact == '') {
				var exact = '0';
			}
			var keyword = jkeyword.val();
			window.location = xn.url('search-' + xn.urlencode(keyword) + '-' + range + '-' + exact);
			return false;
		});
		$('#nav_pc li[fid="<?php echo $fid; ?>"]').addClass('active');
	</script>

	<!--{hook search_js.htm}-->