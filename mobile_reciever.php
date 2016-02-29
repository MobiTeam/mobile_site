<?php 
    
	if(isset($_POST['login'])){


		   require_once('auth/ad_settings.php');
		   require_once('auth/ad_functions.php');
		   require_once('auth/connecting_user.php');
		   require_once('oracle/database_connect.php');

		   modifyPost();

		    $sql = "select 30 - (TO_CHAR(sysdate,'sssss') - TO_CHAR(DATE_INPUT,'sssss')) as LAST_TRYING from logs_users where login = '" . $_POST['login'] . "' and flag = 0 and DATE_INPUT > (sysdate - (30 / (24 * 60 * 60)))";
		    $s = OCIParse($c,$sql);
		    OCIExecute($s, OCI_DEFAULT); 

		    while(OCIFetch($s)){
				$cnt = ociresult($s,'LAST_TRYING');		
			}

			if(isset($cnt)){
				
				$data_user['FIO'] = 'undefined';	
			  	$data_user['is_student'] = 'undefined';	
			  	$data_user['serverRequest'] = 'Превышено число запросов. Повторная попытка ввода возможна через ' . $cnt . ' ' . GetWordForm($cnt, array('секунду', 'секунды', 'секунд')) . '.';

				die(utf8_json_encode($data_user));
			} 

		    $err_message = 'Ошибка авторизации: Неправильные логин или пароль';
			$data_message = 'Ошибка передачи авторизационных данных';
			$succ_message = 'Успешная авторизация';
			
			
			if (isset($_POST['password']) && (strlen($_POST['password'])>=1)){
				
						$clearLogin = strtolower($_POST['login']);
					
						if(($pos = strpos($clearLogin,"/")) === false){
						 } else {
						   $clearLogin = substr($clearLogin,$pos+1,strlen($clearLogin)-$pos);	
						} 								
						if(($pos = strpos($clearLogin,"@")) === false){											
							} else {
						   $clearLogin = substr($clearLogin,0,$pos);
						}	
						
						
						   if ((auth($clearLogin."@".$ad_ugrasu['domain'], $_POST['password'], $ad_ugrasu)==0)){
							   if(auth($clearLogin."@".$ad_edu['domain'], $_POST['password'], $ad_edu)==0){
								  require_once('oracle/database_find_users.php');
							  } else {
								 $data_user['is_student'] = '1';	
							  }					   
						   } else {
							   
						   }					
											
					} else $serverRequest = $data_message;

						//echo $data_user['serverRequest'];

					  if(isset($serverRequest) && ($data_user['serverRequest'] == 'default')){
						  $data_user['FIO'] = 'undefined';	
						  $data_user['is_student'] = 'undefined';	
						  $data_user['serverRequest'] = $serverRequest;

						  $sql = "insert into logs_users (LOGIN, DATE_INPUT, IP_ADRESS, FLAG) values('" . $_POST['login'] . "', sysdate, '" . $_SERVER["REMOTE_ADDR"] . "', '0')";
						  $s = OCIParse($c,$sql);
						  OCIExecute($s, OCI_DEFAULT); 
						  OCICommit($c); 	

					  } else { // if ($data_user['serverRequest'] == 'default')
						  $data_user['serverRequest'] = $succ_message;
						  require_once('oracle/database_get_fullfio.php');				  
						  require_once('oracle/database_update_users.php');	

						  $sql = "insert into logs_users (LOGIN, DATE_INPUT, IP_ADRESS, FLAG) values('" . $_POST['login'] . "', sysdate, '" . $_SERVER["REMOTE_ADDR"] . "', '1')";
						  $s = OCIParse($c,$sql);
						  OCIExecute($s, OCI_DEFAULT); 
						  OCICommit($c); 

					  }

					  print_r(utf8_json_encode($data_user));
			  	
	} 

?>