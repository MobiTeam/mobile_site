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
 	
	$onekafedra_json = array();

 		
		 //Студенты в группе
	 	$sql = "
        Select * from mv_teac_contact
        where PODR in(Select PODR from mv_teac_contact  
                    where    instr (
                    upper(replace(replace(FIO,'',''),' ','')),
                    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1 )
					order by PODR,FIO";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$onekafedra_json = array();
		$count=0;
				
		while(OCIFetch($s)){
			
			$onekafedra_json[$count] = array(
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
		
		
	print_r(json_encode_cyr($onekafedra_json));
?>
