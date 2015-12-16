
<?php

 require_once('database_connect.php');
 require_once('../auth/ad_functions.php');
 
    $FFIO=$_POST[''];
 	// $FFIO='Бурлуцкий';
 
 
 // Долги за общежития студента(1)
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
									"prizn"=>'1'

								);
			$count ++;
		
		}

		
		

	
	
	//Долги за обучения студента(2)
	$sql = "Select * from V_STUD_EDUCATION
	where instr(
    upper(replace(replace(FIO,'.',''),' ','')),
    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
				
				
				while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"Numdog" => ociresult($s,'КОД'),	
									"Ostatok_LA" => ociresult($s,'OSTATOK_LA'), 
									"Nachisl" => ociresult($s,'NACHISL'), 
									"Oplata" => ociresult($s,'OPLATA'), 
									"Ostatok" => ociresult($s,'OSTATOK'), 
									"Date" => ociresult($s,'DAT'),
									"prizn"=>'2' 

								);
			$count ++;
		
		}

		 ////////Долги за коттедж преподаватели и сотрудники(3)
   
     $sql="Select * from v_teac_kott
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	

				
		while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => ociresult($s,'OSTATOK_LA'), 
									"Nachisl" => ociresult($s,'NACHISL'), 
									"Oplata" => ociresult($s,'OPLATA'), 
									"Ostatok" => ociresult($s,'OSTATOK'), 
									"Date" => ociresult($s,'DAT'),
									"prizn"=>'3' 

								);
		$count++;
			
		}



////////////Долги за семейную комнату(4)

  $sql="Select * from v_teac_room
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		// $dol_room_teac_json = array();
		// $count = 0;
				
		while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => ociresult($s,'OSTATOK_LA'), 
									"Nachisl" => ociresult($s,'NACHISL'), 
									"Oplata" => ociresult($s,'OPLATA'), 
									"Ostatok" => ociresult($s,'OSTATOK'), 
									"Date" => ociresult($s,'DAT'),
									"prizn"=>'4'  

								);
			$count++;
			
		}
		

		print_r(json_encode_cyr($Dol_json));
	
?>
