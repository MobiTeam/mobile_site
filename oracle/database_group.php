<?php

 	require_once('database_connect.php');
 	require_once('../auth/ad_functions.php');
	
	 $GRUP=$_POST['GRUP'];
	 
	 
	 //Студенты в группе
	 $sql = "Select * from v_stud_group
		where FSDEPCODE like '".$GRUP."'";
		
			$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		
		$group_json = array();
		$count = 0;
 
 		while(OCIFetch($s)){
			
			$group_json[$count] = array(
									"fio" => ociresult($s,'FFIO'), 
									"group" => ociresult($s,'FSDEPCODE'), 

								);
			$count ++;
		
		} 
 

?>
