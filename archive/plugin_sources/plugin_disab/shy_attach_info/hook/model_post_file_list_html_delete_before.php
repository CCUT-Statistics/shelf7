$s .= '<br><div style="color:#999;font-size:11px;">上传时间：'.date('Y-m-d', $attach['create_date'])."\r\n";
$s .= ' | 下载次数：'.intval($attach['downloads'])."\r\n";
$s .= '次 | 文件大小：'.humansize($attach['filesize'])."\r\n";
$s .= '</div>'."\r\n";