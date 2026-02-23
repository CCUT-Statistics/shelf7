<?php //cloudatabases.com
!defined('DEBUG') AND exit('Access Denied.');

if($method=='POST'){
    if(param('csrf')!=session_id()){message(0,lang('fuck_you'));}
	$post = array();
    $post['back_top']=param('back_top',0);
    $post['logo_url']=trim(param('logo_url','',false));
    $post['thread_img_click']=trim(param('thread_img_click'),0);
    $post['thread_aside']=trim(param('thread_aside'),0);
    $post['header_html']=trim(param('header_html','',false));
    $post['footer_html']=trim(param('footer_html','',false));
    $post['footer_top']=trim(param('footer_top','',false));
    $post['ShowXiuno']=param('ShowXiuno',0);
    $post['ShowProcessed']=param('ShowProcessed',0);
    $post['footer_down']=trim(param('footer_down','',false));
    
    setting_set('cf_theme_modern',$post);
	message(0, '<a href="'.http_referer().'">'.lang('set_completely').'</a>');
}
else{
    $json=json_decode(file_get_contents(APP_PATH.'plugin/cf_theme_modern/conf.json'),true);
    include _include(ADMIN_PATH.'view/htm/header.inc.htm');
    
    $cf_theme_modern=setting_get('cf_theme_modern');

		echo '
<a id="cf-index" href="javascript:;" onclick="cf(\'index\');" style="font-weight:bold;">[版本]</a>
<a id="cf-features" href="javascript:;" onclick="cf(\'features\');">[功能]</a>
<a id="cf-code" href="javascript:;" onclick="cf(\'code\');">[自定义代码]</a>
<hr />
<form action="" method="post" id="form">
<span id="cf_index">
<div><b>当前版本</b>：'.$json['version'].'</div>
<div><b>云库论坛</b>：<a href="https://cloudatabases.com" target="_blank">https://cloudatabases.com</a></div>
</span>

<span id="cf_features" style="display:none;">
返回顶部
<div>'.form_radio_yes_no('back_top',empty($cf_theme_modern['back_top'])?0:1).'</div>
<hr />
Logo图片地址
<div>'.form_text('logo_url',empty($cf_theme_modern['logo_url'])?'':$cf_theme_modern['logo_url']).'</div>
<span class="text-grey small">./plugin/cf_theme_modern/images/logo_bbs.png</span>
<hr />
帖子内图片可点击
<div>'.form_radio_yes_no('thread_img_click',empty($cf_theme_modern['thread_img_click'])?0:1).'</div>
<hr />
帖子内容页面显示侧边栏
<div>'.form_radio_yes_no('thread_aside',empty($cf_theme_modern['thread_aside'])?0:1).'</div>
</span>

<span id="cf_code" style="display:none;">
<div><b>站点顶部自定义HTML</b>（可用于放外联文件，或自定义JS/CSS代码）</div>
'.form_textarea('header_html',empty($cf_theme_modern['header_html'])?'':$cf_theme_modern['header_html'], '100%', 100).'
<hr />
<div><b>站点底部自定义HTML</b>（可用于放外联文件，或自定义JS/CSS代码）</div>
'.form_textarea('footer_html',empty($cf_theme_modern['footer_html'])?'':$cf_theme_modern['footer_html'], '100%', 100).'
<hr />
<div><b>页脚上方自定义HTML</b></div>
'.form_textarea('footer_top',empty($cf_theme_modern['footer_top'])?'':$cf_theme_modern['footer_top'], '100%', 100).'
代码示例：
<span class="text-grey small">
<br>Copyright @ '.date("Y").' '.$_SERVER['SERVER_NAME'].'
</span>
<p>
<div><b>页脚显示“Powered by Xiuno”</b></div>
<div>'.form_radio_yes_no('ShowXiuno',empty($cf_theme_modern['ShowXiuno'])?0:1).'</div>
<div><b>页脚显示性能数据</b>（Processed: X.XXX, SQL: XX）</div>
<div>'.form_radio_yes_no('ShowProcessed',empty($cf_theme_modern['ShowProcessed'])?0:1).'</div>
<p>
<div><b>页脚下方自定义HTML</b></div>
'.form_textarea('footer_down',empty($cf_theme_modern['footer_down'])?'':$cf_theme_modern['footer_down'], '100%', 100).'
代码示例：
<span class="text-grey small">
<br>
&lt;h5 class="beian" style="font-size: 0.83em;"&gt;<br>
&lt;a style="color: #868e96;" href="http://beian.miit.gov.cn/" target="_blank"&gt;京ICP备XXXXXXXXX号-XX&lt;/a&gt;<br>
&lt;a&gt; / &lt;/a&gt;<br>
&lt;a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=XXXXXXXXXXXXXX" style="text-decoration:none;"&gt;<br>
&lt;img src="./plugin/cf_theme_modern/img/110.png" style="padding-left: 2px; padding-right: 3px; vertical-align: bottom;"&gt;&lt;/a&gt;<br>
京公网安备 XXXXXXXXXXXXXX号
&lt;/h5&gt;
</span>
</span>
<hr />
<input name="csrf" value="'.session_id().'" style="display:none;" />
<div><a href="javascript:this.form.submit();" id="submit" data-loading-text="'.lang('submiting').'..."><b>['.lang('confirm').']</b></a>
<a href="javascript:history.back();">['.lang('back').']</a>
</div>
</form>
<script>
function cf(page){
document.querySelector(\'#cf-index\').style.fontWeight=(page==\'index\')?\'bold\':\'\';
document.querySelector(\'#cf-features\').style.fontWeight=(page==\'features\')?\'bold\':\'\';
document.querySelector(\'#cf-code\').style.fontWeight=(page==\'code\')?\'bold\':\'\';
document.querySelector(\'#cf_index\').style.display=(page==\'index\')?\'\':\'none\';
document.querySelector(\'#cf_features\').style.display=(page==\'features\')?\'\':\'none\';
document.querySelector(\'#cf_code\').style.display=(page==\'code\')?\'\':\'none\';
};
function cf_filter(text){
var map={\'&\':\'&amp;\',\'<\':\'&lt;\',\'>\':\'&gt;\',\'"\':\'&quot;\',"\'":\'&#039;\'};
return text.replace(/[&<>"\']/g,function(m){return map[m];});
};
</script>

';
include _include(ADMIN_PATH.'view/htm/footer.inc.htm');
}
?>