	 
	$s = '<fieldset class="fieldset">'."\r\n";
      
	$s .= '<legend>上传的附件：</legend>'."\r\n";
	$s .= '<ul class="attachlist col-12">'."\r\n";
	foreach ($filelist as &$attach) {
		$s .= '<li aid="'.$attach['aid'].'">'."\r\n";
		$s .= '		<a href="'.url("attach-download-$attach[aid]").'" target="_blank">'."\r\n";
		$s .= '			<i class="icon filetype '.$attach['filetype'].'"></i>'."\r\n";
		$s .= '			'.$attach['orgfilename']."\r\n";
		$s .= '		</a>'."\r\n";
      	$uid = intval(_SESSION('uid'));
        $buy = db_find_one('attach_buy', array('uid' => intval(_SESSION('uid')),'aid' => $attach["aid"]));
      
      	if (strpos($_SERVER['REQUEST_URI'], 'update') !== false){
      	
          if($attach['credits'] > 0){
              $s .= "<select name='attach-".$attach["aid"]."-type' style='line-height:1rem;margin-left:10px;margin-right:10px'><option value='credits' selected>经验</option><option value='golds'>金币</option><option value='rmbs'>人民币</option></select>";
              $s .= "<input name='attach-".$attach["aid"]."-value'   value='".$attach['credits']."' style='width:50px;line-height:1rem;margin-left:10px;' type='number' />";
		      
          }else if($attach['golds'] > 0){
              $s .= "<select name='attach-".$attach["aid"]."-type' style='line-height:1rem;margin-left:10px;margin-right:10px'><option value='credits' >经验</option><option value='golds' selected>金币</option><option value='rmbs'>人民币</option></select>";
              $s .= "<input name='attach-".$attach["aid"]."-value'   value='".$attach['golds']."' style='width:50px;line-height:1rem;margin-left:10px;' type='number' />";

          }else if($attach['rmbs'] > 0){
              $s .= "<select name='attach-".$attach["aid"]."-type' style='line-height:1rem;margin-left:10px;margin-right:10px'><option value='credits' >经验</option><option value='golds'>金币</option><option value='rmbs' selected>人民币</option></select>";
               $s .= "<input name='attach-".$attach["aid"]."-value'   value='".$attach['rmbs']."' style='width:50px;line-height:1rem;margin-left:10px;' type='number' />";
          }else {
               $s .= "<select name='attach-".$attach["aid"]."-type' style='line-height:1rem;margin-left:10px;margin-right:10px'><option value='credits' >经验</option><option value='golds'>金币</option><option value='rmbs'>人民币</option></select>";
               $s .= "<input name='attach-".$attach["aid"]."-value'   value='0' style='width:50px;line-height:1rem;margin-left:10px;' type='number' />";

          }
      	}else{
      		 if($attach['credits'] > 0){
              $s .= '<div class="attachprice"><img style="width:1rem;margin:0 auto;" src="plugin/zz_iqismart_attach/img/money.png"> '.$attach['credits'].'经验';
      			if(empty($buy) && $uid != $attach["uid"]) $s .= "<a target='_blank' style='color:red;margin-left:5px;' href='".url('attach_buy').'?aid='.$attach["aid"]."'>购买</a>";
      			else $s .= "<span style='color:gray;margin-left:5px;'>已购</span>";
            }else if($attach['golds'] > 0){
              $s .= '<div  class="attachprice"><img style="width:1rem;margin:0 auto;" src="plugin/zz_iqismart_attach/img/money.png"> '.$attach['golds'].'金币';
		      if(empty($buy) && $uid != $attach["uid"])  $s .= "<a target='_blank' style='color:red;margin-left:5px;' href='".url('attach_buy').'?aid='.$attach["aid"]."'>购买</a>";
      			else $s .= "<span style='color:gray;margin-left:5px;'>已购</span>";
            }else if($attach['rmbs'] > 0){
      			$s .= '<div  class="attachprice"><img style="width:1rem;margin:0 auto;" src="plugin/zz_iqismart_attach/img/money.png"> '.($attach['rmbs']/100).'元';
      			if(empty($buy) && $uid != $attach["uid"])  $s .= "<a target='_blank' style='color:red;margin-left:5px;' href='".url('attach_buy').'?aid='.$attach["aid"]."'>购买</a>";
      			else $s .= "<span style='color:gray;margin-left:5px;'>已购</span>";
            } else{}
      	}
      	
		// hook model_post_file_list_html_delete_before.php
		$include_delete AND $s .= '		<a href="javascript:void(0)" class="delete ml-3"><i class="icon-remove"></i> '.lang('delete').'</a>'."\r\n";
		// hook model_post_file_list_html_delete_after.php
		$s .= '</li>'."\r\n";
	};
	$s .= '</ul>'."\r\n";
	$s .= '</fieldset>'."\r\n";

	$s .= '<style>.attachlist_parent{width:100% !important;}</style>'."\r\n";
	$s .= '<style>.attachprice{display: inline;margin-left: 10px;font-size: 1rem;line-height:30px;}</style>'."\r\n";