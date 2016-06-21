<?php
//ПОЛНОЕ НАЗНАЧЕНИЕ ПРЕПОДАВАТЕЛЯ (UPDATE 16.05.2016)
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
   
   //Полное назначение преподавателя
   
   $query=$conn->prepare("Select
		INSTITUTE,
		POST,
		RATE,
		cast(PRIZN AS VARCHAR2(100)) as PRIZN,
		BUDGET,
		cast(CATEGORY AS VARCHAR2(100)) as CATEGORY,
		DATEREG,
		cast(SEX AS VARCHAR(100)) as SEX
    			from MV_TEACH_APPOINT_ALL 
				where instr(
		        upper(replace(replace(FIO,'.',''),' ','')),
		        upper(replace(replace(:FFIO,'.',''),' ','')),1)>=1");
		
		$query->execute(array('FFIO' => $FFIO));

		$appoint_teac_json = array();
		$count = 0;		
				
	while($row=$query->fetch()){
			
			$appoint_teac_json[$count] = array(

									"Inst" => $row['INSTITUTE'], 
									"Post" => $row['POST'], 
									"Rate" => (double) str_replace(",",".", $row['RATE']),  
									"Prizn" => $row['PRIZN'], 
									"Bud" => $row['BUDGET'], 
									"Ncat" => $row['CATEGORY'], 
									"Reg" => $row['DATEREG'], 
									"Sex" => $row['SEX'], 

								);
	
			$count++;
		} 
		
	print_r(json_encode($appoint_teac_json,JSON_UNESCAPED_UNICODE));
 @$conn=null;
   
 ?>