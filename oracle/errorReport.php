<?php

	//логирование ошибок клиент-сайда (UPDATE 16.05.2016)

	session_start(); 
	require_once('../auth/ad_functions.php');
	modifyPost();
	
	require('database_connect_PDO.php');

	$ERROR = $_GET['e'];

	$query = $conn->prepare("Insert into errors_logs
					(FIO,ERROR,DATE_ERR)
					values(:FIO,:ERROR,sysdate)");

	$query->execute(array('FIO' => 'тест','ERROR' => $ERROR));
	@$conn=null;	
?>
