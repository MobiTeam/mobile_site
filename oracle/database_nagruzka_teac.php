<?php


//ПОЛУЧЕНИЕ ИНФОРМАЦИИ ПО НАГРУЗКЕ ПРЕПОДАВАТЕЛЯ (UPDATE 16.05.2016)
   session_start();
   require_once('../auth/ad_functions.php');
   modifyPost();
   userAutentificate();

   if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
   } else {
		$FFIO = $_POST['FIO'];
   }

	

   $FFIO = preg_replace('#(.*)\s+(.).*\s+(.).*#usi', '$1 $2.$3.', $FFIO);
   
   require('database_connect_PDO.php');

   $sql="Select FWYEARED,SEZON,UD_FNAME,SG_FNAME,FWCOURSE,FISTUDCOUNT,sum(ITOG) as ITOG from v_teac_nagruzka
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
		group by FWYEARED,SEZON,UD_FNAME,SG_FNAME,FWCOURSE,FISTUDCOUNT
        order by 2 desc,5";
		
    $query=$conn->prepare("Select FWYEARED,SEZON,UD_FNAME,SG_FNAME,FWCOURSE,FISTUDCOUNT,sum(ITOG) as ITOG from v_teac_nagruzka
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace(:FIO,'.',''),' ','')),1)>=1
		group by FWYEARED,SEZON,UD_FNAME,SG_FNAME,FWCOURSE,FISTUDCOUNT
        order by 2 desc,5");

     $query->execute(array('FIO' => $FFIO));  

		$nagruzka_teac_json = array();
		$count=0;
	while($row=$query->fetch()){
			
			$nagruzka_teac_json[$count] = array(

									"Year" => $row['FWYEARED'], 
									"Sezon" => $row['SEZON'], 
									"Subj" => $row['UD_FNAME'], 
									"Group" => $row['SG_FNAME'], 
									"Course_gr" => $row['FWCOURSE'], 
									"Group_count" => $row['FISTUDCOUNT'], 
									"Itog" => $row['ITOG']

								);
	
			$count++;
		} 
		
	print_r(json_encode($nagruzka_teac_json,JSON_UNESCAPED_UNICODE));
 @$conn=null;
	
 ?>