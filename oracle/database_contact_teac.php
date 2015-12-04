<?php

    require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
	
      $caf=$_POST[''];	


	$sql="Select * from v_teac_caf
where instr (
        upper(replace(replace(prof,'',''),' ','')),
        upper(replace(replace('".$caf."','.',''),' ','')),1)>=1";
		

   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$contact_teac_json = array();
		$count=0
				
		while(OCIFetch($s)){
			
			$contact_teac_json = array(
									"fio" => ociresult($s,'FIO'), 
									"phone" => ociresult($s,'PHONE'), 
									"korp" => ociresult($s,'KORP'), 
									"phone" => ociresult($s,'PODR'), 
									"dol" => ociresult($s,'DOL'), 
									"rukovoditel" => ociresult($s,'RUK')
								);
	
			$count++;
		} 
		
		
	print_r(utf8_json_encode($contact_teac_json));

?>