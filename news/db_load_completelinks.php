<?php
   
    require_once('../oracle/database_connect.php');
    
	$sql = "select URL from CONTINUE_LINKS";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT); 
	ocifetchstatement($s, $data_links_arr);
	OCICommit($c); 

	

?>