<?php
	
//СТИПЕНДИЯ СТУДЕНТА (UPDATE 16.05.2016) ОТКЛЮЧЕНА

	session_start();
	require_once('../auth/ad_functions.php');
	modifyPost();
	userAutentificate();
		
	
	require('database_connect_PDO.php');

    if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}
 	
	 $query=$conn->prepare("Select * from MV_STUD_AWARDS
		    where
		     instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace(:FFIO,'.',''),' ','')),1)>=1 order by YEAR_AWARDS");

	$query->execute(array('FFIO' => $FFIO));


	$awards_json = array();
	$Year='';
	
	while($row=$query->fetch()){


		if($Year != $row['YEAR_AWARDS']){
			$Year = $row['YEAR_AWARDS'];
			$awards_json[$Year] = array();
			
		}


		for ($i=1; $i<=12; $i++) {
			
			if(!isset($awards_json[$Year][$i])){
				$awards_json[$Year][$i] = array("summ" => array(), "names" => array());
			}
			
			if($row['M'.$i.''] != "0"){
				array_push($awards_json[$Year][$i]["summ"],  $row['M'.$i.'']);
				array_push($awards_json[$Year][$i]["names"], $row['FNVIDOPL']);
			}			
	
		}
	}

	print_r(json_encode($awards_json,JSON_UNESCAPED_UNICODE));
	 @$conn=null;
?>