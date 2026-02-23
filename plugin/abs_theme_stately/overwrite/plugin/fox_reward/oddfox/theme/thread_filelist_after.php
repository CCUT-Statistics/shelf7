<?php
!defined('DEBUG') and exit('Access Denied.');
$totalnum = fox_rewardlog_count($thread['tid']);
$thread_reward_list = fox_rewardlog_find(array('tid' => $thread['tid']), array('id' => 1), 1, 10);
?>
    <?php if (!empty($totalnum)) { ?>
<div id="fox_reward">
    <div id="fox_reward_load" class="card card-body border-warning">
            <div class="d-flex flex-wrap align-items-center justify-content-between">

                <div class="text-warning fw-bold fs-5"><span class="icon-gift"></span> 打赏</div>
                <?php if (!empty($user['uid'])) { ?>
                <p class="m-0">
                    <a href="<?php echo url("thread-rewardlog-{$thread['tid']}-1"); ?>" class="btn bg-label-warning" target="_blank">查看全部打赏</a>
                </p>
                    <?php } ?>
            </div>
            <div class="table-responsive pt-3">
                <table class="table text-nowrap">
                    <tbody>
                        <tr>
                            <th >参与人数 <span class="badge bg-label-warning"><?php echo $totalnum; ?></span></th>
                            <th >金币 <span class="badge bg-label-warning">+<?php echo fox_rewardlog_count_golds($thread['tid']); ?></span></th>
                            <th >理由 </th>
                        </tr>
                        <?php foreach ($thread_reward_list as $v) { ?>
                            <tr>
                            <td > <a href="<?php echo $v['user_url']; ?>"><img class="img-fluid w-px-20 mr-1" src="<?php echo $v['avatar_url']; ?>"><?php echo $v['username']; ?></a></td>
                                <td > + <?php echo $v['num']; ?></td>
                                <td ><?php echo $v['reason']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>