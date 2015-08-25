<?php 
   
   require_once('..\oracle\database_connect.php');
   require_once('parse_functions.php');
   set_time_limit(1500); 
   $counter = 0;
   $err_count = 0;
   
   
   function add_domain($n){
	   return('http://www.ugrasu.ru'.$n);
   }
   
   
   $content = file_get_contents('http://www.ugrasu.ru/news/?date=1996-06-28&PAGEN_1=26&SIZEN_1=2000000');
   $flpos = strpos($content,"<div id=\"content\">");
   $slpos = strpos($content,"<div class=\"news-detail-share\">");
   $content = substr($content,$flpos,$slpos-$flpos);
   
   //получаем массив ссылок
   if(preg_match_all('/href="([^"]+detail[^"]+)/', $content, $arr_url) && preg_match_all('/<img[^>]+src=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/',$content,$arr_img)){ 
	  
       $source = 'Новости сайта ugrasu.ru';        
	   
       $first_tag = '<div class="news-detail">';	
	   $sec_tag = '<div class="newsdate">';
	   
	   require_once('db_get_last_articleid.php');//получаем ID последней новости
	  		   
	   require_once('db_load_completelinks.php');//получаем массив добавленных ссылок
	   
	   $arr_img_rev = array_reverse($arr_img[2]);
	   	   
	   foreach(array_reverse(array_diff(array_map("add_domain",array_unique($arr_url[1])),$data_links_arr["URL"])) as $key){
		    
			$article_url = $key;
		   
			if(($content = file_get_contents($key)) && (preg_match_all('~<title>(.*)</title>~', $content, $title)) && (preg_match_all('~<div class="newsdate">(.*)</div>~', $content, $date))){
				 
				$f_pos = strpos($content,$first_tag);
				$s_pos = strpos($content,$sec_tag);
				
				if(preg_match_all('~[0-9\.,]*~',$date[0][0],$num_date)){
				  	$cl_date = substr(implode($num_date[0]),0,10); 
				} else die('Шаблон даты поменялся.');
				
				$chunk_cont = substr($content, $f_pos, $s_pos - $f_pos);
				$art_name = str_replace(array("«","»"),'"',substr($title[1][0],0,strripos($title[1][0],'|')));
				
				mb_internal_encoding("UTF-8");				
			
			if (preg_match_all('#<(p|li|div)[^>]*>([\s\S]{2,}?)<\/(p|li|div)>#m', $chunk_cont, $arr)){
				
				          echo('<h2>'.$art_name.'<br>   Дата:'.$cl_date.'</h2>');  			         
						  echo('<img src="http://www.ugrasu.ru'.$arr_img_rev[$counter].'" width="300px"/>');
					    
						// || preg_match_all('#<div class="news-detail">([\s\S]*)<div style="clear:both"></div>#i', $chunk_cont, $arr2)
						
						include('file_load_images.php');
                        $date_news=$cl_date;
						$name_news=$art_name;
						
						$replace_arr = array("'");
						
		
                		$text_news = '';
						
						#удаляем пустые абзацы
						foreach(array_map("stripWhitespaces",$arr[2]) as $p){
							if(iconv_strlen($p)>2){
								$text_news.="<p>".$p."</p>";								
						   }
						}
						
						//$text_news=str_replace($replace_arr,"''",implode(array_map("clear_tags",$arr[2])));
							
						
						if(iconv_strlen($text_news)<=3800){
							$text_news1 = $text_news;
							$text_news2 = '';
							$text_news3 = '';
							$text_news4 = '';							
						} else if (iconv_strlen ($text_news)<=15200){
							$text_news1 = mb_substr($text_news,0,3800);
							$text_news2 = mb_substr($text_news,3800,3800);
							$text_news3 = mb_substr($text_news,7600,3800);
							$text_news4 = mb_substr($text_news,11400,3800);
				        }
												
						echo($text_news1.$text_news2.$text_news3.$text_news4);
						
						// $img_news=$_POST[''];
						// $prev_news=$_POST[''];
						// $prev_img_news=$_POST[''];
						// $source_news=$_POST[''];
					  include('db_load.php');
                      include('db_insert_goodlinks.php');					
				} else{
					echo('Ошибка:  '.$article_url.'<br>');
					$err_count++;
					include('db_insert_badlinks.php');
               }
                $counter++;			   
			} else die('Сервер недоступен. Ошибка загрузки новостей.');			 
		 }
	 } else {
	   die('Сервер недоступен или изменен шаблон новостной ссылки.');	   	   
   }
   
  
  OCILogoff($c); 

?>