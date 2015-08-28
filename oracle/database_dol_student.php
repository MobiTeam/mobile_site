<?php

 require_once('database_connect.php');
 
 
 // Долги за общежития студента
 	$sql="Select * from V_STUD_DOL 
    where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	
	while(OCIFetch($s)){
		$NUMDOG = ociresult($s,'NUMDOG'); //Номер договора	
		$Ostatok_LA = ociresult($s,'OSTATOK_LA'); //Остаток на конец месяца	
		$Nachisl = ociresult($s,'NACHISL'); //Начислено
		$Oplata = ociresult($s,'OPLATA'); //Оплачено
		$Ostatok = ociresult($s,'OSTATOK'); //Остаток
		$Date = ociresult($s,'DAT'); //Дата обновления	
	}
	OCICommit($c); 
	
	
	//Долги за обучения студента
	$sql = "Select * from V_STUD_EDUCATION
	where instr(
    upper(replace(replace(FIO,'.',''),' ','')),
    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	
	while(OCIFetch($s)){
		$Ostatok_LA = ociresult($s,'OSTATOK_LA'); //Остаток на конец месяца	
		$Nachisl = ociresult($s,'NACHISL'); //Начислено
		$Oplata = ociresult($s,'OPLATA'); //Оплачено
		$Ostatok = ociresult($s,'OSTATOK'); //Остаток
		$Date = ociresult($s,'DAT'); //Дата обновления	
	}
	
	
	
	OCICommit($c); 
?>