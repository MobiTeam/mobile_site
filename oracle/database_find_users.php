<?php 
   
//ПОИСК ПОЛЬЗОВАТЕЛЯ(UPDATE 16.05.2016)
   // require_once('../auth/ad_functions.php');
   require('database_connect_PDO.php');
   
   $login = replaceQuotesOracle($clearLogin);
   $pass = md5($_POST['password']);
	
$query = $conn->prepare("select count(*) AS NUM 
             from T_USERS 
			 where login = :login
			   and pass =  :pass ");
$query->execute(array('login' => $login,'pass' => $pass));

		while($row=$query->fetch()){
		$num = $row['NUM'];		
	}
		
	if($num < 1){
		$serverRequest = $err_message;
	} else {	

		$query = $conn->prepare("select FULL_NAME, ID_USERGROUP 
             from T_USERS 
			 where login = '".$login."'
			   and pass = '".$pass."'");

		
	while($row=$query->fetch()){
			$data_user['FIO'] = $row['FULL_NAME'];
			$row['ID_USERGROUP'] == 1 ? $data_user['is_student'] = '1' : $data_user['is_student'] = '0';		
		}
		$data_user['serverRequest'] = $succ_message;
	}
	
   // @$conn=null;
?>