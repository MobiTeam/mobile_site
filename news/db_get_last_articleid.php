<?php
   
    require_once('../oracle/database_connect.php');
    
	$sql = "select MAX(id) AS NUM from " . $table_tag . "";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT); 
	
	while(OCIFetch($s)){
		$num = ociresult($s,'NUM');		
	}

	if(!isset($num) || $num == " ") $num = 0;
	
	OCICommit($c); 

	
	

?>