<?php 
  
  function serviceping($host, $port, $timeout) //Пингуем сервер
     {   
	    $op = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$op){
			return 0; 
		} //DC is N/A
          else {
            fclose($op); //explicitly close open socket connection
            return 1; //DC is up & running, we can safely connect with ldap_connect
           }
}
  
  function auth($login, $password, $ad){ // функция авторизации на ldap сервере (логин нужно передавать полный)
	        
			global $data_user;
							
			if(($ldap = ldap_connect($ad['server'], $ad['port'])) && serviceping($ad['server'],$ad['port'],1)){
			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3); //Включаем LDAP протокол версии 3
				$bind = @ldap_bind($ldap, $login, $password);
				if ($bind){
					$ls = ldap_search($ldap,$ad['search'],"(userPrincipalName=".$login.")", array("cn"));
					$zn = ldap_get_entries($ldap, $ls);
					if(isset($zn[0]['cn'][0])){
						$data_user['FIO'] = $zn[0]['cn'][0];
					}
					return 1;
				}
				else
					return 0;
			}
			else {
	        	$data_user['serverRequest'] = 'LDAP сервер временно недоступен.';
				return 0;
			}					
	  }
	  
  function normJsonStr($str){
    $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    //return($str);
	return iconv('cp1251', 'utf-8', $str);
}	  

function jsonRemoveUnicodeSequences($struct){
   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}
	  
		
  function utf8_json_encode($arr){
			return($result = preg_replace_callback(
	'/\\\u([0-9a-fA-F]{4})/', create_function('$_m', 'return mb_convert_encoding("&#" . intval($_m[1], 16) . ";", "UTF-8", "HTML-ENTITIES");'),
	json_encode($arr)));
		}	
		
		
		function json_encode_cyr($str) {
    $arr_replace_utf = array('\u0410', '\u0430', '\u0411', '\u0431', '\u0412', '\u0432',
        '\u0413', '\u0433', '\u0414', '\u0434', '\u0415', '\u0435', '\u0401', '\u0451', '\u0416',
        '\u0436', '\u0417', '\u0437', '\u0418', '\u0438', '\u0419', '\u0439', '\u041a', '\u043a',
        '\u041b', '\u043b', '\u041c', '\u043c', '\u041d', '\u043d', '\u041e', '\u043e', '\u041f',
        '\u043f', '\u0420', '\u0440', '\u0421', '\u0441', '\u0422', '\u0442', '\u0423', '\u0443',
        '\u0424', '\u0444', '\u0425', '\u0445', '\u0426', '\u0446', '\u0427', '\u0447', '\u0428',
        '\u0448', '\u0429', '\u0449', '\u042a', '\u044a', '\u042b', '\u044b', '\u042c', '\u044c',
        '\u042d', '\u044d', '\u042e', '\u044e', '\u042f', '\u044f', '\u2013', '\u2116');
    $arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
        'Ё', 'ё', 'Ж', 'ж', 'З', 'з', 'И', 'и', 'Й', 'й', 'К', 'к', 'Л', 'л', 'М', 'м', 'Н', 'н', 'О', 'о',
        'П', 'п', 'Р', 'р', 'С', 'с', 'Т', 'т', 'У', 'у', 'Ф', 'ф', 'Х', 'х', 'Ц', 'ц', 'Ч', 'ч', 'Ш', 'ш',
        'Щ', 'щ', 'Ъ', 'ъ', 'Ы', 'ы', 'Ь', 'ь', 'Э', 'э', 'Ю', 'ю', 'Я', 'я', '-', '№');
    $str1 = json_encode($str);
    $str2 = str_replace($arr_replace_utf, $arr_replace_cyr, $str1);
    return $str2;
		}
				
?>