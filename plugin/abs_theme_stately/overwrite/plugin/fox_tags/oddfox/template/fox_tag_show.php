<?php !defined('DEBUG') and exit('Access Denied.');
$this_tag_cover_url = !empty($query['cover']) ? $query['cover'] : 'plugin/fox_tags/oddfox/static/img/cover.png';
$this_tag_brief = !empty($query['brief']) ? $query['brief'] : $tagname . '圈子欢迎你~发布内容并打上"' . $tagname . '"标签就能出现在圈子里哦~';
include _include(APP_PATH . 'view/htm/header.inc.htm'); ?>
<!---->
<!--{hook stately_hero_fox_tags_show.htm}-->
<?php
switch ($abs_theme_stately_setting['ui_style']['forum']['layout']) {
    case 'classic_1col': ?>
<!--{hook stately_layout_fox_tags__show_1col.htm}-->
<?php break;
    default: ?>
<!--{hook stately_layout_fox_tags__show_2col.htm}-->
<?php break;
} /* end switch */ ?>
<?php include _include(APP_PATH . 'view/htm/footer.inc.htm'); ?>
<script>
    $('li[data-active="index"]').addClass('active');
    $('li[data-active="fid-0"]').addClass('active');
    $('a[data-active="index"]').addClass('active');

    function follow_tag(tagid) {
        $.xpost(xn.url('tag-follow'), {
            'tagid': tagid
        }, function (code, message) {
            if (code == 0) {
                $('.follow_tag .btn').removeClass('btn-primary').addClass('btn-secondary').text('已关注');
            } else if (code == 1) {
                $('.follow_tag .btn').removeClass('btn-secondary').addClass('btn-primary').text('关注标签');
            } else {
                $.alert(message);
            }
        });
        return false;
    }
</script>