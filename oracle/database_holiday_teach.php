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

$FFIO='Татаринцев Ярослав';

	$sql="Select  FFIO,DOL,PODR,DATE_BEG,AMOUNT_DAY,DATE_END,LIGOT,SUMMA,CHILD from MV_TEACH_HOLIDAY
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
		ORDER BY DOL,DATE_BEG";


    $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
		$holiday_teac_json = array();
		$count = 0;		
				
		while(OCIFetch($s)){
			
			$holiday_teac_json[$count] = array( 
									"FIO" => ociresult($s,'FFIO'), 
									"dol" => ociresult($s,'DOL'), 
									"podr" => ociresult($s,'PODR'),   
									"date_beg" => ociresult($s,'DATE_BEG'), 
									"count_day" => ociresult($s,'AMOUNT_DAY'), 
									"date_end" => ociresult($s,'DATE_END'), 
									"ligot" => ociresult($s,'LIGOT'), 
									"summa" => ociresult($s,'SUMMA'), 
									"child" => ociresult($s,'CHILD')
								);
	
			$count++;
		} 
		
	print_r(json_encode_cyr($holiday_teac_json));



?>