<?php

   require_once('database_connect.php');

	$sql="Select * from v_stud_appoint_all ap 
	where instr(
        upper(replace(replace(ap.FFIO,'.',''),' ','')),
        upper(replace(replace('".$FIO."','.',''),' ','')),1)>=1
        and ap.grup like '%\'".$GRUP."\'%'";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	 $appoint_json = array();
	
	
	while(OCIFetch($s)){
		$FIO = ociresult($s,'FFIO'); //ФИО		
		$Tabnmb = ociresult($s,'FTABNMB');	//Номер зачетки	
		$SEX = ociresult($s,'FSEX');  //ПОЛ	
		$Course= ociresult($s,'FCOURSE'); // Курс	
		$date_zach = ociresult($s,'ZACH');// Дата зачисления		
		$Fac = ociresult($s,'FAK'); //Институт		
		$Spec = ociresult($s,'SPEC');	//Специальность	
		$Post = ociresult($s,'FSPOST');		//Направление
		$Grup = ociresult($s,'GRUP');		// Группа
		$Bud_name = ociresult($s,'FSFINSOURCENAME');		//Бюджет
		$Bud = ociresult($s,'BUD');		//Бюджет сокращенно 
		$Degree = ociresult($s,'FSDEGREE');	//Степень	
	}
	
	OCICommit($c); 
?>