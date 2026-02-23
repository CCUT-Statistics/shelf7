if (boolval($_user['deprecated']) == true) {
$uid = 0;
$_SESSION['uid'] = $uid;
user_token_clear();
message('email', lang("user_is_deprecated"));
die();
}