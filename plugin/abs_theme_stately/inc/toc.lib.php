<?php

/**
 * 显示目录模块
 *
 * @param string $content 要解析的内容
 * @param string $display_position 要显示的位置
 */
function article_toc($content, $display_position = '') {
    global $uid, $thread;
    /**
     * @var string $tableOfContents 文章目录的HTML
     */
    $tableOfContents = "<ol class='list-unstyled'>";
    /**
     * @var bool $has_index 是否可以组成目录？
     */
    $has_index = false;
    /**
     * @var array $indexes 计算目录层级
     */
    $indexes = [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
    $index = 1;

    $tableOfContents_js = '<script>'
    . 'document.getElementById("table_of_contents__thread").querySelectorAll("li>a").forEach(function(item){
        item.addEventListener("click",function(){
        if(document.querySelector("#table_of_contents__thread>details").getAttribute("open") !== null) {
        document.querySelector("#table_of_contents__thread>details").removeAttribute("open")
        }
        })});'
        . '</script>';

    preg_match_all('#<(h[2-6])(.*?)>(.*?)</\1>#si',$content,$all_headings);
    if(count($all_headings[1]) >= 1) {
        $has_index = true;
    }
    unset($all_headings);
    
    // Insert the IDs and create the TOC.
$content = preg_replace_callback('#<(h[2-6])(.*?)>(.*?)</\1>#si', function ($matches) use (&$index, &$tableOfContents, &$indexes) {
    $tag = $matches[1];
    $level = (int)$tag[1]; // Get the heading level as an integer
    $title = strip_tags($matches[3]);
    $hasId = preg_match('/id=(["\'])(.*?)\1[\s>]/si', $matches[2], $matchedIds);
    $id = $hasId ? $matchedIds[2] : 'index-' . $index++;

    // Reset indexes for deeper levels than the current heading level
    for ($i = $level + 1; $i <= 6; $i++) {
        $indexes[$i] = 0;
    }
    
    // Increment the index for the current level and generate the prefix
    $prefix = '';
    for ($i = 2; $i <= $level; $i++) {
        if ($i == $level) {
            $indexes[$i]++;
        }
        $prefix .= $indexes[$i] . '.';
    }

    $title = '<span class="text-body toc-prefix">' . ltrim($prefix,"0.") . ' </span>' . $title;
    $tableOfContents .= "<li class='item-$tag'><a href='#$id'>$title</a></li>";

    if ($hasId) {
        return $matches[0];
    }
    return sprintf('<%s%s id="%s">%s</%s>', $tag, $matches[2], $id, $matches[3], $tag);
}, $content);

    $tableOfContents .= '</ol>';
    
    //var_dump($display_position,$has_index);
    /**
     * @var string $new_content 最终输出结果
     */
    $new_content = '';
    switch ($display_position) {
        //*
        case 'thread':
            if ($has_index) {
                $new_content = "<section id='table_of_contents__thread' class='accordion float-end'>"
                    ."<details class='card border border-info accordion-item'>"
                    . "<summary class='accordion-button'>" . lang("article_toc_title") . "</summary>"
                    . "<section class='accordion-body'>"
                    . "<div class='table_of_contents'>"
                    . $tableOfContents
                    . "</div>"
                    . "</section>"
                    . "</details>"
                    . "</section>"
                    . $content
                    . $tableOfContents_js;
                    break;
            } 
        case 'thread_auto':
            if ($has_index) {
                $new_content = "<section id='table_of_contents__thread' class='accordion float-end d-block d-lg-none'>"
                    ."<details class='card border border-info accordion-item'>"
                    . "<summary class='accordion-button'>" . lang("article_toc_title") . "</summary>"
                    . "<section class='accordion-body'>"
                    . "<div class='table_of_contents'>"
                    . $tableOfContents
                    . "</div>"
                    . "</section>"
                    . "</details>"
                    . "</section>"
                    . $content
                    . $tableOfContents_js;
                } else {
                    $new_content = ( $has_index ? $tableOfContents : $content);
                }
                break;
        case 'widget':
            $new_content = "<h4 class='h6 card-header'><i class='las la-list-ul text-info'></i> " . lang("article_toc_title") . "</h4>"
                . "<section class='card-body'>"
                . "<div class='table_of_contents'>"
                . ( $has_index ? $tableOfContents : lang('none') )
                . "</div>"
                . "</section>";
                break;
        default:
            $new_content = "<details id=\"article-index\" class='table_of_contents'>"
                . "<summary>" . lang("article_toc_title") . "</summary>"
                . "<section id='table_of_contents'>\n" . $tableOfContents . "</section>"
                . "</details>\n"
                . $content;
            break;
            //*/
    }
    return $new_content;
}
?>