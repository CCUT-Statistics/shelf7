<?php
!defined('DEBUG') and exit('Access Denied.');
include _include(APP_PATH . 'view/htm/header.inc.htm');
empty($uid) and message(-1, '请先登录后再查看购买记录!');
$tid = param(2, 0);
$page = param(3, 1);
$_thread = thread_read($tid);
empty($_thread) and message(-1, lang('thread_not_exists'));
thread_format($_thread);
$score_area = '';

$data = db_find('user_foxbuy', array('tid' => $tid, 'state' => 2), array('buytime' => 1), $page, $pagesize = 20);
$list_count = db_count('user_foxbuy', array('tid' => $tid, 'state' => 2));
$pagination = pagination(url("thread-paylog-{$tid}-{page}"), $list_count, $page, $pagesize = 20);
function get_user($uid)
{
    $user = db_find_one('user', array('uid' => $uid));
    return $user;
}

?>
<div class="row">
  <div class="col-lg-12 mx-auto ajax-body">
    <div class="card">
        <div class="card-header"><?php echo $_thread['subject']; ?></div>
        <div class="card-body pb-0">
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text">文章作者</span></div>
                <div class="custom-input form-control"><a href="<?php echo url("user-$_thread[uid]"); ?>" class="mr-3" tabindex="-1"><img class="avatar-1" src="<?php echo $_thread['user']['avatar_url']; ?>">&nbsp;<?php echo $_thread['user']['username']; ?></a></div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text">销售数量</span></div>
                <div class="custom-input form-control"><?php echo $list_count; ?></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">销售记录</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>时间</th>
                    <th>用户</th>
                    <th>购买类型</th>
                    <th>销售金额</th>
                </tr>
                <?php foreach ($data as $v) {$__user = get_user($v['uid']);
    user_format($__user);
    if ($v['num_type'] == 1) {
        $score_name = $conf['exp_name'];
        $score_unit = $conf['exp_unit'];
    } elseif ($v['num_type'] == 2) {
        $score_name = $conf['gold_name'];
        $score_unit = $conf['gold_unit'];
    } elseif ($v['num_type'] == 3) {
        $score_name = $conf['rmb_name'];
        $score_unit = $conf['rmb_unit'];
    }
    ?>

                <tr style="<?php echo $v['uid'] == $uid ? 'font-weight:bold;' : ''; ?>">
                    <td><?php echo date($abs_theme_stately_setting['global']['datetime_format']['date_and_time'], $v['buytime']); ?></td>
                    <td><a href="<?php echo url("user-$v[uid]"); ?>" class="mr-3" tabindex="-1"><img class="avatar-1" src="<?php echo $__user['avatar_url']; ?>"></a>&nbsp;<a href="<?php echo url("user-$v[uid]"); ?>" class="mr-3" tabindex="-1"><?php echo $__user['username']; ?></a></td>
                    <td><?php echo lang('msg' . $v['msg_type']) ?></td>
                    <td><?php echo $v['num'] . $score_unit . $score_name ?></td>
                  </tr>
                <?php }?>

            </table><?php if (!empty($pagination)) {?>

            <nav class="text-center"><ul class="pagination"><?php echo $pagination; ?></ul></nav><?php }?>

        </div>
    </div>
  </div>
</div>

<?php include _include(APP_PATH . 'view/htm/footer.inc.htm');?>