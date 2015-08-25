<?php

   function createImageFromAny($url){
	   $arr_images = getimagesize($url);
	   
	   switch($arr_images['mime']){
	        case 'image/jpeg':
			return imagecreatefromjpeg($url);
			break;
			case 'image/png':
			return imagecreatefrompng($url);
			break;
			case 'image/gif':
			return imagecreatefromgif($url);
			break;
			default:
            throw new InvalidArgumentException('Файл "'.$url.'" имеет неподдерживаемый формат.');
			break;
       }
   }  
   
   function saveImageFromAny($url,$file,$img_num){
	    $arr_images = getimagesize($url);
		$gaussian = array(array(1.0, 2.0, 1.0), array(2.0, 4.0, 2.0), array(1.0, 2.0, 1.0));
		$emboss = array(array(2, 0, 0), array(0, -1, 0), array(0, 0, -1));
		/* for($i=0;$i<1;$i++){ */
	     // imagefilter($file,IMG_FILTER_CONTRAST,25);
        /* } */
	   // imageconvolution($file, $gaussian, 16, 0);
	   switch($arr_images['mime']){
	        case 'image/jpeg':
			return imagejpeg($file,"pre_images/img_".($img_num).'.jpg');
			break;
			case 'image/png':
			return imagepng($file,"pre_images/img_".($img_num).'.png');
			break;
			case 'image/gif':
			return imagegif($file,"pre_images/img_".($img_num).'.gif');
			break;
			default:
            throw new InvalidArgumentException('Файл "'.$url.'" имеет неподдерживаемый формат.');
			break;
       }
	   
   }
   
 function stripWhitespaces($string) {
	 
	  $old_string = $string;
	  $string = str_replace(array("«","»"),'"',str_replace('·','&middot;',strip_tags($string,'<b></b><i></i><u></u>')));
	  $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u',' ', $string);
	  $string = str_replace('  ',' ', $string);
	  $string = trim($string);
	  
	  if ($string === $old_string) {
		return $string;
	  } else {
		return stripWhitespaces($string); 
	  }  
}
?>