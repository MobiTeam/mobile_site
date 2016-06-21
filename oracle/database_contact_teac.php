<?php


//СПРАВОЧНАЯ ИНФОРМАЦИЯ О СОТРУДНИКАХ УНИВЕРСИТЕТА (UPDATE 16.05.2016)
    require('database_connect_PDO.php');
	require_once('../auth/ad_functions.php');
	modifyPost();
	
      $FFIO=$_POST['FIO'];	

	  $query=$conn->prepare("Select 
			cast(FIO AS VARCHAR2(100)) as FIO,
			cast(PHONE AS VARCHAR2(512)) as PHONE,
			cast(KORP AS VARCHAR2(200)) as KORP,
			cast(PODR AS VARCHAR2(255)) as PODR,
			cast(DOL AS VARCHAR2(255)) as DOL,
			cast(EMAIL AS VARCHAR2(512)) as EMAIL,
			cast(RUK AS VARCHAR2(512)) as RUK
	  	 from mv_teac_contact
where instr (
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace(:FFIO,'.',''),' ','')),1)>=1
       or
        instr (
        upper(replace(replace(PODR,'',''),' ','')),
        upper(replace(replace(:FFIO,'.',''),' ','')),1)>=1
        order by 1");

		$query->execute(array('FFIO' => $FFIO));

	
		$contact_teac_json = array();
		$count=0;
				
	while($row=$query->fetch()){
			
			$contact_teac_json[$count] = array(
									"fio" => 		$row['FIO'], 
									"phone" =>		$row['PHONE'], 
									"korp" =>		$row['KORP'], 
									"podr" => 		$row['PODR'], 
									"dol" => 		$row['DOL'],
									"email"=>		$row['EMAIL'],
									"rukovoditel" =>$row['RUK']
								);
			$count++;
		} 
		
		
	print_r(json_encode($contact_teac_json,JSON_UNESCAPED_UNICODE));

 @$conn=null;
?>