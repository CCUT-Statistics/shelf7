<?php 
!defined('DEBUG') AND exit('Access Denied.');
$totalnum = fox_rewardlog_count($thread['tid']);
$thread_reward_list = fox_rewardlog_find(array('tid'=>$thread['tid']), array('id'=>1), 1, 10);
?>
<div id="fox_reward"><div id="fox_reward_load">
<?php if(!empty($totalnum)){?>
<div class="reward card-title"><span class="icon_ring vm"></span><b>打赏</b></div>
<div class="table-responsive">
<table class="table">
<tbody>
    <tr>
        <th class="reward x1">参与人数<span class="xi1"><?php echo $totalnum;?></span></th>
        <th class="reward x2">金币<span class="xi1">+<?php echo fox_rewardlog_count_golds($thread['tid']);?></span></th>
        <th class="reward x3">理由</th>
    </tr>
    <?php foreach($thread_reward_list as $v){?>
    <tr>
        <td class="reward"><a href="<?php echo $v['user_url'];?>" class="mr-1"><img class="avatar-2" src="<?php echo $v['avatar_url'];?>"></a><a href="<?php echo $v['user_url'];?>"><?php echo $v['username'];?></a></td>
        <td class="reward xi2"> + <?php echo $v['num'];?></td>
        <td class="reward xi3"><?php echo $v['reason'];?></td>
    </tr>
    <?php }?>
</tbody>
</table>
</div>
<?php if(!empty($user['uid'])){?><p class="ratc"><a href="<?php echo url("thread-rewardlog-{$thread['tid']}-1");?>" target="_blank">查看全部打赏</a></p><?php }?>
<?php }?>
</div></div>