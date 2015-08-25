<?php 

	if(isset($_POST['operation'])){
		
		switch($_POST['operation']){
				
			case 0:
				echo('Авторизация');
			break;
			
			case 1:
				echo('Загрузка новостей');
			break;
			
			case 2:
			    echo('Загрузка расписания');
			break;
			
		}
		
	}

	newsArray[0] = array(
				  "id" => 1,
				  "title" => "Заголовок новости",
				  "date" => "Дата новости",
				  "introtext" => "Вступительный текст новости",
				  "min_image" => "Ссылка на вступительное изображение",
				  "all_images" => "Ссылки на другие изображения, разделенные запятой",
				  "source" => "Источник новости"
				);
	
	person = array(
			 "fullname" => "Петроченко Владислав Юрьевич",
			 "is_student" => "1 или 0",
			 "appoint" = "Полное назначение",
			 "marks" = array(
			           "date_mark" => "Дата оценки",
					   "Discipline" => "Предмет",
					   "score" => "Оценка"
			        ),
			 "grants" = array(
						"date_grant" => "Дата стипендии",
						"summ" => "Сумма"
					),
             "costs" = array(
						"date_cost" => "Дата платежа",
						"summ" => "Сумма платежа"
			 )					
	)
	
?>