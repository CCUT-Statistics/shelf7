<?php
$files = scandir(__DIR__);

$final = array();

foreach($files as $file) {

    if (in_array($file,['.','..',basename (__FILE__)],true)) {
        continue;
    }

    $css = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $file);
    
    $css_array = array();
    preg_match_all('/(--[a-zA-Z0-9]+):\s?([#a-zA-Z0-9]+);/', $css, $matches);
    $css_array[] = $matches[2][0];
    $css_array[] = $matches[2][5];
    $css_array[] = $matches[2][6];
    $css_array[] = $matches[2][8];
    $css_array[] = $matches[2][10];
    $css_array[] = $matches[2][11];
    $css_array[] = $matches[2][13];

/*
    for ($i = 0; $i < count($matches[1]); $i++) {
        $css_array[] = $matches[2][$i];
    }
    */
    /*
    $final[$file] = array(
        'label' => ucwords(str_replace(['base16-','.css','-'], ' ', $file)),
        'colors' => $css_array,
    );
    */
    $final[$file] = ucwords(str_replace(['base16-','.css','-'], ' ', $file));
}

var_export($final);
echo ',';