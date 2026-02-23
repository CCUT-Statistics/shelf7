$user_draft = thread_draft_find_draft_by_subject($uid, param('subject', 'Untitled'));

if ($user_draft) {
thread_draft_delete($uid, $user_draft['draftid']);
}