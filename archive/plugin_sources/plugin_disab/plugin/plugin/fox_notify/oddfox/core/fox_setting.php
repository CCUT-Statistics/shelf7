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
        <div class="card-body">
        <form action="<?php echo url("plugin-setting-fox_notify");?>" method="post" id="form">
          <div class="form-group row">
              <label class="col-sm-2 form-control-label">公告开关：</label>
              <div class="col-sm-10">
                  <?php echo $input['notice_on'];?>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-sm-2 form-control-label">公告类型：</label>
              <div class="col-sm-10">
                  <?php echo $input['notice_type'];?>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-sm-2 form-control-label">公告标题：</label>
              <div class="col-sm-10">
                  <?php echo $input['notice_title'];?>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-sm-2 form-control-label">关闭按钮：</label>
              <div class="col-sm-10">
                  <?php echo $input['notice_button'];?>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-sm-2 form-control-label">公告内容：</label>
              <div class="col-sm-10">
                  <?php echo $input['notice_content'];?>
                  <p class="mt-2 text-grey small">注：支持 HTML 标签，换行请使用 &lt;br&gt; </p>
              </div>
          </div>
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
var referer = '<?php echo http_referer();?>';
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