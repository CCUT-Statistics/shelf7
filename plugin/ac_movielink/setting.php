<?php
!defined('DEBUG') AND exit('Access Denied.');

if (!function_exists('ac_movielink_normalize_weekday')) {
	function ac_movielink_normalize_weekday($value)
	{
		$value = trim(strval($value));
		$mapping = array(
			'1' => 1, '周一' => 1, '星期一' => 1,
			'2' => 2, '周二' => 2, '星期二' => 2,
			'3' => 3, '周三' => 3, '星期三' => 3,
			'4' => 4, '周四' => 4, '星期四' => 4,
			'5' => 5, '周五' => 5, '星期五' => 5,
			'6' => 6, '周六' => 6, '星期六' => 6,
			'7' => 7, '周日' => 7, '星期日' => 7, '星期天' => 7,
		);
		if (isset($mapping[$value])) {
			return $mapping[$value];
		}

		$day = intval($value);
		return ($day >= 1 && $day <= 7) ? $day : 1;
	}
}

if (!function_exists('ac_movielink_normalize_source_type')) {
	function ac_movielink_normalize_source_type($value)
	{
		$type = intval($value);
		return in_array($type, array(0, 1, 2), true) ? $type : 0;
	}
}

if (!function_exists('ac_movielink_normalize_time')) {
	function ac_movielink_normalize_time($value)
	{
		$value = trim(strval($value));
		if (!preg_match('/^\d{2}:\d{2}$/', $value)) {
			return '00:00';
		}

		$hour = intval(substr($value, 0, 2));
		$minute = intval(substr($value, 3, 2));
		if ($hour < 0 || $hour > 23 || $minute < 0 || $minute > 59) {
			return '00:00';
		}

		return sprintf('%02d:%02d', $hour, $minute);
	}
}

if (!function_exists('ac_movielink_pick')) {
	function ac_movielink_pick($arr, $primary, $fallback = NULL)
	{
		if (is_array($arr) && isset($arr[$primary])) {
			return $arr[$primary];
		}
		if ($fallback !== NULL && is_array($arr) && isset($arr[$fallback])) {
			return $arr[$fallback];
		}
		return '';
	}
}

$action = param(3);
if (!empty($action)) {
	message(-1, '不支持的操作');
}

$movielink_setting = setting_get('ac_movielink');
!is_array($movielink_setting) AND $movielink_setting = array();
isset($movielink_setting['gcs_base_url']) OR $movielink_setting['gcs_base_url'] = '';

$movielink_linklist = db_find('movielink', array(), array('linkid' => 1), 1, 1000, 'linkid');
!is_array($movielink_linklist) AND $movielink_linklist = array();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	foreach ($movielink_linklist as &$arr) {
		$arr['nametype'] = ac_movielink_normalize_weekday(isset($arr['nametype']) ? $arr['nametype'] : 1);
		$arr['type'] = ac_movielink_normalize_source_type(isset($arr['type']) ? $arr['type'] : 0);
		$arr['start_time'] = ac_movielink_normalize_time(isset($arr['start_time']) ? $arr['start_time'] : '00:00');
		$arr['end_time'] = ac_movielink_normalize_time(isset($arr['end_time']) ? $arr['end_time'] : '00:00');
	}
	unset($arr);

	$maxid = db_maxid('movielink', 'linkid');
	include _include(APP_PATH.'plugin/ac_movielink/setting.htm');
	return;
}

$rowidarr = param('rowid', array());
$namearr = param('name', array());
$urlarr = param('url', array());
$imgurlarr = param('imgurl', array());
$nametypearr = param('nametype', array());
$source_type_arr = param('source_type', array());
$start_time_arr = param('start_time', array());
$end_time_arr = param('end_time', array());

$submitted_ids = array();
foreach ($rowidarr as $form_key => $rowid_value) {
	$rowid = intval($rowid_value);
	if ($rowid <= 0) $rowid = intval($form_key);
	if ($rowid <= 0) continue;

	$fallback_key = strval($rowid);
	$name = trim(strval(ac_movielink_pick($namearr, $form_key, $fallback_key)));
	$url = trim(strval(ac_movielink_pick($urlarr, $form_key, $fallback_key)));
	if ($name === '' && $url === '') continue;

	$imgurl = trim(strval(ac_movielink_pick($imgurlarr, $form_key, $fallback_key)));
	$imgurl === '' AND $imgurl = 'view/img/logo.png';

	$data = array(
		'name' => $name,
		'url' => $url,
		'imgurl' => $imgurl,
		'nametype' => ac_movielink_normalize_weekday(ac_movielink_pick($nametypearr, $form_key, $fallback_key)),
		'type' => ac_movielink_normalize_source_type(ac_movielink_pick($source_type_arr, $form_key, $fallback_key)),
		'start_time' => ac_movielink_normalize_time(ac_movielink_pick($start_time_arr, $form_key, $fallback_key)),
		'end_time' => ac_movielink_normalize_time(ac_movielink_pick($end_time_arr, $form_key, $fallback_key)),
	);

	if (isset($movielink_linklist[$rowid])) {
		db_update('movielink', array('linkid' => $rowid), $data);
	} else {
		$data['linkid'] = $rowid;
		$data['create_date'] = isset($time) ? intval($time) : time();
		db_create('movielink', $data);
	}

	$submitted_ids[$rowid] = 1;
}

foreach ($movielink_linklist as $db_rowid => $arr) {
	$db_rowid = intval($db_rowid);
	if (!isset($submitted_ids[$db_rowid])) {
		db_delete('movielink', array('linkid' => $db_rowid));
	}
}

$gcs_base_url = trim(strval(param('gcs_base_url', '')));
$movielink_setting['gcs_base_url'] = rtrim($gcs_base_url, '/');
setting_set('ac_movielink', $movielink_setting);

message(0, '保存成功');
?>
