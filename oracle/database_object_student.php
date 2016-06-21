<?php


//ПОЛУЧЕНИЕ ПРЕДМЕТОВ СТУДЕНТА НА ТЕКУЩИЙ СЕМЕСТР (UPDATE 16.05.2016)

	session_start(); 
	require_once('../auth/ad_functions.php');
	modifyPost();
	userAutentificate();
	if(isset($_SESSION['groups'])){
		$GRUP = $_SESSION['groups'];
	} else {
		$GRUP = $_POST['groups'];
	}
	


	require('database_connect_PDO.php');
 	
	$object_json = array();
	$count = 0;
	for ($i=0; $i < count($GRUP); $i++) { 
 		
		 //Предметы группы на текущий семестр
		$query =$conn->prepare ("Select * from mv_stud_object
		where GR_NUM = :GRUP
		order by 2");
		
		$query->execute(array('GRUP' => $GRUP[$i]));

	while($row=$query->fetch()){
		$object_json[$count] = array(
				"group"=>$GRUP[$i],
				"Disclipline" => $row['DISCIPLINE'], 
				"Type" => str_replace('ы','',$row['TYPE_WORK']),
				"Semestr" => $row['SEMESTR'] 
				);
			$count ++;
		} 

	}			
		print_r(json_encode($object_json,JSON_UNESCAPED_UNICODE));
 @$conn=null;
?>