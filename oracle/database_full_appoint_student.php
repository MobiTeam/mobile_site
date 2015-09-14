<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
   
   $FFIO=$_POST['FFIO'];
   $GRUP=$_POST['GRUP'];
   
   // $FFIO="Якимчук";
   // $GRUP="1521";
   
   //Полное назначение студента
	$sql="Select * from v_stud_appoint_all ap  
where instr(
        upper(replace(replace(ap.FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
    and ap.grup like '%\'".$GRUP."\'%' ";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$appoint_json = array();
	
				
		while(OCIFetch($s)){
			
			$appoint_json = array(
									"fio" => ociresult($s,'FFIO'), 
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
	
			
		} 
		
	print_r(utf8_json_encode($appoint_json));
?>