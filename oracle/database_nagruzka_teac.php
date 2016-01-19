<?php

   session_start();
   require_once('../auth/ad_functions.php');
   userAutentificate();

   if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
   } else {
		$FFIO = $_POST['FIO'];
   }
   
   require_once('database_connect.php');

   $sql="Select FWYEARED,SEZON,UD_FNAME,SG_FNAME,FWCOURSE,FISTUDCOUNT,sum(ITOG) as ITOG from v_teac_nagruzka
		where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
		group by FWYEARED,SEZON,UD_FNAME,SG_FNAME,FWCOURSE,FISTUDCOUNT
        order by 2 desc,5";
		
   $s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$nagruzka_teac_json = array();
		$count=0;
				
		while(OCIFetch($s)){
			
			$nagruzka_teac_json[$count] = array(
									// "fio" => ociresult($s,'FFIO'), 
									"Year" => ociresult($s,'FWYEARED'), 
									"Sezon" => ociresult($s,'SEZON'), 
									"Subj" => ociresult($s,'UD_FNAME'), 
									"Group" => ociresult($s,'SG_FNAME'), 
									"Course_gr" => ociresult($s,'FWCOURSE'), 
									"Group_count" => ociresult($s,'FISTUDCOUNT'), 
									"Itog" => ociresult($s,'ITOG')

								);
	
			$count++;
		} 
		
	print_r(json_encode_cyr($nagruzka_teac_json));
 ?>