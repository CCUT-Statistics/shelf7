$arrlist = db_find_one('thread',array('subject'=>$subject));
if(!empty($arrlist)) {
    message(-1, '该 标题 已经被使用，请换其他 标题 试试。');
}