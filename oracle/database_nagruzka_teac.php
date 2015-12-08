<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
      $FFIO=$_POST[''];

   
     $sql="Select * from v_teac_nagruzka
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$nagruzka_teac_json = array();
		$count=0;
				
		while(OCIFetch($s)){
			
			$nagruzka_teac_json[$count] = array(
									"fio" => ociresult($s,'FFIO'), 
									"Year" => ociresult($s,'FWYEARED'), 
									"Sezon" => ociresult($s,'SEZON'), 
									"Subj" => ociresult($s,'UD_FNAME'), 
									"Group" => ociresult($s,'SG_FNAME'), 
									"Course_gr" => ociresult($s,'FWCOURSE'), 
									"Group_count" => ociresult($s,'FISTUDCOUNT'), 
									"Itog" => ociresult($s,'ITOG')

								);
	
			$count++;
		} 
		
	print_r(json_encode_cyr($nagruzka_teac_json));
 ?>