<?php
	session_start(); 
	require_once('../auth/ad_functions.php');
	userAutentificate();
	if(isset($_SESSION['groups'])){
		$GRUP = $_SESSION['groups'];
	} else {
		$GRUP = $_POST['groups'];
	}
	
	require_once('database_connect.php');
 	
	$group_json = array();
	for ($i=0; $i < count($GRUP); $i++) { 
 		
		 //Студенты в группе
	 	$sql = "Select * from mv_stud_group
		where FSDEPCODE like '%".$GRUP[$i]."%'
		order by FFIO";
		
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);
			
		$count = 0;
 		$group = array();
 		$sex=array();
 		while(OCIFetch($s)){
 			$group[$count]=ociresult($s,'FFIO');
 			$sex[$count]=ociresult($s,'FSEX');
 			$number_group=ociresult($s,'FSDEPCODE');
			$count ++;
		} 

		$group_json[$i] = array(
			"fio" => $group, 
			"sex"=> $sex,
			"number" => $number_group
		);

	}			
		print_r(json_encode_cyr($group_json));
?>
