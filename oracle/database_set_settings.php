<?php

//СОХРАНЕНИЕ НАСТРОЕК ПОЛЬЗОВАТЕЛЯ (UPDATE 17.05.2016)
   require('database_connect_PDO.php');
   require_once('../auth/ad_functions.php');
    modifyPost();
	
	 $ID=$_POST['id_user'];
	 $Code=$_POST['code'];
	 $SUB = $_POST['subgrp'];
	 $QUERY = $_POST['def_query'];
	 $FORMULAR = $_POST['formular_id'];	

	 foreach($_POST as $value){
	 	if(!valParametr($value)){
	 		die("Передано недопустимое значение.");
	 	}
	 }

	$stmt=$conn->prepare("update SETTINGS set 
				CODE_SETTINGS=:code,
				USER_SUBGROUP = :SUB,
				DEFAULT_TMTB_QUERY = :QUERY,
				FORMULAR_ID = :FORMULAR
				WHERE ID_USER=:id");

	$stmt->execute(array('code' => $Code,'id' => $ID,'SUB' => $SUB,'QUERY' => $QUERY,'FORMULAR' => $FORMULAR));
 @$conn=null;
?>