<?php 
	
	require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
	
	$query = mb_strtolower(trim(strval($_GET['term'])), 'UTF-8');
	
	$s = OCIParse($c, 'select * from info_timetable 
							   where LOWER(INFO) like \'%' . $query . '%\'');
	
	OCIExecute($s, OCI_DEFAULT);
	$arr = Array();
	$i=0;
	
	while (OCIFetch($s)){
	    $arr[$i] = ociresult($s, "INFO");
	    $i++;	 
	}
	
	print_r(json_encode_cyr($arr));	 

?>