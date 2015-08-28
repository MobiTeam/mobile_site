<?php 
    
	if(isset($_POST['login'])){
		
		   require_once('auth/ad_settings.php');
		   require_once('auth/ad_functions.php');
		   require_once('auth/connecting_user.php');
		   
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
					 
					  if(isset($serverRequest) && ($data_user['serverRequest'] == 'default')){
						  $data_user['FIO'] = 'undefined';	
						  $data_user['is_student'] = 'undefined';	
						  $data_user['serverRequest'] = $serverRequest;				  
					  } else if ($data_user['serverRequest'] == 'default'){
						  $data_user['serverRequest'] = $succ_message;
						  require_once('oracle/database_get_fullfio.php');				  
						  require_once('oracle/database_update_users.php');				  
					  }
								  
					  print_r(utf8_json_encode($data_user));
			  	
	} else if(isset($_POST['get_info'])){
		
		//require_once('');
		
	}

?>