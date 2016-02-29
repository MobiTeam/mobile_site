<?php

    require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
	
	modifyPost();
	
      $FFIO=$_POST['FIO'];	
	
	  $sql="Select * from mv_teac_contact
where instr (
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
       or
        instr (
        upper(replace(replace(PODR,'',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
        order by 1";
		

   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$contact_teac_json = array();
		$count=0;
				
		while(OCIFetch($s)){
			
			$contact_teac_json[$count] = array(
									"fio" => ociresult($s,'FIO'), 
									"phone" => ociresult($s,'PHONE'), 
									"korp" => ociresult($s,'KORP'), 
									"podr" => ociresult($s,'PODR'), 
									"dol" => ociresult($s,'DOL'),
									"email"=>ociresult($s,'EMAIL'),
									"rukovoditel" => ociresult($s,'RUK')
								);
			$count++;
		} 
		
		
	print_r(json_encode_cyr($contact_teac_json));

?>