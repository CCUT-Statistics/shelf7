if ($forum['well_tpl_cate'] AND file_exists($well_cate_tpl)) {
    $template_page = $well_cate_tpl;
} elseif ( file_exists($template_path . $pre . 'list.htm') ) {
	$template_page = $template_path . $pre . 'list.htm';
} else {
    $template_page = $default_template_path . 'list.htm';
}