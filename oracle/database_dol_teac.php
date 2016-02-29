<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   modifyPost();
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

		print_r(json_encode_cyr($dol_kott_teac_json));

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
		
		
	print_r(json_encode_cyr($dol_room_teac_json));
 ?>