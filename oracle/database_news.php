<?php


   require_once('database_connect.php');
   
	if (is_null($ID)){
      	$sql="Select * from news 
    where ID<=(Select MAX(ID) from news) and ID>=(Select MAX(ID) from news)-10";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	while(OCIFetch($s)){
		$ID = ociresult($s,'ID'); //ID новости
		$NAME_NEWS = ociresult($s,'NAME_NEWS'); //ID новости
		$DATE_NEWS = ociresult($s,'DATE_NEWS'); //Дата новости
		$TEXT_NEWS = ociresult($s,'TEXT_NEWS'); //Текст новости
		$TEXT_NEWS2 = ociresult($s,'TEXT_NEWS2'); //Текст новости2
		$TEXT_NEWS3 = ociresult($s,'TEXT_NEWS3'); //Текст новости3
		$TEXT_NEWS4 = ociresult($s,'TEXT_NEWS4'); //Текст новости4
		$PREV_IMG_NEWS = ociresult($s,'PREV_IMG_NEWS'); //pre image новости
	}
		OCICommit($c); 
	else
	{
		$sql="Select * from news 
    where ID<=".$ID." and ID>=".$ID."-10 ";
	
		$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT);
	while(OCIFetch($s)){
		$ID = ociresult($s,'ID'); //ID новости
		$NAME_NEWS = ociresult($s,'NAME_NEWS'); //ID новости
		$DATE_NEWS = ociresult($s,'DATE_NEWS'); //Дата новости
		$TEXT_NEWS = ociresult($s,'TEXT_NEWS'); //Текст новости
		$TEXT_NEWS2 = ociresult($s,'TEXT_NEWS2'); //Текст новости2
		$TEXT_NEWS3 = ociresult($s,'TEXT_NEWS3'); //Текст новости3
		$TEXT_NEWS4 = ociresult($s,'TEXT_NEWS4'); //Текст новости4
		$PREV_IMG_NEWS = ociresult($s,'PREV_IMG_NEWS'); //pre image новости
	}
		OCICommit($c); 	
?>