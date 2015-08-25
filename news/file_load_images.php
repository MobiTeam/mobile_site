<?php

  $link = "http://www.ugrasu.ru".$arr_img_rev[$counter];
  $position = strripos($link,'.');
  $format = strtolower(substr($link,$position,strlen($link)-$position));
  $img_num = ++$num;
  $image_full_src = 'http://cisu.ugrasu.ru/news/pre_images/img_'.($img_num).$format;
  
  //$cr_image = createImageFromAny($link);
/*   for($i=0;$i<10;$i++){
	  imagefilter($cr_image,IMG_FILTER_GAUSSIAN_BLUR);
  } */
  
    saveImageFromAny($link,createImageFromAny($link),$img_num);
  //file_put_contents("pre_images/img_".($img_num).$format,imageconvolution(createImageFromAny($link), $gaussian, 16, 0));

?>