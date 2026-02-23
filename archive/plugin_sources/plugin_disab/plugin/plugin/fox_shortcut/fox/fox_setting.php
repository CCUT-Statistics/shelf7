<?php !defined('DEBUG') AND exit('Access Denied.');include _include(ADMIN_PATH.'view/htm/header.inc.htm');?>
<style>@media (max-width: 576px){#body > .container > .row.mb-3{ margin-bottom:0px!important;}}.control{background-color:#FFF!important;}</style>
<div class="row mb-3">
  <div class="col-md-8">
    <div class="btn-group">
      <a class="btn btn-secondary" href="<?php echo url("plugin");?>">本地插件</a>
      <a class="btn btn-secondary active" href="<?php echo url("plugin-setting-fox_shortcut");?>">插件设置</a>
      <a class="btn btn-secondary" href="https://bbs.oddfox.cn/xn.htm" target="_blank">插件中心</a>
    </div>
  </div>
  <div class="col-lg-4 text-right hidden-sm">
    <div class="btn-group">
      <a class="btn btn-danger" target="_blank" href="//bbs.oddfox.cn">问题反馈</a>
      <a class="btn btn-dark" href="javascript:void(0);" onclick="javascript:location.reload();"><i class="icon-refresh"></i></a>
      <a class="btn btn-dark" href="<?php echo url("plugin");?>"><i class="icon-times"></i></a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header"><i class="icon-cogs"></i> 奇狐快捷管理插件设置</div>
      <div class="card-body p-0">
      	<div class="alert alert-warning mb-0 hidden-sm">Tips：奇狐快捷管理插件，勾选、提交之后的插件会出现在后台首页，以便快速配置插件。</div>
      </div>
      <div class="card-body">
          <div class="form-group input-group">
              <div class="input-group-prepend"><span class="input-group-text">全选反选 <input type="checkbox" class="checkall ml-2" data-target=".fid" value="" /></span></div>
              <input type="text" placeholder="插件目录" disabled="disabled" class="form-control" />
              <input type="text" placeholder="插件名称" disabled="disabled" class="form-control" />
          </div>
        <form action="<?php echo url("plugin-setting-fox_shortcut");?>" method="post" id="form">
		<?php foreach($pluginlist as $dir => $plugin){$plugin['name'] = array_value($plugin, 'name');?>
          <div class="form-group input-group">
              <div class="input-group-prepend"><span class="input-group-text">快捷管理 <input type="checkbox" <?php if(!empty($odd_shortcut_checked[$dir])){?>checked<?php }?> value="<?php echo $dir;?>" name="odd_shortcut[]" class="fid ml-2" /></span></div>
              <input type="text" placeholder="<?php echo $dir;?>" disabled="disabled" class="form-control control" />
              <input type="text" placeholder="<?php echo $plugin['name'];?>" disabled="disabled" class="form-control control"/>
          </div>
		<?php }?>
          <div class="form-group row">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-primary btn-block" id="submit" data-loading-text="<?php echo lang('submiting');?>..."><?php echo lang('confirm');?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include _include(ADMIN_PATH.'view/htm/footer.inc.htm');?>
<script>
var jform = $("#form");
var jsubmit = $("#submit");
jform.on('submit', function(){
  jform.reset();
  jsubmit.button('loading');
    var postdata = jform.serialize();
  $.xpost(jform.attr('action'), postdata, function(code, message) {
    if(code == 0) {
      $.alert(message);
			jsubmit.text(message).delay(1000).button('reset');
      return;
    } else {
      $.alert(message);
      jsubmit.button('reset');
    }
  });
  return false;
});
$('#nav li.nav-item-plugin').addClass('active');
</script>