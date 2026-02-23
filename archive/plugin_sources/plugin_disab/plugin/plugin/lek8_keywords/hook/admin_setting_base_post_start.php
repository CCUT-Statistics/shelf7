		$keywords = param('keywords', '', FALSE);
		$replace = array();
		$replace['keywords'] = $keywords;

		
		file_replace_var(APP_PATH.'conf/conf.php', $replace);