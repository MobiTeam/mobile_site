<?php 
   
   require_once('database_connect.php');
   
   switch($data_user["is_student"]){
	   case "0":
	   $sql = "select FIO
			  from MV_TEACH_APPOINT
			 where instr(upper(replace(replace(FIO,'.',''),' ','')),
				upper(replace(replace('".$data_user['FIO']."','.',''),' ','')),
					1)=1";
			  
	   $s = OCIParse($c,$sql);
	   OCIExecute($s, OCI_DEFAULT);
	   ocifetchstatement($s, $data_stud_arr);
	   $data_user['FIO'] = mb_convert_case($data_stud_arr['FIO'][0],MB_CASE_TITLE,'UTF-8');
	   break;
	   case "1":
	   $sql = "select FFIO, GRUP
			  from MV_STUD_APPOINT
			 where instr(upper(replace(replace(FFIO,'.',''),' ','')),
				upper(replace(replace('".$data_user['FIO']."','.',''),' ','')),
					1)=1";
			  
	   $s = OCIParse($c,$sql);
	   OCIExecute($s, OCI_DEFAULT);
	   ocifetchstatement($s, $data_stud_arr);
	   $data_user['FIO'] = $data_stud_arr['FFIO'][0];
	   $data_user['groups'] = $data_stud_arr['GRUP'];
	   break;
   }
   
    OCICommit($c);  		
			
 
?>