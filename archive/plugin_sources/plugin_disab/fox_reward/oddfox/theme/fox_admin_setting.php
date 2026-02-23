<?php !defined('DEBUG') AND exit('Access Denied.');include _include(ADMIN_PATH.'view/htm/header.inc.htm');?>
<div class="row">
  <div class="col-lg-12">
    <div class="btn-group mb-3" role="group">
        <a class="btn btn-secondary" href="<?php echo url("plugin");?>">本地插件</a>
        <a class="btn btn-secondary active" href="javascript:void(0);">插件设置</a>
    </div>
    <div class="btn-group mb-3 hidden-sm float-right" role="group">
        <a class="btn btn-danger" target="_blank" href="https://bbs.oddfox.cn"><i class="icon-firefox"></i></a>
        <a class="btn btn-dark" href="javascript:void(0);" onclick="javascript:location.reload();"><i class="icon-refresh"></i></a>
        <a class="btn btn-dark" href="<?php echo url("plugin");?>"><i class="icon-times"></i></a>
    </div>
    <div class="w-100"></div>
    <div class="card">
          <div class="card-header"><i class="icon-cogs"></i> 奇狐网插件设置</div>
          <div class="card-body pb-0">
              <form action="<?php echo url("plugin-setting-fox_reward");?>" method="post" id="form">
              <div class="form-group row">
                  <label class="col-sm-2 form-control-label text-sm-right pr-sm-0">使用贴内打赏的板块：</label>
                  <div class="col-sm-10"><?php if($forums){ foreach($forums as $val){?>
                      <label class="custom-input custom-checkbox mr-2"><input type="checkbox" class="is_reward" name="is_reward[]" value="<?php echo $val['fid'];?>" <?php if(!empty($val['is_reward'])){?>checked<?php }?> /> <?php echo $val['name'];?></label><?php }}?><label class="custom-input custom-checkbox"><input type="checkbox" class="checkall ml-2" data-target=".is_reward" value="" /> 全选反选</label>
                  </div>
              </div>              
              <div class="form-group row">
                  <label class="col-sm-2 form-control-label text-sm-right pr-sm-0 pt-sm-2">用户最高打赏金币数：</label>
                  <div class="col-sm-10">
                      <?php echo $input['fox_golds_num_max'];?>
                      <p class="mt-2 text-grey small mb-0">注：管理员组不受限制。</p>
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-sm-2 form-control-label text-sm-right pr-sm-0 pt-sm-2">用户每天能打赏次数：</label>
                  <div class="col-sm-10">
                      <?php echo $input['fox_reward_max_num'];?>
                      <p class="mt-2 text-grey small mb-0">注：管理员组不受限制。</p>
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-sm-2 form-control-label text-sm-right pr-sm-0 pt-sm-2">打赏时是否扣除金币：</label>
                  <div class="col-sm-10">
                      <?php echo $input['fox_golds_reduce'];?>
                  </div>
              </div>
              
              <div class="form-group row">
                  <label class="col-sm-2 form-control-label text-sm-right pr-sm-0">请填写快捷打赏理由：</label>
                  <div class="col-sm-10">
                      <?php echo $input['fox_reward_reason'];?>
                      <p class="mt-2 text-grey small mb-0">注：多个打赏理由请用$$$分隔</p>
                  </div>
              </div>
              <p class="text-center">
                 <button type="submit" class="btn btn-primary" id="submit" data-loading-text="<?php echo lang('submiting');?>..." style="width:100%;"><?php echo lang('confirm');?></button>
              </p>
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
            setTimeout(function() {
                window.location.reload();
                jsubmit.button('reset');
            }, 1000);
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