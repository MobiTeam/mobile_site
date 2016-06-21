<?php

// НОВОСТИ (UPDATE 17.05.2016)

    require('database_connect_PDO.php');
	require_once('../auth/ad_functions.php');
	
	foreach($_POST as $key => $value){
		if(!valParametr($value)) die('Wrong Data!');
		$_POST[$key] = intval($_POST[$key]);
	}

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
		

		$stmt=$conn->prepare("select 
				ID,
				cast(NAME_NEWS AS VARCHAR2(4000)) as NAME_NEWS,
				DATE_NEWS,
				cast(TEXT_NEWS AS VARCHAR2(3995)) as TEXT_NEWS,
				cast(TEXT_NEWS2 AS VARCHAR2(4000)) as TEXT_NEWS2,
				cast(TEXT_NEWS3 AS VARCHAR2(4000)) as TEXT_NEWS3,
				cast(TEXT_NEWS4 AS VARCHAR2(4000)) as TEXT_NEWS4,
				cast(SOURCE_ADDR AS VARCHAR2(512)) as SOURCE_ADDR
		 from ". $table ." where id = :news_id ");

		$stmt->execute(array('news_id' => $_POST['news_id']));
		
		$news_json = '';

		while(@$row=$stmt->fetch()){
			
			$news_json = json_encode(array(
									"id" => $row['ID'], 
									"name_news" => $row['NAME_NEWS'], 
									"date" => $row['DATE_NEWS'], 
									"text" => $row['TEXT_NEWS'].$row['TEXT_NEWS2'].$row['TEXT_NEWS3'].$row['TEXT_NEWS4'],
									"source_addr" => $row['SOURCE_ADDR']
							 	    ),JSON_UNESCAPED_UNICODE);
		
		}

		print_r($news_json);		
		
	} else {
		
		if(isset($_POST['first_article'])){

			$id = $_POST['first_article'];

			$stmt=$conn->prepare("select * from " . $table . " where id > :id order by ID desc");
			$stmt->execute(array('id' => $id));	

 
		} else {

			if(isset($_POST['last_article'])){
		
				$num = $_POST['last_article'] - 1;
				$id_num = $num - 7;
			
			} else {

		
				$stmt=$conn->prepare("select MAX(id) AS NUM from ".$table."");
				$stmt->execute();	

				while($row=$stmt->fetch()){
					$num = $row['NUM'];		
				}
				$id_num = $num - 10;
				
			}

			$stmt=$conn->prepare("select * from " . $table . " where id > :id_num and id <=:num order by ID desc");
			$stmt->execute(array('id_num' => $id_num,'num' => $num));				

		}
		
	
		
	    $news_json = array();
		$count = 0;
				

		while(@$row=$stmt->fetch()){
			
			$news_json[$count] = array(
									"id" => 			$row['ID'], 
									"name_news" => 		$row['NAME_NEWS'], 
									"date" => 			$row['DATE_NEWS'], 
									"descr" => 			$row['DESCRIPTION'],
									"type" => 			$row['SOURCE_NEWS'],
									"img" => 			$row['PREV_IMG_NEWS'],
									"source_addr" => 	$row['SOURCE_ADDR']
								);
			$count ++;
		
		} 
		print_r(json_encode($news_json,JSON_UNESCAPED_UNICODE));	
	} 
	 @$conn=null;
	
?>