<?php

//ПОЛУЧЕНИЕ ГРУППЫ СТУДЕНТА (UPDATE 16.05.2016)

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

	$group_json = array();
	for ($i=0; $i < count($GRUP); $i++) { 
 		
		 //Студенты в группе

		$GRUP[$i]="%$GRUP[$i]%";	

		$query=$conn->prepare("Select 
							  cast(FFIO AS VARCHAR2(100)) as FFIO,
							  cast(FSEX AS VARCHAR2(5)) as FSEX ,
							  cast(FSDEPCODE AS VARCHAR(100)) as FSDEPCODE 
							  from mv_stud_group
		where FSDEPCODE LIKE :GRUP
		order by FFIO");
		$query->execute(array('GRUP' => $GRUP[$i]));

		$count = 0;
 		$group = array();
 		$sex=array();

	while($row=$query->fetch()){
 			$group[$count]=$row['FFIO'];
 			$number_group=$row['FSDEPCODE'];
 			$sex[$count]=$row['FSEX'];
			$count++;
		} 

		$group_json[$i] = array(
			"fio" => $group, 
			"sex"=> $sex,
			"number" => $number_group
		);

	}			
		print_r(json_encode($group_json,JSON_UNESCAPED_UNICODE));

	 @$conn=null;	
?>
