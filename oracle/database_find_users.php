<?php 
   
   require_once('database_connect.php');
   
   $login = $clearLogin;
   $pass = md5($_POST['password']);
   
   $sql = "select count(*) AS NUM 
             from USERS 
			 where login = '".$login."'
			   and pass = '".$pass."'";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	while(OCIFetch($s)){
		$num = ociresult($s,'NUM');		
	}
		
	if($num < 1){
		$serverRequest = $err_message;
	} else {		
		$sql = "select FULL_NAME, ID_USERGROUP 
             from USERS 
			 where login = '".$login."'
			   and pass = '".$pass."'";
		
		$s = OCIParse($c,$sql);
	    OCIExecute($s, OCI_DEFAULT);
		
		while(OCIFetch($s)){
			$data_user['FIO'] = ociresult($s,'FULL_NAME');
			ociresult($s,'ID_USERGROUP') == 1 ? $data_user['is_student'] = '1' : $data_user['is_student'] = '0';		
		}
		$data_user['serverRequest'] = $succ_message;
		
	}
			
	OCICommit($c);  		
  
?>