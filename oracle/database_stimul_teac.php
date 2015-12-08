<?php

   require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
      // $FFIO=$_POST[''];
	$FFIO='Бурлуцкий Вл';
   
//Стимулирующие ППС

     $sql="Select * from v_teac_stimul
		where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$stimul_teac_json = array();
		$count=0;
				
		while(OCIFetch($s)){
			
			$stimul_teac_json[$count] = array(
									"fio" => ociresult($s,'FIO'), 
									"summa" => ociresult($s,'SUMMA')
								);
			$count++;
	
			
		} 
		

//Стимулирующие прочего персонала

	$sql="Select * from v_teac_stimulpr
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";

   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$stimulpr_teac_json = array();
				
		while(OCIFetch($s)){
			
			$stimul_teac_json[$count] = array(
									"fio" => ociresult($s,'FFIO'), 
									"summa" => ociresult($s,'SUMMA')
								);
			$count++;	
			
		} 
		
		if($stimul_teac_json){
	print_r(json_encode_cyr($stimul_teac_json));
		}


 ?>