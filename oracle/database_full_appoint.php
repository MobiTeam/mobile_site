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
		$FIO = ociresult($s,'FFIO'); //���		
		$Tabnmb = ociresult($s,'FTABNMB');	//����� �������	
		$SEX = ociresult($s,'FSEX');  //���	
		$Course= ociresult($s,'FCOURSE'); // ����	
		$date_zach = ociresult($s,'ZACH');// ���� ����������		
		$Fac = ociresult($s,'FAK'); //��������		
		$Spec = ociresult($s,'SPEC');	//�������������	
		$Post = ociresult($s,'FSPOST');		//�����������
		$Grup = ociresult($s,'GRUP');		// ������
		$Bud_name = ociresult($s,'FSFINSOURCENAME');		//������
		$Bud = ociresult($s,'BUD');		//������ ���������� 
		$Degree = ociresult($s,'FSDEGREE');	//�������	
	}
	
	OCICommit($c); 
?>