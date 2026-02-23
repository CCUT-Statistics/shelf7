$s .= '<small class=" d-none d-md-block text-muted float-right" >'.humansize($attach['filesize'])."\r\n";
 $date = new DateTime;
  $date->setTimestamp($attach['create_date']);
$s .= ' | 更新于: '.( $date->format('Y-m-d H:i:s'))."\r\n";
//$s .= ' | 下载次数：'.intval($attach['downloads'])."\r\n";
$s .= '</small>'."\r\n";