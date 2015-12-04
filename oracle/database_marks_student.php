<?php

   require_once('database_connect.php');
   require_once('../auth/ad_functions.php');

   
   $FFIO=$_POST['FFIO'];
   $GRUP=$_POST['GRUP'];
   
   
   $sql="Select * from v_stud_marks
where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
    and gr_name like '%\'".$GRUP."\'%'";

	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
		$marks_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$appoint_json[$count] = array(
			
								"discipline" => ociresult($s,'DIS')
								"group" => ociresult($s,'GR_NAME')
								"zach" => ociresult($s,'ZACH')
								"semestr" => ociresult($s,'SEMESTR')
								"type" => ociresult($s,'TYPEWORK')
								"mark" => ociresult($s,'FWMARK')
								);
			$count ++;
			
		} 
		
	//print_r(utf8_json_encode($marks_json));
   
   
?>