<?php

    require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
   
    if (!isset($_POST['id_news'])){
			$sql="Select * from news 
						  where ID<=(Select MAX(ID) from news) and ID>=(Select MAX(ID) from news)-10
						  Order by ID DESC";
		} else {
			$sql="Select * from news 
						  where ID<=".$ID." and ID>=".$ID."-10 
						  Order by ID DESC";
		}
	
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