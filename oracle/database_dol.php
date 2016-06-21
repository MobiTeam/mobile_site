<?php


 //ИНФОРМАЦИЯ ПО ДОЛГАМ СОТРУДНИКОВ И СТУДЕНТОВ () ОТКЛЮЧЕНА БЕЗ PDO

 session_start();
  require_once('../auth/ad_functions.php');
 modifyPost();
 
 userAutentificate();
 


 if(isset($_SESSION['FIO'])){
	$FFIO = $_SESSION['FIO'];
 } else {
	$FFIO = $_POST['FIO'];
 }
 
require('database_connect.php');
 
 // Долги за общежития студента(1)
 	$sql="Select * from MV_STUD_DOL 
    where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		
		$Dol_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"type" => 'Долг за общежитие',
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => (double)str_replace(",",".", ociresult($s,'OSTATOK_LA')), 
									"Nachisl" => (double) str_replace(",",".",ociresult($s,'NACHISL')), 
									"Oplata" => (double) str_replace(",",".",ociresult($s,'OPLATA')),  
									"Ostatok" => (double) str_replace(",",".",ociresult($s,'OSTATOK')),  
									"Date" => ociresult($s,'DAT'),
									"prizn"=>'1'

								);
			$count ++;
		
		}

		
	//Долги за обучения студента(2)
	$sql = "Select * from MV_STUD_EDUCATION
	where instr(
    upper(replace(replace(FIO,'.',''),' ','')),
    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
				
				
				while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"type" => 'Долг за обучение',
									"Numdog" => ociresult($s,'КОД'),	
									"Ostatok_LA" => (double)str_replace(",",".", ociresult($s,'OSTATOK_LA')), 
									"Nachisl" => (double) str_replace(",",".",ociresult($s,'NACHISL')), 
									"Oplata" => (double) str_replace(",",".",ociresult($s,'OPLATA')), 
									"Ostatok" =>(double) str_replace(",",".",ociresult($s,'OSTATOK')),  
									"Date" => ociresult($s,'DAT'),
									"prizn"=>'2' 

								);
			$count ++;
		
		}

		 ////////Долги за коттедж преподаватели и сотрудники(3)
   
     $sql="Select * from mv_teac_kott
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	

				
		while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"type" => 'Долг за найм жил. помещений',
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => (double)str_replace(",",".", ociresult($s,'OSTATOK_LA')), 
									"Nachisl" => (double) str_replace(",",".",ociresult($s,'NACHISL')), 
									"Oplata" => (double) str_replace(",",".",ociresult($s,'OPLATA')),  
									"Ostatok" => (double) str_replace(",",".",ociresult($s,'OSTATOK')), 
									"Date" => ociresult($s,'DAT'),
									"prizn"=>'3' 

								);
		$count++;
			
		}



////////////Долги за семейную комнату(4)

  $sql="Select * from mv_teac_room
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		// $dol_room_teac_json = array();
		// $count = 0;
				
		while(OCIFetch($s)){
			
			$Dol_json[$count] = array(
									"type" => 'Долг за личную комнату',
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => (double)str_replace(",",".", ociresult($s,'OSTATOK_LA')), 
									"Nachisl" => (double) str_replace(",",".",ociresult($s,'NACHISL')), 
									"Oplata" => (double) str_replace(",",".",ociresult($s,'OPLATA')),  
									"Ostatok" => (double) str_replace(",",".",ociresult($s,'OSTATOK')), 
									"Date" => ociresult($s,'DAT'),
									"prizn"=>'4'  

								);
			$count++;
			
		}
		

		print_r(json_encode_cyr($Dol_json));

	// Отключаемся от базы данных 
	oci_close($c); 
	
?>
