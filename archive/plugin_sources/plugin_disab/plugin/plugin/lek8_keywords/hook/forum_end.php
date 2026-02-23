	if(empty($forum['seo_keywords'])){
		$header['keywords'] = $forum['name'].'，'.$conf['sitename'];
	}else{
		$header['keywords'] = $forum['seo_keywords'].'，'.$forum['name'].'，'.$conf['sitename'];
	}