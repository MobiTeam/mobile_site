<?php 
	
	require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
	
	$query = mb_strtolower(trim(strval($_GET['term'])), 'UTF-8');
	
	$s = OCIParse($c, 'select * from v_info_directory
							   where LOWER(FIO) like \'%' . $query . '%\'');
	
	OCIExecute($s, OCI_DEFAULT);
	$arr = Array();
	$i=0;
	
	while (OCIFetch($s)){
	    $arr[$i] = ociresult($s, "FIO");
	    $i++;	 
	}
	
	print_r(json_encode_cyr($arr));	 

?>