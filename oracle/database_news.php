<?php

    require_once('database_connect.php');
	require_once('../auth/ad_functions.php');
	
	if(isset($_POST['news_id'])){
		
		$sql="select * from news where id = ".$_POST['news_id']."";
		
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);
		
		$news_json = '';
		
		while(OCIFetch($s)){
			
			$news_json = json_encode_cyr(array(
									"id" => ociresult($s,'ID'), 
									"name_news" => ociresult($s,'NAME_NEWS'), 
									"date" => ociresult($s,'DATE_NEWS'), 
									"text" => ociresult($s,'TEXT_NEWS').ociresult($s,'TEXT_NEWS2').ociresult($s,'TEXT_NEWS3').ociresult($s,'TEXT_NEWS4')
							  ));
		
		}

		print_r($news_json);		
		
	} else {
		
		
		if(isset($_POST['type'])){
			$type = $_POST['type'];
		} else {
			$type = 1;
		}
		
		if(isset($_POST['last_article'])){
		
			$num = $_POST['last_article'];
			$id_num = $num - 5;
			
		} else {
			$sql = "select MAX(id) AS NUM from NEWS where source_news = " . $type . "";
		
			$s = OCIParse($c,$sql);
			OCIExecute($s, OCI_DEFAULT); 
			
			while(OCIFetch($s)){
				$num = ociresult($s,'NUM');		
			}
		
			OCICommit($c); 
			
			
			
			$id_num = $num - 10;
		}
		
		
		
		$sql="select * from news where source_news = " . $type . " and id >= ". $id_num . " and id < " . $num . " order by ID desc";
	
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT);
		
	    $news_json = array();
		$count = 0;
				
		while(OCIFetch($s)){
			
			$news_json[$count] = array(
									"id" => ociresult($s,'ID'), 
									"name_news" => ociresult($s,'NAME_NEWS'), 
									"date" => ociresult($s,'DATE_NEWS'), 
									"descr" => ociresult($s,'DESCRIPTION'),
									"type" => ociresult($s,'SOURCE_NEWS')
								);
			$count ++;
		
		} 
		
		print_r(json_encode_cyr($news_json));	
		
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
		
			
	
?>