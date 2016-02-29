<?php
	
	session_start();
	require_once('../auth/ad_functions.php');
	modifyPost();
	userAutentificate();
		
	
	require_once('database_connect.php');

    if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}
 	
	
	 //Стипендия студента
	 $sql = "Select * from MV_STUD_AWARDS
		    where
		     instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1 order by YEAR_AWARDS";
		
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);

	$awards_json = array();
	$Year='';
	
	while(OCIFetch($s)){


		if($Year != ociresult($s,'YEAR_AWARDS')){
			$Year = ociresult($s,'YEAR_AWARDS');
			$awards_json[$Year] = array();
			
		}


		for ($i=1; $i<=12; $i++) {
			
			if(!isset($awards_json[$Year][$i])){
				$awards_json[$Year][$i] = array("summ" => array(), "names" => array());
			}
			
			if(ociresult($s,"M".$i."") != "0"){
				array_push($awards_json[$Year][$i]["summ"], ociresult($s,"M".$i.""));
				array_push($awards_json[$Year][$i]["names"], ociresult($s,"FNVIDOPL"));
			}			
	
		}
	}

print_r(json_encode_cyr($awards_json));
	
?>