	if(empty($forum['seo_keywords'])){
		$header['keywords'] = $thread['subject'].'，'.$forum['name'].'，'.$conf['sitename']; 
	}else{
		$header['keywords'] = $thread['subject'].'，'.$forum['name'].'，'.$forum['seo_keywords'].'，'.$conf['sitename']; 
	}