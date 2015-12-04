<?php

	require_once('database_connect.php');
 	require_once('../auth/ad_functions.php');
	
	
   $FFIO=$_POST['FFIO'];

	
 //Стипендия студента
 $sql = "Select * from V_STUD_AWARDS
		    where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);
	
	
		$awards_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$awards_json[$count] = array(
									"FNVIDOPL" => ociresult($s,'FNVIDOPL'), 
									"January" => ociresult($s,'JANUARY'), 
									"February" => ociresult($s,'FEBRUARY'), 
									"March" => ociresult($s,'MARCH'), 
									"April" => ociresult($s,'APRIL'), 
									"May" => ociresult($s,'MAY'), 
									"June" => ociresult($s,'JUNE'), 
									"July" => ociresult($s,'JULY'), 
									"August" => ociresult($s,'AUGUST'), 
									"September" => ociresult($s,'SEPTEMBER'), 
									"October" => ociresult($s,'OCTOBER'), 
									"November" => ociresult($s,'NOVEMBER'), 
									"December" => ociresult($s,'DECEMBER'), 
									"Itogo" => ociresult($s,'ITOGO')

								);
			$count ++;
		
		} 
	
	//print_r(utf8_json_encode($awards_json));


?>