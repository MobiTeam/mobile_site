<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
      $FFIO=$_POST[''];


/////Отпуск преподавателя
     $sql="Select * from mv_teac_holiday 
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$holiday_teac_json = array();
		$count=0;
				
		while(OCIFetch($s)){
			
			$holiday_teac_json[$count] = array(
									"fio" => ociresult($s,'FFIO'), 
									"Vid" => ociresult($s,'VID'), 
									"Type" => ociresult($s,'TYPE_OTP'), 
									"Date_doc" => ociresult($s,'FDOCDATE'), 
									"Prikaz" => ociresult($s,'FFOUNDATION'), 
									"Date_beg" => ociresult($s,'FFACTYEARBEG'), 
									"Date_end" => ociresult($s,'FFACTYEAREND'), 
									"Duration" => ociresult($s,'FDURATION')
								);
	
			$count++;
		} 
		
	print_r(json_encode_cyr($holiday_teac_json));
 ?>