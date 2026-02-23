<?php
function till_thread_cover_remove($file){
    if(!empty($file)){
        return xn_unlink('./' . $file);
    }
}