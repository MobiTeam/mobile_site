<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
      $FFIO=$_POST[''];
   
     $sql="Select * from v_teac_stimul
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$stimul_teac_json = array();
	
				
		while(OCIFetch($s)){
			
			$stimul_teac_json = array(
									"fio" => ociresult($s,'FFIO'), 
									"summa" => ociresult($s,'SUMMA'), 

								);
	
			
		} 
		
	print_r(utf8_json_encode($stimul_teac_json));
 ?>