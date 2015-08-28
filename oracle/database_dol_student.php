<?php

 require_once('database_connect.php');
 	require_once('../auth/ad_functions.php');
 
    $FFIO=$_POST['FFIO'];
 
 // Долги за общежития студента
 	$sql="Select * from V_STUD_DOL 
    where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		
		$Dol_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => ociresult($s,'OSTATOK_LA'), 
									"Nachisl" => ociresult($s,'NACHISL'), 
									"Oplata" => ociresult($s,'OPLATA'), 
									"Ostatok" => ociresult($s,'OSTATOK'), 
									"Date" => ociresult($s,'DAT'), 


								);
			$count ++;
		
		}

	
	
	//Долги за обучения студента
	$sql = "Select * from V_STUD_EDUCATION
	where instr(
    upper(replace(replace(FIO,'.',''),' ','')),
    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$Dol_education_json = array();
		$count = 0;
				
				
				while(OCIFetch($s)){
			
			$Dol_education_json[$count] = array(
									"Ostatok_LA" => ociresult($s,'OSTATOK_LA'), 
									"Nachisl" => ociresult($s,'NACHISL'), 
									"Oplata" => ociresult($s,'OPLATA'), 
									"Ostatok" => ociresult($s,'OSTATOK'), 
									"Date" => ociresult($s,'DAT'), 


								);
			$count ++;
		
		}		
	
?>