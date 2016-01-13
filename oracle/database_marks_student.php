<?php

   session_start(); 
	require_once('../auth/ad_functions.php');
	userAutentificate();
	if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}

	if(isset($_SESSION['groups'])){
		$GRUP = $_SESSION['groups'];
	} else {
		$GRUP = $_POST['groups'];
	}

	require_once('database_connect.php');


	$marks=array();

	$FFIO='Ермак Александр Денисович';
	$GRUP=array('2231','4721б');

	for ($i=0; $i < count($GRUP); $i++) { 	


   $sql="Select * from v_stud_marks
where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
   		 and gr_name like '%".$GRUP[$i]."%'";

	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	$count = 0;
	$marks_json = array();

		while(OCIFetch($s)){
			
			$marks_json[$count] = array(
			
								"discipline" => ociresult($s,'DIS'),
								"group" => ociresult($s,'GR_NAME'),
								"zach" => ociresult($s,'ZACH'),
								"semestr" => ociresult($s,'SEMESTR'),
								"type" => ociresult($s,'TYPEWORK'),
								"mark" => ociresult($s,'FWMARK')
								);
			$count ++;
			
		} 
		$marks[$i]=$marks_json;

	}
		
	print_r(json_encode_cyr($marks));
   
   
?>