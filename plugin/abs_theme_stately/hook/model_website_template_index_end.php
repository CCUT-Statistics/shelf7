if ($website_mode == 2) {
    // 扁平模式首页；原版插件可能没写对文件位置，在这里再次判断，会稍微损失一丁点性能

    // hook model_website_template_index_flat_before.php
    $index = $template_path . $pre . 'index.flat.htm';
    $template_page = file_exists($index) ? $index : $default_template_path . 'index.flat.htm';
}