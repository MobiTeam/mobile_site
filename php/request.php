<?php 

	if(isset($_POST['operation'])){
		
		switch($_POST['operation']){
				
			case 0:
				echo('�����������');
			break;
			
			case 1:
				echo('�������� ��������');
			break;
			
			case 2:
			    echo('�������� ����������');
			break;
			
		}
		
	}

	newsArray[0] = array(
				  "id" => 1,
				  "title" => "��������� �������",
				  "date" => "���� �������",
				  "introtext" => "������������� ����� �������",
				  "min_image" => "������ �� ������������� �����������",
				  "all_images" => "������ �� ������ �����������, ����������� �������",
				  "source" => "�������� �������"
				);
	
	person = array(
			 "fullname" => "���������� ��������� �������",
			 "is_student" => "1 ��� 0",
			 "appoint" = "������ ����������",
			 "marks" = array(
			           "date_mark" => "���� ������",
					   "Discipline" => "�������",
					   "score" => "������"
			        ),
			 "grants" = array(
						"date_grant" => "���� ���������",
						"summ" => "�����"
					),
             "costs" = array(
						"date_cost" => "���� �������",
						"summ" => "����� �������"
			 )					
	)
	
?>