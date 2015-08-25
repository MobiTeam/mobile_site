<?php 
  Header("Content-Type: text/html;charset=UTF-8");
  require_once('oracle/database_connect.php');
  require_once('auth/ad_functions.php');
    
	if(isset($_POST['last_article'])){
		$id_num = $_POST['last_article'];
	} else {
		$sql = "select MAX(id) AS NUM from NEWS";
	
		$s = OCIParse($c,$sql);
		OCIExecute($s, OCI_DEFAULT); 
		
		while(OCIFetch($s)){
			$num = ociresult($s,'NUM');		
		}
	
		OCICommit($c); 
		
		$id_num = $num - 15;
	}
	
  $sql = "select id,name_news,date_news,text_news,text_news2,text_news3,text_news4,prev_img_news from news where id>".$id_num." order by DATE_NEWS DESC";
  
  $s = OCIParse($c,$sql);
  OCIExecute($s, OCI_DEFAULT);
  ocifetchstatement($s, $data_news_arr);
  
  print_r(str_replace('\/','/',json_encode_cyr($data_news_arr)));

?>