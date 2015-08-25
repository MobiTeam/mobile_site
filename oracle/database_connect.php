<?php 
   
  $c=@OCILogon("MOBILE", "kisupass1993", "GALASERV", "AL32UTF8");
  
  if(!$c){
	   echo('{"FIO":"undefined","serverRequest":"База данных сервера недоступна.","is_student":"0","groups":"", "errFlag":"0"}');
	   die();
	   }

?>