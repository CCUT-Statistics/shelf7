if ($forum['well_tpl'] AND file_exists($well_show_tpl) ) {
    $template_page = $well_show_tpl;
} elseif ( file_exists($template_path . $pre . 'read.htm') ) {
	$template_page = $template_path . $pre . 'read.htm';
} else {
	$template_page = $default_template_path . 'read.htm';
}