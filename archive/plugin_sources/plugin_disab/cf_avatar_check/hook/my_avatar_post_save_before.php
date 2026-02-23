<?php
exit;
//need gd2
//if(imagecreatefromstring($data)){message(-1, lang('doc_type_not_supported'));}

function check_img_by_source($source) {
   switch(bin2hex(substr($source,0,2))){
	   case 'ffd8' : return 'ffd9' === bin2hex(substr($source,-2));
	   case '8950' : return '6082' === bin2hex(substr($source,-2));
	   case '4749' : return '003b' === bin2hex(substr($source,-2));
	   default : return false;
   }
}
if(!check_img_by_source($data)){message(-1, lang('doc_type_not_supported'));}