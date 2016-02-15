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
 	
	$object_json = array();
	$count = 0;
	for ($i=0; $i < count($GRUP); $i++) { 
 		
		 //Предметы группы на текущий семестр
	 	$sql = "Select * from mv_stud_object
		where GR_NUM = '".$GRUP[$i]."'
		order by 2";
		
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);
			
 		while(OCIFetch($s)){
		$object_json[$count] = array(
				"group"=>$GRUP[$i],
				"Disclipline" => ociresult($s,'DISCIPLINE'), 
				"Type" => str_replace('ы','',ociresult($s,'TYPE_WORK')),
				"Semestr" => ociresult($s,'SEMESTR') 
				);
			$count ++;
		} 

	}			
		print_r(json_encode_cyr($object_json));
?>