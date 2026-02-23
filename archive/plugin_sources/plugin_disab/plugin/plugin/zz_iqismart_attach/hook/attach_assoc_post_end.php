foreach($filelist as $file) {
	$aid = $file['aid'];
	$type = param('attach-'.$aid.'-type');
	$value = param('attach-'.$aid.'-value');
 
	if(!empty($value)){
		 attach__update($aid,array(($type.'')=>$value)); 
	}
	
}