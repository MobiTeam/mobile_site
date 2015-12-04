<?php

    require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
	
	
	$cafidra=$_POST[''];
   
   $sql="Select * from v_teac_caf
where instr (
        upper(replace(replace(prof,'',''),' ','')),
        upper(replace(replace('".$cafidra."','.',''),' ','')),1)>=1";
   
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$cafidra_teac_json = array();
		$count=0
				
		while(OCIFetch($s)){
			
			$cafidra_teac_json = array(
									"fio" => ociresult($s,'FIO'), 
									"podr" => ociresult($s,'PROF'), 
									"post" => ociresult($s,'FNAME')
								);
	
			$count++;
		} 
		
	print_r(utf8_json_encode($cafidra_teac_json));
   
   
   
 ?>