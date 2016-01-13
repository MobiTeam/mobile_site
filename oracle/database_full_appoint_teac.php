<?php

  	session_start(); 
	require_once('../auth/ad_functions.php');
	userAutentificate();
	if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}
	
	require_once('database_connect.php');
   
   //Полное назначение преподавателя
   
   $sql="Select * from V_TEACH_APPOINT_ALL 
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$appoint_teac_json = array();
		$count = 0;		
				
		while(OCIFetch($s)){
			
			$appoint_teac_json[$count] = array(
									// "fio" => ociresult($s,'FIO'), 
									"Inst" => ociresult($s,'INSTITUTE'), 
									"Post" => ociresult($s,'POST'), 
									"Rate" => (double) str_replace(",",".", ociresult($s,'RATE')),  
									"Prizn" => ociresult($s,'PRIZN'), 
									"Bud" => ociresult($s,'BUDGET'), 
									// "Tarif" =>(double) str_replace(",",".",ociresult($s,'TARIF')), 
									"Ncat" => ociresult($s,'CATEGORY'), 
									"Reg" => ociresult($s,'DATEREG'), 
									"Sex" => ociresult($s,'SEX'), 
									// "Born" => ociresult($s,'BORNDATE'), 
									// "Category" => ociresult($s,'NAIKAT') 
								);
	
			$count++;
		} 
		
	print_r(json_encode_cyr($appoint_teac_json));
   
 ?>