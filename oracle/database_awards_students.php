<?php

	require_once('database_connect.php');
 	require_once('../auth/ad_functions.php');
	
	
   // $FFIO=$_POST['FFIO'];
 	$FFIO='Якимчук А';
	
 //Стипендия студента
 $sql = "Select * from MV_STUD_AWARDS
		    where YEAR_AWARDS = '2013' and 
		     instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
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
									"Year"=>ociresult($s,'YEAR_AWARDS'), 
									"Itogo" => ociresult($s,'ITOGO')

								);
			$count ++;
		
		} 
	
	print_r(json_encode_cyr($awards_json));


?>