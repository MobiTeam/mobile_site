<?php


//ПОЛУЧЕНИЕ ОТПУСКА СОТРУДНИКА (UPDATE 16.05.2016)

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

	$query=$conn->prepare("Select  FFIO,DOL,PODR,DATE_BEG,AMOUNT_DAY,DATE_END,LIGOT,SUMMA,CHILD from MV_TEACH_HOLIDAY
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace(:FFIO,'.',''),' ','')),1)>=1
		ORDER BY DOL,DATE_BEG");

		$query->execute(array('FFIO' => $FFIO));	

		$holiday_teac_json = array();
		$count = 0;		
				
	while($row=$query->fetch()){
			
			$holiday_teac_json[$count] = array( 
									"FIO" => 	   $row['FFIO'], 
									"dol" =>	   $row['DOL'], 
									"podr" =>	   $row['PODR'],   
									"date_beg" =>  $row['DATE_BEG'], 
									"count_day" => $row['AMOUNT_DAY'], 
									"date_end" =>  $row['DATE_END'], 
									"ligot" => 	   $row['LIGOT'], 
									"summa" =>     $row['SUMMA'], 
									"child" => 	   $row['CHILD']
								);
	
			$count++;
		} 
		
	print_r(json_encode($holiday_teac_json,JSON_UNESCAPED_UNICODE));

 @$conn=null;
?>