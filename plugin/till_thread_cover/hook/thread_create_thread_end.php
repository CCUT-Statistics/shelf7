

if($tid){
    $cover = param('cover', '');
    thread__update($tid, array('cover' => $cover));
}
