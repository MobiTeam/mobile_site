<?php
	session_start(); 
	require_once('../auth/ad_functions.php');
	userAutentificate();
	$GRUP = $_SESSION['groups'];
	require_once('database_connect.php');
 	
	
	 
    $group_json = array();
	for ($i=0; $i < count($GRUP); $i++) { 
 		
		 //Студенты в группе
	 	$sql = "Select * from v_stud_group
		where FSDEPCODE like '%".$GRUP[$i]."%'
		order by FFIO";
		
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);
			
		$count = 0;
 		$group = array();
 		while(OCIFetch($s)){
 			$group[$count]=ociresult($s,'FFIO');
 			$number_group=ociresult($s,'FSDEPCODE');
			$count ++;
		} 

		$group_json[$i] = array(
			"fio" => $group, 
			"number" => $number_group
		);

	}			
		print_r(json_encode_cyr($group_json));
?>
