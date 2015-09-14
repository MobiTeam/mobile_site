<?php 
   
   require_once('database_connect.php');
   
   $login = $clearLogin;
   $pass = md5($_POST['password']);
   $num_group = $data_user['is_student'] == '1' ? 1 : 2;   
	
   $sql = "merge into USERS using dual on (LOGIN = '".$login."' and PASS='".$pass."')
					when not matched then
					INSERT (login,pass,id_usergroup,last_access,count,full_name) 
					                      values ('".$login."','".$pass."','".$num_group."',SYSDATE,1,'".$data_user['FIO']."')
					when matched then 
					UPDATE SET id_usergroup='".$num_group."',last_access=sysdate,count=count+1,full_name='".$data_user['FIO']."'";
	
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	OCICommit($c); 

	$sql = "select ID from USERS where LOGIN = '" . $login . "'";
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	while(OCIFetch($s)){
			$id_user = ociresult($s,'ID');					
		}
	
	if(isset($id_user)) {
		$sql = "select CODE_SETTINGS from SETTINGS where ID_USER = " . $id_user . "";
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);	
		
		while(OCIFetch($s)){
			$data_user['settings'] = ociresult($s,'CODE_SETTINGS');	
			$data_user['id'] = $id_user;	
		}	
	}	
		
		
		
					
 
?>