<?php 
	
	header("Content-Type: text/html;charset=UTF-8");
	require_once('../auth/ad_functions.php');
	
	//определяем границы страницы
	$first_label = "<table";
	$second_label = "</table>";

	if($html = @file_get_contents("http://peremena.s-pom.ru/table.php")){

		$first_pos = strpos($html, $first_label);
		$second_pos = strpos($html, $second_label);

		$clr_html = substr($html, $first_pos, $second_pos - $first_pos);

		$main_lvl_class = '"menu__header"';
		$main_lvl_subclass = '"menu__header-sub"';
		$item_class = "menu__item";

		$json_arr = array();
		$m_lvl_count = 0;
		$m_cat_count = 0;
		$cnt = 0;

		if(preg_match_all('/<tr.*>([\s\S]*?)<\/tr>/', $clr_html, $tr_arr)){
			
			for($i = 0; $i < count($tr_arr[0]); $i++){
				
				if(strpos($tr_arr[0][$i], $main_lvl_class) != false){
					preg_match_all('/<h2.*>(.*)<\/h2>/', $tr_arr[0][$i], $title);
					if(isset($json_arr[$m_lvl_count])){
						$m_lvl_count++;
						$m_cat_count = 0;
						$cnt = 0;
					}
					$json_arr[$m_lvl_count] = array("title" => $title[1][0], "cat" => array(array("cat_name" => "",
						                                                                      "dishes" => array())));
				} elseif(strpos($tr_arr[0][$i], $main_lvl_subclass) != false){
					preg_match_all('/<h3.*>(.*)<\/h3>/', $tr_arr[0][$i], $title);
					if(isset($json_arr[$m_lvl_count]["cat"][$m_cat_count])){
						$m_cat_count++;
						$cnt = 0;
					}
					
					$json_arr[$m_lvl_count]["cat"][$m_cat_count]["cat_name"] = isset($title[1][0]) ? $title[1][0] : "";

				} else {

					preg_match_all('/<td.*?>([\s\S]*?)<\/td>/', $tr_arr[0][$i], $dish_info);
					$json_arr[$m_lvl_count]["cat"][$m_cat_count]["dishes"][$cnt++] = array("title" => trim(strip_tags($dish_info[1][0])), 
																							  "weight" => trim(strip_tags($dish_info[1][1])), 
																							   "price" => trim(strip_tags($dish_info[1][2])));
				}

			}
			
		}

	}
	
	
	print_r(json_encode_cyr($json_arr));
	

?>