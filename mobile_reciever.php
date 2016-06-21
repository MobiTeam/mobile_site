<?php 
    
// АВТОРИЗАЦИЯ (UPDATE 17.05.2016)

	if(!isset($_POST['login'])) die('{"FIO":"undefined","serverRequest":"Перезагрузите страницу и повторите попытку авторизации."}');	
	
	if(isset($_POST['login'])){

		   require_once('auth/ad_settings.php');
		   require_once('auth/ad_functions.php');
		   require_once('auth/connecting_user.php');
		   require_once('oracle/database_connect_PDO.php');

		   modifyPost();
		    
		    $stmt=$conn->prepare("select 30 - (TO_CHAR(sysdate,'sssss') - TO_CHAR(DATE_INPUT,'sssss')) as LAST_TRYING from logs_users 
		    								where login = :login
		    								 and flag = 0 and DATE_INPUT > (sysdate - (30 / (24 * 60 * 60)))");
		    $stmt->execute(array('login' => $_POST['login'] ));

	while($row=$stmt->fetch()){
				$cnt = $row['LAST_TRYING'];		
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


								  require_once('oracle/database_connect_PDO.php');
   
								   $login = replaceQuotesOracle($clearLogin);
								   $pass = md5($_POST['password']);
									
								$query = $conn->prepare("select *
								             from T_USERS 
											 where login = :login
											   and pass =  :pass ");

								$query->execute(array('login' => $login,'pass' => $pass));

										$isset_in_base = false;

										while($row=$query->fetch()){
											


											$isset_in_base = true;
											$data_user['FIO'] = $row['FULL_NAME'];
											
											if($row['ID_USERGROUP'] == 1) {
												$data_user['is_student'] = '1';
											} else {
												$data_user['is_student'] = '0';
											}
											
											if($row['GROUP_NAME'] != -1) {
												$data_user['groups'] = array($row['GROUP_NAME']);												
											}	
										}
										
									if(!$isset_in_base) {
										$serverRequest = $err_message;
									} 							  

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


						  $stmt=$conn->prepare("INSERT into logs_users (LOGIN, DATE_INPUT, IP_ADRESS, FLAG)
						  					    values(:LOGINa, sysdate, :IP_ADRESSa, '0') ");
						  $stmt->execute(array('LOGINa' => $_POST['login'],'IP_ADRESSa' => $_SERVER["REMOTE_ADDR"]));

					  } else { 

						  $data_user['serverRequest'] = $succ_message;

						switch($data_user["is_student"]) {


//////////////////////////СОТРУДНИК					   
						   case "0":

							$query=$conn->prepare("select 
								cast(FIO AS VARCHAR2(512)) as FIO
							  from MV_TEACH_APPOINT_ALL
							 where instr(upper(replace(replace(FIO,'.',''),' ','')),
								upper(replace(replace(:FFIO,'.',''),' ','')),
									1)=1");							
							
	
				           if(!$conn) die('Все очень плохо');

						   if($query->execute(array('FFIO' => $data_user['FIO']))){
						   		$data_stud_arr=$query->fetchAll();	
						   		$data_user['FIO'] =  mb_convert_case($data_stud_arr[0]['FIO'],MB_CASE_TITLE,'UTF-8');
						   		$is_correct = true;
						   } else die('{"FIO":"undefined","serverRequest":"Сервер перегружен. Попробуйте зайти позже."}');		   
		
						   break;


//////////////////////////СТУДЕНТ	
						   case "1":

						   	$query=$conn->prepare("select
						    cast(FFIO AS VARCHAR2(512)) as FFIO,
						    cast(GRUP AS VARCHAR2(512)) as GRUP
							  from MV_STUD_APPOINT_ALL
							 where instr(upper(replace(replace(FFIO,'.',''),' ','')),
								upper(replace(replace(:FFIO,'.',''),' ','')),
									1)=1");	

							if(!$conn) die('Все очень плохо');

						   if($query->execute(array('FFIO' => $data_user['FIO']))){
						   		$data_stud_arr=$query->fetchAll();
						   		$data_user['groups'] = array();
				  			     $data_user['FIO'] = $data_stud_arr[0]['FFIO'];
				  			     	for ($i=0; $i <count($data_stud_arr) ; $i++) { 
				  			     		array_push($data_user['groups'],$data_stud_arr[$i]['GRUP']);
				  			     	}
							$is_correct = true;

						    } else die('{"FIO":"undefined","serverRequest":"Сервер перегружен. Попробуйте зайти позже."}');

						   break;
			   
				   		}

   	//////////////////////////ЗАНОСИМ ДАННЫЕ В СЕССИЮ
						   $data_user['hash'] = strrev(sha1(strrev(md5(strrev($data_user['FIO'])))));

						   $_SESSION['FIO'] = $data_user['FIO'];
						   $_SESSION['groups'] = $data_user['groups'];

						   $login = $clearLogin;
   $pass = md5($_POST['password']);
   $num_group = $data_user['is_student'] == '1' ? 1 : 2;   
	

	///////////////////////////В ТАБЛИЦУ УЧЕТА ПОСЕЩАЕМОСТИ
	$stmt=$conn->prepare("merge into T_USERS using dual on (LOGIN = :login and PASS=:pass)
					when not matched then
					INSERT (login,pass,id_usergroup,last_access,count,full_name) 
					                      values (:login,:pass,:num_group,SYSDATE,1,:data_user)
					when matched then 
					UPDATE SET id_usergroup=:num_group,last_access=sysdate,count=count+1,full_name=:data_user");

    $stmt->execute(array('login' => $login,'pass' => $pass,'num_group' => $num_group,'data_user' => $data_user['FIO']));					

	////////////////////////////////////////////////////
    $stmt=$conn->prepare("select ID from T_USERS where LOGIN = :login ");
	$stmt->execute(array('login' => $login));

	/////////////////////////////////ID usera дял выдачи сохранённых настроек
	while($row=$stmt->fetch()){
			$id_user = $row['ID'];					
		}
	
	if(isset($id_user)) {
	

		    $stmt=$conn->prepare("select CODE_SETTINGS, USER_SUBGROUP, DEFAULT_TMTB_QUERY, FORMULAR_ID from SETTINGS where ID_USER = :id_user");
			$stmt->execute(array('id_user' => $id_user));

		
	while($row=$stmt->fetch()){
			$data_user['settings'] = $row['CODE_SETTINGS'];	
			$data_user['subgroup'] = $row['USER_SUBGROUP'];
			$data_user['default_query'] = $row['DEFAULT_TMTB_QUERY'];
			$data_user['formular_id'] = $row['FORMULAR_ID'] != null ? $row['FORMULAR_ID'] : "";
			$data_user['id'] = $id_user;	
		}	
	}	

						  $stmt=$conn->prepare("insert into logs_users (LOGIN, DATE_INPUT, IP_ADRESS, FLAG) values(:LOGINa, sysdate, :IP_ADRESSa, '1')");
						  $stmt->execute(array('LOGINa' => $_POST['login'],'IP_ADRESSa' => $_SERVER["REMOTE_ADDR"]));

					  }

					  print_r(utf8_json_encode($data_user));
			  	
	}
	@$conn=null; 

?>