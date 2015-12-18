<?php

  session_start(); 
	require_once('../auth/ad_functions.php');
	userAutentificate();
	if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}
	
	require_once('database_connect.php');
   
   //$FFIO=$_POST[''];
   // $GRUP=$_POST['']; // не используем, по необходимости подключить ниже к запросу и передавать

	//$FFIO = "Ермак Александр";

   //Полное назначение студента
	$sql="Select * from v_stud_appoint_all ap  
where instr(
        upper(replace(replace(ap.FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";

    //	and ap.grup like '%\'".$GRUP."\'%' ";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$appoint_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$appoint_json[$count] = array(
									"Tabnmb" => ociresult($s,'FTABNMB'), 
									"Sex" => ociresult($s,'FSEX'), 
									"course" => ociresult($s,'FCOURSE'), 
									"date_zach" => ociresult($s,'ZACH'), 
									"Faculty" => ociresult($s,'FAK'), 
									"Spec" => ociresult($s,'SPEC'), 
									"Post" => ociresult($s,'FSPOST'), 
									"Grup" => ociresult($s,'GRUP'), 
									"Bud_name" => ociresult($s,'FSFINSOURCENAME'), 
									"Bud" => ociresult($s,'BUD'), 
									"Degree" => ociresult($s,'FSDEGREE')
								);
			$count++;	
			
		} 
		
	print_r(json_encode_cyr($appoint_json));
?>