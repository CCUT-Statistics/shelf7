<?php !defined('DEBUG') AND exit('Access Denied.');include _include(APP_PATH.'view/htm/header.inc.htm');?>
<div class="card">
    <div class="card-header">打赏</div>
    <div class="card-body ajax-body">
        <?php if(!empty($user['uid'])){?>
        <form action="<?php echo url("thread-reward-$thread[tid]");?>" method="post" id="mod_reward_form">
        <div class="row">
            <div class="col-8">
                <div class="mb-3">
                    <label class="form-label" for="golds_num">打赏金币</label>
                    <input type="number" min="1" max="999" step="1" class="form-control" name="golds_num" id="golds_num" value="1" required oninvalid="setCustomValidity('金额只能为1的正整数倍(不含小数点)')" oninput="setCustomValidity('')" minlength="1" maxlength="3" />
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label class="form-label">我的金币</label>
                    <div class="form-control text-primary"><?php echo $user['golds'];?></div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="reason">打赏理由</label>
                    <input type="text" class="form-control" name="reason" id="reason" maxlength="30" value="<?php echo $default_reason;?>" placeholder="<?= $reasonlist[0] ?>" required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label" for="reasonselect">快捷理由</label>
                    <select id="reasonselect" class="form-select">
                        <?php foreach($reasonlist as $str):?>
                            <option value="<?php echo $str;?>" <?php if($str == $default_reason){echo 'selected="selected"';}?>><?php echo $str;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
        </div>

        <div class="d-flex">
            <button type="button" class="btn btn-primary flex-grow-1 mr-2" id="mod_reward_submit" data-loading-text="<?php echo lang('submiting');?>...">确认打赏</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
        </div>
        </form>
        <?php }else{?>
        <div class="mb-2 text-center w100 pt-3">
            <a class="btn btn-primary mr-2" href="<?php echo url('user-login');?>"><i class="icon-user"></i> <?php echo lang('login');?></a>
            <a class="btn btn-success mr-2" href="<?php echo url('user-create');?>"><i class="icon-user"></i> <?php echo lang('register');?></a>
            <a class="btn btn-danger" href="<?php echo url('user-create');?>" data-bs-dismiss="modal"><i class="icon-user"></i> <?php echo lang('close');?></a>
        </div>
        <?php }?>
        </form>
    </div>
</div>
<?php include _include(APP_PATH.'view/htm/footer.inc.htm');?>
<?php if(!empty($user['uid'])){?>
<script ajax-eval="true">
var args = args || {jmodal: null, callback: null, arg: null};
var jmodal = args.jmodal;
$("#golds_num").bind("input propertychange",function(event){
    if(this.value.length == 1) {
        this.value = this.value.replace(/[^1-9]/g, '1');
    } else {
        this.value = this.value.replace(/\D/g, '0');
    }
})
var jreadp = $("#reason");
$(document).ready(function(){
    $("#reasonselect").change(function(){
        jreadp.val($(this).children('option:selected').attr('value'));
    });
});
var jform = $("#mod_reward_form");
var jsubmit = $("#mod_reward_submit");
var jgolds_num = $("#golds_num");    
jsubmit.on('click',function(){
  //if(confirm('您确定要打赏作者吗?')){
      $(this).attr("disabled", "disabled");
      var jsthis = $(this);
      if(jgolds_num.val() < 1){
          $.toast({

              title: '提示',
              content:'打赏金币数量不能为空！',
              type: 'warning'
            }
            );
          return false;
      }
      if(jreadp.val() == ''){
          $.toast({
              title: '提示',
              content:'请选择打赏理由！',
              type: 'warning'
            }
            );
          return false;
      }
      jform.reset();
      jsubmit.button('loading');      
      var postdata = jform.serialize();
      $.xpost(jform.attr('action'), postdata, function(code,message){
          if(code == 0){
            $.toast({
              title: '提示',
              content:message,
              type: 'success'
            });
              jsubmit.button('reset');
              setTimeout(function(){
                  if(jmodal) jmodal.dispose();
                  window.location.reload(); //如果使用了XIUNO官方JSON返回论坛数据插件，ajax刷新页面无效，需要使用JS刷新页面
                  //$('#fox_reward').load(' #fox_reward_load');  //如果使用了XIUNO官方JSON返回论坛数据插件，ajax刷新页面无效，需要使用JS刷新页面
                 // $('body').removeClass('modal-open').removeAttr('style');
              }, 1000);
              return false;
          }else{
            $.toast({
              title: '提示',
              content:message,
              type: 'warning'
            }
            );
              jsubmit.button('reset');

              return false;
          }
          jsthis.removeAttr("disabled");
      });
  //}
});
</script>
<?php }?>