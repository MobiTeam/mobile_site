<?php 
   
   session_start();
   require_once('database_connect.php');
      
   $data_user['FIO'] = mb_strtoupper(str_replace(".", "", $data_user['FIO']), 'UTF-8'); 
  
   $is_correct = false;
   $cnt = 0;

   while(!$is_correct && $cnt < 300){


   	   switch($data_user["is_student"]) {
		   case "0":
		   $sql = "select FIO
				  from teach_appoint_clone
				 where upper(FIO) like '%" . $data_user['FIO'] . "%'";
				  
		   $s = OCIParse($c,$sql);
		   if(@OCIExecute($s, OCI_DEFAULT)){
		   		ocifetchstatement($s, $data_stud_arr);
		   		$is_correct = true;
		   }		   
		  
		   break;

		   case "1":
		   $sql = "select FFIO, GRUP
				  from stud_appoint_clone
				  where upper(FFIO) like '%" . $data_user['FIO'] . "%'";
				  
		   $s = OCIParse($c,$sql);
		    
		    if(@OCIExecute($s, OCI_DEFAULT)){
		    	 ocifetchstatement($s, $data_stud_arr);
  			     $data_user['FIO'] = $data_stud_arr['FFIO'][0];
				 $data_user['groups'] = $data_stud_arr['GRUP'];
				 $is_correct = true;
		    }
		   
		  
		   break;
   
   		}

   		$cnt++;
   		sleep(1);
   }	

   
   $data_user['hash'] = strrev(sha1(strrev(md5(strrev($data_user['FIO'])))));

   $_SESSION['FIO'] = $data_user['FIO'];
   $_SESSION['groups'] = $data_user['groups'];
   
    OCICommit($c);  		
			
 
?>