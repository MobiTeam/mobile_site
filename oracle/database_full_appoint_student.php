<?php

//ПОЛНОЕ НАЗНАЧЕНИ СТУДЕНТА (UPDATE 16.05.2016)

  session_start(); 
  require_once('../auth/ad_functions.php');
  modifyPost();	
	userAutentificate();
	if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}
	
	require('database_connect_PDO.php');
   

   //Полное назначение студента
$query=$conn->prepare("Select 
		cast(FTABNMB AS VARCHAR2(100)) as FTABNMB,
		cast(FSEX AS VARCHAR2(100)) as FSEX,
		cast(FCOURSE AS VARCHAR2(100)) as FCOURSE,
		ZACH,
		cast(FAK AS VARCHAR2(255)) as FAK,
		cast(SPEC AS VARCHAR2(255)) as SPEC,
		cast(FSPOST AS VARCHAR2(255)) as FSPOST,
		cast(GRUP AS VARCHAR2(200)) as GRUP,
		cast(FSFINSOURCENAME AS VARCHAR2(255)) as FSFINSOURCENAME,
		cast(BUD AS VARCHAR2(255)) as BUD,
		cast(FSDEGREE AS VARCHAR2(255)) as FSDEGREE
	 from MV_STUD_APPOINT_ALL ap  
	where instr(
        upper(replace(replace(ap.FFIO,'.',''),' ','')),
        upper(replace(replace(:FFIO,'.',''),' ','')),1)>=1");

$query->execute(array('FFIO' => $FFIO));

		$appoint_json = array();
		$count = 0;
	while($row=$query->fetch()){
			
			$appoint_json[$count] = array(
									"Tabnmb" => 	$row['FTABNMB'], 
									"Sex" => 		$row['FSEX'], 
									"course"    => 	$row['FCOURSE'], 
									"date_zach" => 	$row['ZACH'], 
									"Faculty" => 	$row['FAK'], 
									"Spec" => 		$row['SPEC'], 
									"Post" => 		$row['FSPOST'], 
									"Grup" => 		$row['GRUP'], 
									"Bud_name" => 	$row['FSFINSOURCENAME'], 
									"Bud" =>		$row['BUD'], 
									"Degree" => 	$row['FSDEGREE']
								);
			$count++;	
		} 
		
	print_r(json_encode($appoint_json,JSON_UNESCAPED_UNICODE));
 @$conn=null;
?>