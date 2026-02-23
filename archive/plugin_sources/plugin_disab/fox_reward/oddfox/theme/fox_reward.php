<?php !defined('DEBUG') AND exit('Access Denied.');include _include(APP_PATH.'view/htm/header.inc.htm');?>
<div class="card">
    <div class="card-header">打赏</div>
    <div class="card-body ajax-body">
        <?php if(!empty($user['uid'])){?>
        <form action="<?php echo url("thread-reward-$thread[tid]");?>" method="post" id="mod_reward_form">
        <div class="input-group mb-3">
            <div class="input-group-prepend w-25"><span class="input-group-text w-100">我的金币</span></div>
            <div class="custom-input form-control text-danger"><?php echo $user['golds'];?> 枚</div>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend w-25"><span class="input-group-text w-100">打赏金币</span></div>
            <input type="number" class="form-control" name="golds_num" id="golds_num" value="1" required oninvalid="setCustomValidity('金额只能为1的正整数倍(不含小数点)')" oninput="setCustomValidity('')" minlength="1" maxlength="3" />
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend w-25"><span class="input-group-text w-100">打赏理由</span></div>
            <input type="text" class="form-control" name="reason" id="reason" maxlength="30" value="<?php echo $default_reason;?>" required />
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend w-25"><span class="input-group-text w-100">快捷理由</span></div>
            <select id="reasonselect" class="form-control">
            <?php foreach($reasonlist as $str){?>
                <option value="<?php echo $str;?>" <?php if($str == $default_reason){echo 'selected="selected"';}?>><?php echo $str;?></option>
            <?php }?>
            </select>
        </div>
        <div class="text-center w100">
            <button type="button" class="btn btn-primary mr-2" id="mod_reward_submit" data-loading-text="<?php echo lang('submiting');?>...">确认</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        </div>
        </form>
        <?php }else{?>
        <div class="mb-2 text-center w100 pt-3">
            <a class="btn btn-primary mr-2" href="<?php echo url('user-login');?>"><i class="icon-user"></i> <?php echo lang('login');?></a>
            <a class="btn btn-success mr-2" href="<?php echo url('user-create');?>"><i class="icon-user"></i> <?php echo lang('register');?></a>
            <a class="btn btn-danger" href="<?php echo url('user-create');?>" data-dismiss="modal"><i class="icon-user"></i> <?php echo lang('close');?></a>
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
          $.alert('打赏金币数量不能为空！');
          return false;
      }
      if(jreadp.val() == ''){
          $.alert('请选择打赏理由！');
          return false;
      }
      jform.reset();
      jsubmit.button('loading');      
      var postdata = jform.serialize();
      $.xpost(jform.attr('action'), postdata, function(code,message){
          if(code == 0){
              $.alert(message, 1);
              jsubmit.button('reset');
              setTimeout(function(){
                  if(jmodal) jmodal.modal('dispose');
                  //window.location.reload(); //如果使用了XIUNO官方JSON返回论坛数据插件，ajax刷新页面无效，需要使用JS刷新页面
                  $('#fox_reward').load(' #fox_reward_load');  //如果使用了XIUNO官方JSON返回论坛数据插件，ajax刷新页面无效，需要使用JS刷新页面
                  $('body').removeClass('modal-open').removeAttr('style');
              }, 1000);
              return false;
          }else{
              $.alert(message, 1);
              jsubmit.button('reset');
              setTimeout(function(){if(jmodal){jmodal.modal('dispose');}$('body').removeClass('modal-open').removeAttr('style');}, 1000);
              return false;
          }
          jsthis.removeAttr("disabled");
      });
  //}
});
</script>
<?php }?>