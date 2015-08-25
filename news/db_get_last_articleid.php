<?php
   
    require_once('../oracle/database_connect.php');
    
	$sql = "select MAX(id) AS NUM from NEWS";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT); 
	
	while(OCIFetch($s)){
		$num = ociresult($s,'NUM');		
	}
	
	OCICommit($c); 

	

?>