<?php



//ВСТАВКА В ТАБЛИЦУ ИНФОРМАЦИИ ОБРАТНОЙ СВЯЗИ (UPDATE 17.05.2016)

	require_once('../auth/ad_functions.php');
	require('database_connect_PDO.php');
	modifyPost();
	$FFIO=$_POST['FIO'];
	$EMAIL=$_POST['E-mail'];
	$COMMENT = $_POST['Message_text'];
	if(valParametr($FFIO) && valParametr($EMAIL) && valParametr($COMMENT)){
		$query=$conn->prepare("Insert into REVIEWS
					(FFIO,EMAIL,COMMENT_REV,DATE_REV)
					values(:FIOa,:EMAILa,:COMMENTa,sysdate)");
			
		$query->execute(array('FIOa' => $FFIO,'EMAILa' => $EMAIL,'COMMENTa' => $COMMENT));

	} else {
		die("Введено недопустимое значение. Запись не была сохранена.");
	}
 @$conn=null;

	

?>