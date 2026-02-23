<?php !defined('DEBUG') and exit('Access Denied.');
include _include(APP_PATH . 'view/htm/header.inc.htm'); ?>
<div class="row ajax-body">
    <div class="col-12">
        <h4 class="py-3 mb-4">
            <span class="text-muted">
                <a href="<?= url('thread-' . $tid); ?>" title="返回主题第一页">
                    <i class="la la-arrow-circle-left" data-bs-toggle="tooltip" title="<?= lang('back') ?>"></i>
                    <?= $thread['subject']; ?>
                </a> &mdash; </span>
            打赏记录
        </h4>
        <div class="row">
        <div class="col-12 col-md-6">
                <div class="card card-body mb-3">
                    <div class="clearfix">
                        <span class="mb-1">打赏人数</span>
                    </div>
                    <div class="fs-3">
                        <?php echo $totalnum; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card card-body mb-3">
                    <div class="clearfix">
                        <span class="mb-1">发布者</span>
                    </div>
                    <div class="fs-3">
                        <a href="<?php echo url('user-' . $thread['uid']); ?>" class="mr-3" tabindex="-1"><img class="w-px-30" src="<?php echo $thread['user']['avatar_url']; ?>">&nbsp;
                            <?php echo $thread['user']['username']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <tr>
                        <th style="width:25%;">时间</th>
                        <th style="width:30%;">用户</th>
                        <th style="width:15%;">金币</th>
                        <th style="width:35%;">理由</th>
                    </tr>
                    <?php foreach ($thread_reward_list as $v) { ?>
                        <tr>
                            <td><?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_and_time'], $v['time']); ?></td>
                            <td>
                                <a href="<?php echo $v['user_url']; ?>" class="mr-2"><img class="avatar-1" src="<?php echo $v['avatar_url']; ?>"></a>
                                <a href="<?php echo $v['user_url']; ?>"><?php echo $v['username']; ?></a>
                            </td>
                            <td> + <?php echo $v['num']; ?></td>
                            <td><?php echo $v['reason']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <?php if (!empty($pagination)) { ?>
            <nav class="text-center">
                <ul class="pagination justify-content-center flex-wrap mb-0"><?php echo $pagination; ?></ul>
            </nav>
        <?php } ?>

    </div>
</div>
<?php include _include(APP_PATH . 'view/htm/footer.inc.htm'); ?>