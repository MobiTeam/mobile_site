<?php
// РАСПИСАНИЕ ЗАНЯТИЙ (UPDATE 17.05.2016)

 	require('database_connect_PDO.php');
 	require_once('../auth/ad_functions.php');
	modifyPost();
	$query = $_POST['timetable_query']; 
	$date_timetable=$_POST['date_query'];

	if(preg_match('/\d/', $query) == 1){
		$isNameQuery = false;
	} else $isNameQuery = true;

	$stmt=$conn->prepare("select
						cast(TEAC_FIO AS VARCHAR2(512)) as TEAC_FIO,
						cast(DISCIPLINE AS VARCHAR2(512)) as DISCIPLINE,
						cast(GR_NUM AS VARCHAR2(512)) as GR_NUM,
						cast(SUBGRUP AS VARCHAR2(128)) as SUBGRUP,
						TO_CHAR(DATEZAN, 'DD.MM.YYYY') datezan,
						cast(DAYWEEK AS VARCHAR2(512)) as DAYWEEK,
						PAIR,
						cast(VID AS VARCHAR2(512)) as VID,
						cast(AUD AS VARCHAR2(512)) as AUD,
						cast(KORP AS VARCHAR2(512)) as KORP  
                 from v_timetable_all
				where (trunc(to_date(datezan)) >= trunc(TO_DATE(:datea,'DD.MM.YYYY'))
						and trunc(to_date(datezan)) <=trunc(TO_DATE(:datea,'DD.MM.YYYY'))+6) and 
				  (teac_fio = 	 :query	
				   or teac_caf = :query
                     or gr_num = :query
                        or aud||' '||korp = :query)
						order by datezan, PAIR, GR_NUM, SUBGRUP, TEAC_FIO");	

	$stmt->execute(array('query' => $query,'datea'=>$date_timetable));								

	
	$timetable_json = array();
	
	$num = 0;
	$counter = 0;
	while($row=$stmt->fetch()){
			
			$new_num = str_replace('.', '', $row['DATEZAN']);
			
			if($num != $new_num){
				$num = $new_num;
				$timetable_json[$num] = array();
				$counter = 0;
			}
			
			if($isNameQuery && $counter != 0 && $num_pair == $row['PAIR']){
				
				$prev_count = --$counter;
				$group_num = $timetable_json[$num][$prev_count]["GR_NUM"];
				
				$timetable_json[$num][$prev_count] = array(
									"TEAC_FIO" => 					$row['TEAC_FIO'], 
									"DISCIPLINE" => 				$row['DISCIPLINE'], 
									"SUBGRUP" => 					$row['SUBGRUP'], 
									"PAIR" =>						$row['PAIR'],
									"AUD" =>						$row['AUD'],
									"VID" =>						$row['VID'],
									"KORP" => 						$row['KORP'],
									"GR_NUM" => $group_num . ', ' . $row['GR_NUM']
								);
			} else { 
				$timetable_json[$num][$counter] = array(
									"TEAC_FIO" =>   $row['TEAC_FIO'], 
									"DISCIPLINE" => $row['DISCIPLINE'], 
									"SUBGRUP" =>	$row['SUBGRUP'], 
									"PAIR" => 		$row['PAIR'],
									"AUD" =>		$row['AUD'],
									"VID" =>		$row['VID'],
									"KORP" =>   	$row['KORP'],
									"GR_NUM" => 	$row['GR_NUM']
								);
								
				$num_pair = $row['PAIR'];				
			}
			 
						
			$counter++;
								
					
		}
	print_r(json_encode($timetable_json,JSON_UNESCAPED_UNICODE));	
 @$conn=null;
?>