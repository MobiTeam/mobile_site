<?php


   require_once('database_connect.php');
   
	if (is_null($ID)){
      	$sql="Select * from news 
    where ID<=(Select MAX(ID) from news) and ID>=(Select MAX(ID) from news)-10";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	while(OCIFetch($s)){
		$ID = ociresult($s,'ID'); //ID �������
		$NAME_NEWS = ociresult($s,'NAME_NEWS'); //ID �������
		$DATE_NEWS = ociresult($s,'DATE_NEWS'); //���� �������
		$TEXT_NEWS = ociresult($s,'TEXT_NEWS'); //����� �������
		$TEXT_NEWS2 = ociresult($s,'TEXT_NEWS2'); //����� �������2
		$TEXT_NEWS3 = ociresult($s,'TEXT_NEWS3'); //����� �������3
		$TEXT_NEWS4 = ociresult($s,'TEXT_NEWS4'); //����� �������4
		$PREV_IMG_NEWS = ociresult($s,'PREV_IMG_NEWS'); //pre image �������
	}
		OCICommit($c); 
	else
	{
		$sql="Select * from news 
    where ID<=".$ID." and ID>=".$ID."-10 ";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	while(OCIFetch($s)){
		$ID = ociresult($s,'ID'); //ID �������
		$NAME_NEWS = ociresult($s,'NAME_NEWS'); //ID �������
		$DATE_NEWS = ociresult($s,'DATE_NEWS'); //���� �������
		$TEXT_NEWS = ociresult($s,'TEXT_NEWS'); //����� �������
		$TEXT_NEWS2 = ociresult($s,'TEXT_NEWS2'); //����� �������2
		$TEXT_NEWS3 = ociresult($s,'TEXT_NEWS3'); //����� �������3
		$TEXT_NEWS4 = ociresult($s,'TEXT_NEWS4'); //����� �������4
		$PREV_IMG_NEWS = ociresult($s,'PREV_IMG_NEWS'); //pre image �������
	}
		OCICommit($c); 	
?>