<?php !defined('DEBUG') and exit('Access Denied.');
include _include(APP_PATH . 'view/htm/header.inc.htm'); ?>
<!---->
<h2 class="h3">
    <i class="la la-tags"></i> 标签列表
</h2>
<section class="row tagslist">
    <?php foreach ($fox_tag_list as $val) { if(intval($val['tagid']) == 0){continue;} ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <article class="card card-body mb-3">
                <h3 class="h5">
                    <a class="name" href="<?= url('tag-' . $val['tagid']); ?>">
                        <?= $val['name']; ?>
                    </a>
                    <small class="badge bg-label-primary">
                        <?= $val['num']; ?>
                    </small>
                </h3>
                <footer>
                    <a class="tit" href="<?= url('thread-' . $val['tid']); ?>">
                        <?= $val['subject']; ?>
                    </a>
                </footer>
            </article>
        </div>
    <?php } ?>
</section>
<?php if ($pagination) { ?>
    <nav class="my-0">
        <ul class="pagination justify-content-center flex-wrap">
            <?= $pagination; ?>
        </ul>
    </nav>
<?php } ?>
<?php include _include(APP_PATH . 'view/htm/footer.inc.htm'); ?>
<script>
    $('li[data-active="index"]').addClass('active');
    $('li[data-active="fid-0"]').addClass('active');
    $('a[data-active="index"]').addClass('active');
</script>