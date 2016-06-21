<?php 
	//АВТОЗАПОЛНЕНИЕ ДЛЯ СПРАВОЧНИКА (UPDATE 17.05.2016) without PDO
	require('database_connect.php');
	require_once('../auth/ad_functions.php');
	modifyGet();
	$query = mb_strtolower(trim(strval($_GET['term'])), 'UTF-8');
	
	$s = oci_parse($c, 'select * from v_info_directory
							   where LOWER(FIO) like \'%' . $query . '%\'');
	
	oci_execute($s);
	$arr = array();
	$i=0;
	
	while (oci_fetch($s)){
	    $arr[$i] = oci_result($s, "FIO");
	    $i++;	 
	}
	
	print_r(json_encode($arr,JSON_UNESCAPED_UNICODE)); 
// Отключаемся от базы данных 
 oci_close($c); 

?>