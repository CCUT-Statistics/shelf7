<?php include _include(ADMIN_PATH.'view/htm/header.inc.htm');?>
<?php
$arrlist = db_find('ws_thread_pay');
$num =array();
foreach ($arrlist as $v)
{	
	$num[] =  $v['tid'] ;
}
	
$num_pid = count($num);

	$page = param(1,1);
	$date =  db_find('ws_thread_pay',array('type'=>1), array('paytime'=>-1), $page, $pagesize = 20);	
	$pagination = pagination(url("part_log-{page}"), $num_pid, $page, $pagesize);
		
function subject($tid)
{
	$r = db_find_one('thread',array("tid"=>$tid));
	return $r['subject'];
}
function username($uid)
{
	$r = db_find_one('user',array("uid"=>$uid));
	return $r['username'];
}
?>
<div class="col-lg-12">
<div class="card">
<div class="card-header">
				<ul class="nav nav-tabs card-header-tabs">
					<li class="nav-item">
						<a class="nav-link active" href="">消费记录总汇</a>
					</li>
					
				</ul>
			</div>
	<Div class="card-body">
		<ul class="list-unstyled threadlist mb-0">
		<?php foreach($date as $v){?>
				<li class="media thread tap" >
					主题：<a href="/<?php echo url("thread-$v[tid]")?>" style="color: blue"><?php echo subject($v['tid'])?></a>&nbsp;&nbsp;|&nbsp;&nbsp;用户:<a href="/<?php echo url("user-$v[uid]")?>" ><?php echo username($v['uid'])?></a>&nbsp;&nbsp;|&nbsp;&nbsp;金额：<b style="color: red"><?php echo $v['coin'];?></b>&nbsp;&nbsp;|&nbsp;&nbsp;时间：<?php echo date('Y-m-d',$v['paytime']); ?>&nbsp;&nbsp;|&nbsp;&nbsp;状态：<?php if($v['type']==1){?><b style="color: green">成功</b><?php }else{?><b style="color: red">失败</b><?php }?>
				</li>
		<?php }?>
		</ul>
	</Div>
</div>	
<nav class="text-center"><ul class="pagination"><?php echo $pagination; ?></ul></nav>
</div>



<?php include _include(ADMIN_PATH.'view/htm/footer.inc.htm');?>



