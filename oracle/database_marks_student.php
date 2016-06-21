<?php
//ПОЛУЧЕНИЕ ОЦЕНОК СТУДЕНТА (UPDATE 16.05.2016)

    session_start(); 
	require_once('../auth/ad_functions.php');
	modifyPost();
	userAutentificate();
	if(isset($_SESSION['FIO'])){
		$FFIO = $_SESSION['FIO'];
	} else {
		$FFIO = $_POST['FIO'];
	}

	if(isset($_SESSION['groups'])){
		$GRUP = $_SESSION['groups'];
	} else {
		$GRUP = $_POST['groups'];
	}

	require('database_connect_PDO.php');

	$marks=array();	

	for ($i=0; $i < count($GRUP); $i++) { 	

		$GRUP[$i]="%$GRUP[$i]%";

   $query=$conn->prepare("Select
		cast(DIS AS VARCHAR2(512)) as DIS,
		cast(GR_NAME AS VARCHAR2(512)) as GR_NAME,
		cast(ZACH AS VARCHAR2(512)) as ZACH,
		cast(SEMESTR AS VARCHAR2(512)) as SEMESTR,
		cast(TYPEWORK AS VARCHAR2(512)) as TYPEWORK,
		cast(FWMARK AS VARCHAR2(512)) as FWMARK

     from v_stud_marks
where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace(:FIO,'.',''),' ','')),1)>=1
   		 and gr_name LIKE :GRUP
   		 order by TYPEWORK,SEMESTR");

   $query->execute(array('GRUP' => $GRUP[$i],'FIO'=>$FFIO));

	$count = 0;
	$marks_json = array();

		while($row=$query->fetch()){	
			$marks_json[$count] = array(
			
								"discipline" => $row['DIS'],
								"group" => 		$row['GR_NAME'],
								"zach" => 		$row['ZACH'],
								"semestr" =>	$row['SEMESTR'],
								"type" => 		$row['TYPEWORK'],
								"mark" => 		$row['FWMARK']
								);
			$count ++;
			
		} 
		$marks[$i]=$marks_json;
	}
	print_r(json_encode($marks,JSON_UNESCAPED_UNICODE));
	 @$conn=null;
   
   
?>