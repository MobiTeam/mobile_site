<?php

 	require_once('database_connect.php');
 	require_once('../auth/ad_functions.php');
	modifyPost();
	$query = $_POST['timetable_query']; 
	/* $query = 'Владимиров Н.М.'; */
	if(preg_match('/\d/', $query) == 1){
		$isNameQuery = false;
	} else $isNameQuery = true;
		
	$sql = "select TEAC_FIO, DISCIPLINE, GR_NUM, SUBGRUP, TO_CHAR(DATEZAN, 'DD.MM.YYYY') datezan, 
               DAYWEEK, PAIR, VID, AUD, KORP 
                 from v_timetable_all
				where (trunc(to_date(datezan)) >= trunc(TO_DATE('" . $_POST['date_query'] . "','DD.MM.YYYY'))
						and trunc(to_date(datezan)) <=trunc(TO_DATE('" . $_POST['date_query'] . "','DD.MM.YYYY'))+6) and 
				  (teac_fio = '" . $query . "'
				   or teac_caf = '" . $query . "'
                     or gr_num = '" . $query . "'
                        or aud||' '||korp = '" . $query . "')
						order by datezan, PAIR, GR_NUM, SUBGRUP, TEAC_FIO";
		 
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
			
			if($isNameQuery && $counter != 0 && $num_pair == ociresult($s,'PAIR')){
				
				$prev_count = --$counter;
				$group_num = $timetable_json[$num][$prev_count]["GR_NUM"];
				
				$timetable_json[$num][$prev_count] = array(
									"TEAC_FIO" => ociresult($s,'TEAC_FIO'), 
									"DISCIPLINE" => ociresult($s,'DISCIPLINE'), 
									"SUBGRUP" => ociresult($s,'SUBGRUP'), 
									"PAIR" => ociresult($s,'PAIR'),
									"AUD" => ociresult($s,'AUD'),
									"VID" => ociresult($s,'VID'),
									"KORP" => ociresult($s,'KORP'),
									"GR_NUM" => $group_num . ', ' . ociresult($s,'GR_NUM')
								);
			} else { 
				$timetable_json[$num][$counter] = array(
									"TEAC_FIO" => ociresult($s,'TEAC_FIO'), 
									"DISCIPLINE" => ociresult($s,'DISCIPLINE'), 
									"SUBGRUP" => ociresult($s,'SUBGRUP'), 
									"PAIR" => ociresult($s,'PAIR'),
									"AUD" => ociresult($s,'AUD'),
									"VID" => ociresult($s,'VID'),
									"KORP" => ociresult($s,'KORP'),
									"GR_NUM" => ociresult($s,'GR_NUM')
								);
								
				$num_pair = ociresult($s,'PAIR');				
			}
			 
						
			$counter++;
								
					
		}

	print_r(json_encode_cyr($timetable_json));	
		
 
?>