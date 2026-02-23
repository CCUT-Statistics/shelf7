<template include="./plugin/abs_theme_stately/overwrite/plugin/fox_tags/oddfox/template/my_tags.template.htm">
    <slot name="my_body">
        <?php if ($list) { ?>
        <ul class="row list-unstyled">
            <?php foreach ($list as $k => $_tag) { ?>
            <li class="d-block col-sm-6 col-md-4 col-lg-3 " id="follow_<?= $_tag['tagid']; ?>">
                <div class="card card-body mb-4">
                    <div class="flex-shrink-0 mx-auto">
                        <a href="<?= url('tag-'.$_tag['tagid']); ?>">
                            <img loading="lazy" decoding="async" src="<?= $_tag['cover']; ?>" alt="user image" class="d-block h-auto ms-0  rounded user-profile-img w-px-75">
                        </a>
                    </div>
                    <div class="flex-grow-1 mt-3 ">
                        <div class="d-flex flex-column align-items-center justify-content-center gap-4 text-center">
                            <div class="user-profile-info">
                                <h4>
                                    <a href="<?= url('tag-'.$_tag['tagid']); ?>">
                                        <?= $_tag['name']; ?>
                                    </a>
                                </h4>
                                <div>
                                    <a role="button" href="javascript:;" onclick="follow_tag('<?= $_tag['tagid']; ?>');" class="btn btn-secondary">取消关注</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
        <?php if ($pagination) { ?>
        <nav class="my-3">
            <ul class="pagination justify-content-center flex-wrap">
                <?= $pagination; ?>
            </ul>
        </nav>
        <?php } ?>
        <?php } else { ?>
        <div class="empty card-body text-center">
            <div>
                <span class="empty-icon badge rounded-pill bg-label-secondary fs-xlarge mb-4">
                    <i class="las la-tag fs-1"></i>
                </span>
                <p class="m-0">
                    <?= lang('none');?>
                </p>
            </div>
        </div>
        <?php } /* endif */ ?>
    </slot>
</template>
<script>
    $('a[data-active="my"]').addClass('active');
    $('a[data-active="my-tags"]').addClass('active');

    function follow_tag(tagid) {
        $.xpost(xn.url('tag-follow'), {
            'tagid': tagid
        }, function (code, message) {
            if (code == 1) {
                $('#follow_' + tagid).remove();
            } else {
                $.alert(message);
            }
        });
        return false;
    }
</script>