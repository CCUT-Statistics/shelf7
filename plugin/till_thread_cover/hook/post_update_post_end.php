
if($isfirst){
    if(!empty($thread['cover'])){
        till_thread_cover_remove($thread['cover']);
    }
    $cover = param('cover', '');
    thread__update($tid, array('cover' => $cover));
}
