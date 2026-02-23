$is_draft = param('is_draft',false);

if($is_draft) {
$new_draft = array();
$draft_r = thread_draft_create($uid,$new_draft);
if($draft_r ) {
message(0,'草稿已保存');
} else {
message(1,'草稿尚未保存');
}
die;
}