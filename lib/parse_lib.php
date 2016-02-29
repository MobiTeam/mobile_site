<?

require_once('../auth/ad_functions.php');
modifyPost();

function login($url,$login,$pass){
      $ch = curl_init();
      if(strtolower((substr($url,0,5))=='https')) { // если соединяемся с https
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      }
      curl_setopt($ch, CURLOPT_URL, $url);
      // откуда пришли на эту страницу
      curl_setopt($ch, CURLOPT_REFERER, $url);
      // cURL будет выводить подробные сообщения о всех производимых действиях
      curl_setopt($ch, CURLOPT_VERBOSE, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"LNG=&C21COM=F&I21DBN=RDR&Z21FAMILY=".$login."&Z21ID=".$pass);
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
      curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      //сохранять полученные COOKIE в файл
      curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
      $result=curl_exec($ch);

      curl_close($ch);

      return $result;
}

if(valParametr($_POST["FFIO"]) && valParametr($_POST["id_bibl"])){

   $info_page = (login("http://irbis.ugrasu.ru/cgi-bin/irbis64r_13/cgiirbis_64.exe", $_POST["FFIO"], $_POST['id_bibl']));

   $f_label = 'Литература на руках';
   $s_label = '<!--Разновидности поиска-->';

   $f_pos = strpos($info_page, $f_label);
   $s_pos = strpos($info_page, $s_label);

   $clear_chunk = (substr($info_page, $f_pos, $s_pos - $f_pos));

   $arr_lib = explode("<br><br>", $clear_chunk);
   $arr_unique_lib = array();

   
   preg_match('/<table class=advanced>[\\s\\S]*?([\\s\\S]*?)[\\s\\S]*?<\/table>/', $info_page, $real_fio);

   if(strpos($info_page, "LOGIN.submit()") || !strpos($real_fio[0], $_POST["FFIO"])){
      $err = array("err" => "Ошибка загрузки данных. Пользователя с данным номером читательского билета не существует.");
      die(json_encode_cyr($err));
   }


   for($i = 0; $i < count($arr_lib); $i++){
      if(strpos($arr_lib[$i], "Выдан")){
         array_push($arr_unique_lib, $arr_lib[$i]);
      }
   }

   if(count($arr_unique_lib) > 0){
      print_r(json_encode_cyr($arr_unique_lib));
   } else {
      $err = array("no_books" => "На вашем формуляре нет книг.");
      print_r(json_encode_cyr($err));
   }
 
} else {
   $err = array("err" => "Ошибка загрузки данных. Вы ввели недопустимый номер читательского билета.");
   die(json_encode_cyr($err));
}

?>