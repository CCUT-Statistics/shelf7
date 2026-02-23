<?php !defined('DEBUG') AND exit('Access Denied.'); include _include(APP_PATH.'view/htm/header.inc.htm');?>        
<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
        	<div class="card-header">打赏记录 - <?php echo $thread['subject'];?></div>
            <div class="card-body" >
                <div class="mb-2">作者：<a href="<?php echo url("user-$thread[uid]");?>"><img class="avatar-1 mr-2" src="<?php echo $thread['user_avatar_url'];?>" style="vertical-align:top"><?php echo $thread['username'];?></a></div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text">打赏人数</span></div>
                    <div class="custom-input form-control"><?php echo $totalnum;?></div>
                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <table class="table border-bottom">
                    <tr>
                        <th style="width:25%;">时间</th>
                        <th style="width:30%;">用户</th>
                        <th style="width:15%;">金币</th>
                        <th style="width:35%;">理由</th>
                    </tr>
                    <?php foreach($thread_reward_list as $v){?>
                    <tr>
                     <td><?php echo date('Y-m-d H:i:s',$v['time']);?></td>
                      <td>
                      <a href="<?php echo $v['user_url'];?>" class="mr-2"><img class="avatar-1" src="<?php echo $v['avatar_url'];?>"></a>
                      <a href="<?php echo $v['user_url'];?>"><?php echo $v['username'];?></a>
                      </td>
                      <td> + <?php echo $v['num'];?></td>
                      <td><?php echo $v['reason'];?></td>
                    </tr>
                    <?php }?>
                    </table>                    
                    <?php if( !empty($pagination) ){?><nav class="text-center"><ul class="pagination justify-content-center flex-wrap mb-0"><?php echo $pagination;?></ul></nav><?php }?>
            </div>
        </div>
    </div>
</div>
<?php include _include(APP_PATH.'view/htm/footer.inc.htm');?>