<?php

    require_once('database_connect.php');
	require_once('../auth/ad_functions.php');

	if(isset($_POST['type'])){
		$type = $_POST['type'];
	} else {
		$type = 1;
	}
		
	switch($type){
		case 1:
			$table = 'news';
		break;
		case 2:
			$table = 'anons';
		break;
		case 3:
			$table = 'inform';
		break;
		default:
			$table = 'news';
		break;
	}

	
	if(isset($_POST['news_id'])){
		
		$sql="select * from " . $table . " where id = ".$_POST['news_id']."";
		
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
		
		if(isset($_POST['first_article'])){

			$id = $_POST['first_article'];

			$sql = "select * from " . $table . " where id > ". $id . " order by ID desc";
 
		} else {

			if(isset($_POST['last_article'])){
		
				$num = $_POST['last_article'] - 1;
				$id_num = $num - 7;
			
			} else {

				$sql = "select MAX(id) AS NUM from " . $table . "";
			
				$s = OCIParse($c,$sql);
				OCIExecute($s, OCI_DEFAULT); 
				
				while(OCIFetch($s)){
					$num = ociresult($s,'NUM');		
				}

				OCICommit($c);

				$id_num = $num - 10;
				
			}
		
				
			$sql="select * from " . $table . " where id > ". $id_num . " and id <= " . $num . " order by ID desc";			

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
									"descr" => ociresult($s,'DESCRIPTION'),
									"type" => ociresult($s,'SOURCE_NEWS'),
									"img" => ociresult($s,'PREV_IMG_NEWS')
								);
			$count ++;
		
		} 
		
		print_r(json_encode_cyr($news_json));	
		
	} 
			
	
?>