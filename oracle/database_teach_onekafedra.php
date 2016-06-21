<?php

//ПОЛУЧЕНИЕ ИНФОРМАЦИИ ПО СОТРУДНИКАМ КОТОРЫЕ РАБОТАЮТ ВМЕСТЕ В ОДНОМ ОТДЕЛЕ ИЛИ КАФЕДРЕ (UPDATE 16.05.2016) НЕ РАБОТАЕТ
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
 	
	$onekafedra_json = array();

 		

 		 //СОТРУДНИКИ В ОТДЕЛЕ ИЛИ НА КАФЕДРЕ
	 	$query=$conn->prepare("
        Select DISTINCT PODR from mv_teac_contact
        where PODR in(Select DISTINCT PODR from mv_teac_contact  
                    where    instr (
                    upper(replace(replace(FIO,'',''),' ','')),
                    upper(replace(replace(:FIO,'.',''),' ','')),1)>=1 )
					order by PODR");

		$query->execute(array('FIO' => $FFIO));
		
		$uniq_podr=array();

		$onekafedra_json = array();
		$count=0;


while($row=$query->fetch()){
	array_push($uniq_podr,$row['PODR']);
	}

	array_unique($uniq_podr,SORT_LOCALE_STRING);


	for ($i=0; $i < count($uniq_podr); $i++) { 
		
			 	$query=$conn->prepare("
        Select * from mv_teac_contact
        where PODR in(Select DISTINCT PODR from mv_teac_contact  
                    where    instr (
                    upper(replace(replace(PODR,'',''),' ','')),
                    upper(replace(replace(:PODR,'.',''),' ','')),1)>=1 )
					order by PODR,FIO");

		$query->execute(array('PODR' => $uniq_podr[$i]));

	$count=0;
	$ffio_cafidra=array();
	$dol_cafidra=array();	

	while($row=$query->fetch()){

			$ffio_cafidra[$count]=$row['FIO'];
			$dol_cafidra[$count]=$row['DOL'];
			$cafidra=$row['PODR'];
		$count++;		
	}

	$onekafedra_json[$i]=array(
			"fio"=>$ffio_cafidra,
			"dol"=>$dol_cafidra,
			"cafidra"=>$cafidra
		);

}
	print_r(json_encode($onekafedra_json,JSON_UNESCAPED_UNICODE));

 @$conn=null;
				
	
?>
