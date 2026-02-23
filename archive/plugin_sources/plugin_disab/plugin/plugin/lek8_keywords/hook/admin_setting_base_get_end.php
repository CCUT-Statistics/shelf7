		if(empty($conf['keywords'])){
			$input['keywords'] = form_text('keywords', $header['keywords']);
		}else{
			$input['keywords'] = form_text('keywords', $conf['keywords']);
		}
