<?php

    session_start(); 
	require_once('../auth/ad_functions.php');
	modifyPost();
	userAutentificate();
	if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}

   require_once('database_connect.php');
   
  		$stimul_teac_json = array();
		$count=0;
// //Стимулирующие ППС

// 	 $sql="Select * from v_teac_stimul
// 		where instr(
// 	    upper(replace(replace(FIO,'.',''),' ','')),
// 	    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
		
//    $s = OCIParse($c,$sql);
// 	OCIExecute($s, OCI_DEFAULT);
	

				
// 		while(OCIFetch($s)){
			
// 			$stimul_teac_json[$count] = array(
// 									"name"=> 'Надбавки ППС',
// 									"ball" =>(double) str_replace(',','.',ociresult($s,'BALL')),//Балл
// 									"summa" =>(double) str_replace(',','.',ociresult($s,'SUMMA')),
// 									"type"=> '1'
// 								);
// 			$count++;
	
			
// 		} 
		

//Стимулирующие прочего персонала

	// $sql="Select * from v_teac_stimulpr
	// 	where instr(
 //        upper(replace(replace(FFIO,'.',''),' ','')),
 //        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";

 //   $s = OCIParse($c,$sql);
	// OCIExecute($s, OCI_DEFAULT);
	

				
	// 	while(OCIFetch($s)){
			
	// 		$stimul_teac_json[$count] = array(
	// 								"name"=> 'Стимулирующие выплаты',
	// 								"ball" => 100,//Баллы
	// 								"summa" =>(double) str_replace(',','.',ociresult($s,'SUMMA')),
	// 								"type"=> '2'
	// 							);
	// 		$count++;	
			
	// 	} 

		//Ставка и оклад сотрудников
	$sql="Select INITCAP(FIO),RATE,TARIF,POST from V_TEACH_APPOINT_ALL
        where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";

   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);

				
		while(OCIFetch($s)){
			
			$stimul_teac_json[$count] = array(
									"name"=> 'Заработная плата',
									"ball" => (double) str_replace(',', '.', ociresult($s,'RATE')) ,//Ставка
									"summa" => (double) str_replace(',', '.', ociresult($s,'TARIF')),
									"post"=> ociresult($s,'POST'),
									"type" => '3'
								);
			$count++;	
			
		} 


		
	print_r(json_encode_cyr($stimul_teac_json));



 ?>