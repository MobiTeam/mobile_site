<?php

 	require_once('database_connect.php');
 	require_once('../auth/ad_functions.php');
		
	$query = $_POST['timetable_query']; 
	 
	$sql = "select TEAC_FIO, DISCIPLINE, GR_NUM, SUBGRUP, DATEZAN, 
	           DAYWEEK, PAIR, VID, AUD, KORP 
                 from v_timetable
				where teac_fio like '%" . $query . "%'
				   or teac_caf like '%" . $query . "%'
                     or gr_num like '%" . $query . "%'
                        or aud like '%" . $query . "%'
						order by DATEZAN, TEAC_FIO, GR_NUM, PAIR";
		 
	$s = OCIParse($c, $sql);
	OCIExecute($s, OCI_DEFAULT);
	
	$timetable_json = array();
	$counter = 0; 
 	while(OCIFetch($s)){
			
			$timetable_json[$counter] = array(
									"TEAC_FIO" => ociresult($s,'TEAC_FIO'), 
									"DISCIPLINE" => ociresult($s,'DISCIPLINE'), 
									"GR_NUM" => ociresult($s,'GR_NUM'), 
									"SUBGRUP" => ociresult($s,'SUBGRUP'), 
									"DATEZAN" => ociresult($s,'DATEZAN'), 
									"DAYWEEK" => ociresult($s,'DAYWEEK'), 
									"PAIR" => ociresult($s,'PAIR'),
									"VID" => ociresult($s,'AUD'),
									"KORP" => ociresult($s,'KORP')
								);
			$counter++;					
					
		}

	print_r(json_encode_cyr($timetable_json));			
		
 
?>