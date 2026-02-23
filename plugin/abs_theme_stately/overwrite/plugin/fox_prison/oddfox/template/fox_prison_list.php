<?php !defined('DEBUG') and exit('Access Denied.');
include _include(APP_PATH . 'view/htm/header.inc.htm'); ?>
<h2>
    小黑屋
</h2>
<section>
    <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?php if ($status) { ?>active<?php } ?>" data-active="prison" href="<?php echo url("prison"); ?>">
                    禁闭名单
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (!$status) { ?>active<?php } ?>" data-active="prison" href="<?php echo url("prison-0"); ?>">
                    释放记录
                </a>
            </li>
        </ul>
        <div class="row lists">
            <?php if (!empty($list)) {
                foreach ($list as $value) { ?>
                    <div class="col-sm-12 col-md-6 col-lg-4 px-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <a href="<?php echo url("user-{$value['uid']}"); ?>" target="_blank"><img class="avatar-4 rounded" src="<?php echo $value['user']['avatar_url']; ?>" /></a>
                                    <div class="media-body ml-3">
                                        <?php if ($gid == 1) {
                                            if ($status) { ?>
                                                <div class="form-check d-inline-block">
                                                    <input type="checkbox" name="moduid" class="form-check-input" value="<?php echo $value['uid']; ?>" id="moduid_<?php echo $value['uid']; ?>" />
                                                    <label class="form-check-label" for="moduid_<?php echo $value['uid']; ?>">
                                                    </label>
                                                </div>
                                        <?php }
                                        } ?>
                                        <a href="<?php echo url("user-{$value['uid']}"); ?>" target="_blank" class="name"><?php echo $value['user']['username']; ?></a>
                                        <div class="brief-box text-info">
                                            禁闭原因：<?php echo strip_tags($value['message']); ?>
                                        </div>
                                        <div class="badge-box small">
                                            <div>禁闭时间：<time><?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_only'], $value['time']); ?></time></div>
                                            <div>释放时间：<time><?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_only'], $value['endtime']); ?></time></div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="empty text-center">
                    <div>
                        <span class="empty-icon badge rounded-pill bg-label-secondary fs-xlarge mb-4">
                            <i class="las la-user fs-1"></i>
                        </span>
                        <p class="m-0">无用户</p>
                    </div>
                </div>
            <?php } ?>
            <aside>
                <?php if (!empty($list)) {
                    if ($gid == 1) {
                        if ($status) { ?>
                            <div class="text-center mb-3">
                                <input type="checkbox" data-target='input[name="moduid"]' class="checkall d-none" aria-label="全选" />
                                <div class="btn-group mod-button" role="group">
                                    <button class="btn btn-secondary" id="checkall">全选</button>
                                    <button class="btn btn-secondary" data-modal-url="<?php echo url("mod-openuser-all"); ?>" data-modal-title="确定释放这些用户？" data-modal-arg=".lists" data-modal-size="md">释放</button>
                                    <button class="btn btn-danger" data-modal-url="<?php echo url("mod-delusers"); ?>" data-modal-title="确定完全删除这些用户？" data-modal-arg=".lists" data-modal-size="md">删除</button>
                                </div>
                            </div>
                <?php }
                    }
                } ?>
            </aside>
            <div class="tab-pane fade show active" role="tabpanel">

            </div>

        </div>
    </div>
    <?php if ($pagination) { ?>
        <nav class="text-center">
            <ul class="pagination justify-content-center mb-0 mx-2">
                <?php echo $pagination; ?>
            </ul>
        </nav>
    <?php } ?>
</section>
<div hidden class="row">
    <div class="col-lg-12" id="main">
        <div class="card mb-0">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a class="nav-link <?php if ($status) { ?>active<?php } ?>" data-active="prison" href="<?php echo url("prison"); ?>"><b>禁闭名单</b></a></li>
                    <li class="nav-item"><a class="nav-link <?php if (!$status) { ?>active<?php } ?>" data-active="prison" href="<?php echo url("prison-0"); ?>"><b>释放记录</b></a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row lists pt-0 px-2">
                    <?php if (!empty($list)) {
                        foreach ($list as $value) { ?>
                            <div class="col-sm-12 col-md-6 col-lg-4 px-2">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="media">
                                            <a href="<?php echo url("user-{$value['uid']}"); ?>" target="_blank"><img class="avatar-4 rounded" src="<?php echo $value['user']['avatar_url']; ?>" /></a>
                                            <div class="media-body ml-3">
                                                <a href="<?php echo url("user-{$value['uid']}"); ?>" target="_blank" class="name"><?php echo $value['user']['username']; ?></a>
                                                <div class="badge-box">
                                                    <div class="text-muted">禁闭时间：<span><?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_only'], $value['time']); ?></span></div>
                                                    <div class="text-muted">释放时间：<span><?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_only'], $value['endtime']); ?></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="brief-box text-muted mt-3">
                                            <?php if ($gid == 1) {
                                                if ($status) { ?><input type="checkbox" name="moduid" class="mr-1" value="<?php echo $value['uid']; ?>" /><?php }
                                                                                                                                                    } ?>
                                            <i class="icon-bell icon-fw"></i> 禁闭原因：<?php echo strip_tags($value['message']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        无
                    <?php } ?>
                </div>
                <?php if (!empty($list)) {
                    if ($gid == 1) {
                        if ($status) { ?>
                            <div class="text-center mb-3">
                                <input type="checkbox" data-target='input[name="moduid"]' class="checkall d-none" aria-label="全选" />
                                <div class="btn-group mod-button" role="group">
                                    <button class="btn btn-secondary" id="checkall">全选</button>
                                    <button class="btn btn-secondary" data-modal-url="<?php echo url("mod-openuser-all"); ?>" data-modal-title="确定释放？" data-modal-arg=".lists" data-modal-size="md">释放</button>
                                    <button class="btn btn-secondary" data-modal-url="<?php echo url("mod-delusers"); ?>" data-modal-title="确定枪毙？" data-modal-arg=".lists" data-modal-size="md">枪毙</button>
                                </div>
                            </div>
                <?php }
                    }
                } ?>
                <?php if ($pagination) { ?><nav class="text-center">
                        <ul class="pagination justify-content-center mb-0 mx-2"><?php echo $pagination; ?></ul>
                    </nav><?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include _include(APP_PATH . 'view/htm/footer.inc.htm'); ?>
<script>
    $('#checkall').click(function() {
        $("input[type='checkbox']").trigger("click");
    });
</script>