<?php

 require_once('database_connect.php');
 
 
 // ����� �� ��������� ��������
 	$sql="Select * from V_STUD_DOL 
    where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	
	while(OCIFetch($s)){
		$NUMDOG = ociresult($s,'NUMDOG'); //����� ��������	
		$Ostatok_LA = ociresult($s,'OSTATOK_LA'); //������� �� ����� ������	
		$Nachisl = ociresult($s,'NACHISL'); //���������
		$Oplata = ociresult($s,'OPLATA'); //��������
		$Ostatok = ociresult($s,'OSTATOK'); //�������
		$Date = ociresult($s,'DAT'); //���� ����������	
	}
	OCICommit($c); 
	
	
	//����� �� �������� ��������
	$sql = "Select * from V_STUD_EDUCATION
	where instr(
    upper(replace(replace(FIO,'.',''),' ','')),
    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	
	
	while(OCIFetch($s)){
		$Ostatok_LA = ociresult($s,'OSTATOK_LA'); //������� �� ����� ������	
		$Nachisl = ociresult($s,'NACHISL'); //���������
		$Oplata = ociresult($s,'OPLATA'); //��������
		$Ostatok = ociresult($s,'OSTATOK'); //�������
		$Date = ociresult($s,'DAT'); //���� ����������	
	}
	
	
	
	OCICommit($c); 
?>