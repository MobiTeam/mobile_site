<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
      $FFIO=$_POST[''];
   
     $sql="Select * from V_TEACH_APPOINT_ALL 
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$appoint_teac_json = array();
	
				
		while(OCIFetch($s)){
			
			$appoint_teac_json = array(
									"fio" => ociresult($s,'FFIO'), 
									"Inst" => ociresult($s,'INSTITUTE'), 
									"Post" => ociresult($s,'POST'), 
									"Rate" => ociresult($s,'RATE'), 
									"Prizn" => ociresult($s,'PRIZN'), 
									"Bud" => ociresult($s,'BUDGET'), 
									"Tarif" => ociresult($s,'TARIF'), 
									"Ncat" => ociresult($s,'CATEGORY'), 
									"Reg" => ociresult($s,'DATEREG'), 
									"Sex" => ociresult($s,'SEX'), 
									"Born" => ociresult($s,'BORNDATE'), 
									"Category" => ociresult($s,'NAIKAT'), 
								);
	
			
		} 
		
	print_r(utf8_json_encode($appoint_teac_json));
 ?>