<?php

!defined('DEBUG') AND exit('Access Denied.');

if (!function_exists('site_seo_xml_escape')) {
	function site_seo_xml_escape($text) {
		$text = strval($text);
		$text = str_replace('&', '&amp;', $text);
		$text = str_replace('<', '&lt;', $text);
		$text = str_replace('>', '&gt;', $text);
		$text = str_replace('"', '&quot;', $text);
		$text = str_replace("'", '&apos;', $text);
		return $text;
	}
}

if (!function_exists('site_seo_iso8601')) {
	function site_seo_iso8601($timestamp) {
		$timestamp = intval($timestamp);
		if ($timestamp <= 0) {
			$timestamp = time();
		}
		return date('c', $timestamp);
	}
}

global $db;

$base_url = rtrim(http_url_path(), '/') . '/';
$url_rows = array();

// Home page
$url_rows[] = array(
	'loc' => $base_url,
	'lastmod' => site_seo_iso8601(time()),
	'changefreq' => 'hourly',
	'priority' => '1.0',
);

// Public forums
$forumlist = forum_list_cache();
$forumlist = forum_list_access_filter($forumlist, 0, 'allowread');
$public_fids = array();
foreach ($forumlist as $fid => $forum) {
	$fid = intval($fid);
	if ($fid <= 0) {
		continue;
	}
	$public_fids[] = $fid;
	$url_rows[] = array(
		'loc' => $base_url . url('forum-' . $fid),
		'lastmod' => site_seo_iso8601(array_value($forum, 'create_date')),
		'changefreq' => 'hourly',
		'priority' => '0.8',
	);
}

// Recent threads (limit to keep XML compact and stable)
$max_threads = 3000;
if (!empty($public_fids)) {
	$public_fids = array_map('intval', $public_fids);
	$fid_sql = implode(',', $public_fids);
	$tablepre = $db->tablepre;
	$sql = "SELECT tid, last_date FROM `{$tablepre}thread` WHERE fid IN ($fid_sql) ORDER BY last_date DESC LIMIT $max_threads";
	$threadlist = db_sql_find($sql);
	foreach ((array)$threadlist as $thread) {
		$tid = intval(array_value($thread, 'tid'));
		if ($tid <= 0) {
			continue;
		}
		$url_rows[] = array(
			'loc' => $base_url . url('thread-' . $tid),
			'lastmod' => site_seo_iso8601(array_value($thread, 'last_date')),
			'changefreq' => 'daily',
			'priority' => '0.7',
		);
	}
}

@header('Content-Type: application/xml; charset=UTF-8');
@header('X-Robots-Tag: all');

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($url_rows as $row) {
	echo "\t<url>\n";
	echo "\t\t<loc>" . site_seo_xml_escape($row['loc']) . "</loc>\n";
	echo "\t\t<lastmod>" . site_seo_xml_escape($row['lastmod']) . "</lastmod>\n";
	echo "\t\t<changefreq>" . site_seo_xml_escape($row['changefreq']) . "</changefreq>\n";
	echo "\t\t<priority>" . site_seo_xml_escape($row['priority']) . "</priority>\n";
	echo "\t</url>\n";
}
echo "</urlset>";
exit;

