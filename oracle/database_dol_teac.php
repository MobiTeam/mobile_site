<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
      $FFIO=$_POST[''];
   
   ////////Долги за коттедж
   
     $sql="Select * from v_teac_kott
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$dol_kott_teac_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$dol_kott_teac_json = array(
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => ociresult($s,'OSTATOK_LA'), 
									"Nachisl" => ociresult($s,'NACHISL'), 
									"Oplata" => ociresult($s,'OPLATA'), 
									"Ostatok" => ociresult($s,'OSTATOK'), 
									"Date" => ociresult($s,'DAT')

								);
		$count++;
			
		}

////////////Долги за комнату

  $sql="Select * from v_teac_room
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$dol_room_teac_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$dol_room_teac_json = array(
									"Numdog" => ociresult($s,'NUMDOG'), 
									"Ostatok_LA" => ociresult($s,'OSTATOK_LA'), 
									"Nachisl" => ociresult($s,'NACHISL'), 
									"Oplata" => ociresult($s,'OPLATA'), 
									"Ostatok" => ociresult($s,'OSTATOK'), 
									"Date" => ociresult($s,'DAT'), 

								);
			$count++;
			
		}
		
		
	print_r(utf8_json_encode($dol_room_teac_json));
 ?>