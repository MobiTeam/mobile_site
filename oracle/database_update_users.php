<?php 
   
   require_once('database_connect.php');
   modifyPost();
   $login = $clearLogin;
   $pass = md5($_POST['password']);
   $num_group = $data_user['is_student'] == '1' ? 1 : 2;   
	
   $sql = "merge into T_USERS using dual on (LOGIN = '".$login."' and PASS='".$pass."')
					when not matched then
					INSERT (login,pass,id_usergroup,last_access,count,full_name) 
					                      values ('".$login."','".$pass."','".$num_group."',SYSDATE,1,'".$data_user['FIO']."')
					when matched then 
					UPDATE SET id_usergroup='".$num_group."',last_access=sysdate,count=count+1,full_name='".$data_user['FIO']."'";
	
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	OCICommit($c); 

	$sql = "select ID from T_USERS where LOGIN = '" . $login . "'";
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	while(OCIFetch($s)){
			$id_user = ociresult($s,'ID');					
		}
	
	if(isset($id_user)) {
		$sql = "select CODE_SETTINGS, USER_SUBGROUP, DEFAULT_TMTB_QUERY, FORMULAR_ID from SETTINGS where ID_USER = " . $id_user . "";
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);	
		
		while(OCIFetch($s)){
			$data_user['settings'] = ociresult($s,'CODE_SETTINGS');	
			$data_user['subgroup'] = ociresult($s,'USER_SUBGROUP');
			$data_user['default_query'] = ociresult($s,'DEFAULT_TMTB_QUERY');
			$data_user['formular_id'] = ociresult($s,'FORMULAR_ID') != null ? ociresult($s,'FORMULAR_ID') : "";
			$data_user['id'] = $id_user;	
		}	
	}	
		
		
		
					
 
?>