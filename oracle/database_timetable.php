<?php

 	require_once('database_connect.php');
 	require_once('../auth/ad_functions.php');
		
	$query = $_POST['timetable_query']; 
	 
	$sql = "select TEAC_FIO, DISCIPLINE, GR_NUM, SUBGRUP, TO_CHAR(DATEZAN, 'DD.MM.YYYY') datezan, 
               DAYWEEK, PAIR, VID, AUD, KORP 
                 from v_timetable
				where teac_fio like '%" . $query . "%'
				   or teac_caf like '%" . $query . "%'
                     or gr_num like '%" . $query . "%'
                        or aud like '%" . $query . "%'
						order by datezan, GR_NUM, PAIR, SUBGRUP, TEAC_FIO";
		 
	$s = OCIParse($c, $sql);
	OCIExecute($s, OCI_DEFAULT);
	
	$timetable_json = array();
	
	
	$num = 0;
	$counter = 0;
 	while(OCIFetch($s)){
			
			$new_num = str_replace('.', '', ociresult($s,'DATEZAN'));
			
			if($num != $new_num){
				$num = $new_num;
				$timetable_json[$num] = array();
				$counter = 0;
			}
			
			$timetable_json[$num][$counter] = array(
									"TEAC_FIO" => ociresult($s,'TEAC_FIO'), 
									"DISCIPLINE" => ociresult($s,'DISCIPLINE'), 
									"SUBGRUP" => ociresult($s,'SUBGRUP'), 
									"PAIR" => ociresult($s,'PAIR'),
									"AUD" => ociresult($s,'AUD'),
									"VID" => ociresult($s,'VID'),
									"KORP" => ociresult($s,'KORP')
								);
			
			$counter++;
								
					
		}

	print_r(json_encode_cyr($timetable_json));			
		
 
?>