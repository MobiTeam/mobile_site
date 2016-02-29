<?php

	require_once('../auth/ad_functions.php');
	require_once('database_connect.php');
	modifyPost();
	$FFIO=$_POST['FIO'];
	$EMAIL=$_POST['E-mail'];
	$COMMENT = $_POST['Message_text'];

	if(valParametr($FFIO) && valParametr($EMAIL) && valParametr($COMMENT)){
		$s=OCIParse($c,"Insert into REVIEWS
					(FFIO,EMAIL,COMMENT_REV,DATE_REV)
					values('".$FFIO."','".$EMAIL."','".$COMMENT."',sysdate)");
			
		OCIExecute($s, OCI_DEFAULT);
		
	    OCICommit($c); 	
	} else {
		die("Введено недопустимое значение. Запись не была сохранена.");
	}


	

?>