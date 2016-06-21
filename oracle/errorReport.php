<?php

	//логирование ошибок клиент-сайда (UPDATE 16.05.2016)

	session_start(); 
	require_once('../auth/ad_functions.php');
	modifyPost();
	
	require('database_connect_PDO.php');

$FFIO=$_POST['who'];
$ERROR = $_POST['e'];

	$query = $conn->prepare("Insert into errors_logs
					(FIO,ERROR,DATE_ERR)
					values(:FIO,:ERROR,sysdate)");

	$query->execute(array('FIO' => $FFIO,'ERROR' => $ERROR));
	@$conn=null;	
?>
