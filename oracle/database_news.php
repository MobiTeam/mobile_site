﻿<?php

    require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
	
    if(isset($_POST['type'])){
		$type = $_POST['type'];
	} else {
		$type = 1;
	}
	
   /*  if (!isset($_POST['id_news'])){
			$sql="Select * from news 
						  where ID<=(Select MAX(ID) from news) and ID>=(Select MAX(ID) from news)-10
						  and source_news = " . $type ."
						  Order by ID DESC";
		} else {
			$sql="Select * from news 
						  where ID<=".$ID." and ID>=".$ID."-10 
						  and source_news = " . $type ."
						  Order by ID DESC";
		} */
		
		$sql="select * from (select * from news where source_news = " . $type . " order by ID desc) where rownum < 11";
	
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);
		
	    $news_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$news_json[$count] = array(
									"id" => ociresult($s,'ID'), 
									"name_news" => ociresult($s,'NAME_NEWS'), 
									"date" => ociresult($s,'DATE_NEWS'), 
									"text" => ociresult($s,'TEXT_NEWS').ociresult($s,'TEXT_NEWS2').ociresult($s,'TEXT_NEWS3').ociresult($s,'TEXT_NEWS4'), 
									"descr" => ociresult($s,'DESCRIPTION')
								);
			$count ++;
		
		} 
		
		print_r(json_encode_cyr($news_json));		
	
?>