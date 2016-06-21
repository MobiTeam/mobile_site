<?php 
	
	//АВТОЗАПОЛНЕНИЕ ДЛЯ АБИТУРИЕНТОВ (UPDATE 21.06.2016) without PDO
	require('database_connect_PDO.php');

	$fio = mb_strtolower(trim(strval($_GET['term'])), 'UTF-8');

	$query = $conn->prepare("select *
							   from V_ABITURIENT_PRIORITY
							  where replace(lower(FIO),'ё','е') 
							   like lower(:fio)");

	$query->execute(array("fio"   => "%" . $fio . "%"));
	

	echo json_encode($query->fetchAll(), JSON_UNESCAPED_UNICODE);
	
	// Отключаемся от базы данных 
 	$conn = null; 

?>