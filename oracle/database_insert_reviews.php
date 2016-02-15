<?php

	require_once('../auth/ad_functions.php');
	require_once('database_connect.php');

	function valParametr($str){

		if($str == "") return false;

		  $check_arr = array("#", "$", "{", "}", "[", "]", "../", "chr", "access", "default", "index",
          "add", "delete", "initial",
          "all", "desc", "insert",
          "alter", "distinct", "integer",
          "and", "drop", "intersect",
          "any", "into",
          "as", "else", "is", 
          "asc", "exclusive",
          "audit", "exists", "level",
          "like", "between" , "file", "lock",
          "bt", "float", "long", "for",
          "char", "from", "maxextemns",
          "check",  "minus", "cluster", "grant", "mode",
          "column", "graphic", "modify",
          "comment", "group", "compress", "noaudit",
          "connect", "having", "nocompress",
          "create", "not", "current", "identified", 
          "nowait", "if", "null",
          "date", "immediate", "number", 
          "dba", "in", "decimal", "increment", "of",
          "offline", "rownum", "uid", "on", "rows",
          "union", "online", "unique", "option", "select",
          "update", "or", "session", "user", "order", "set",
		  "share", "validate", "pctfree", "size", "values",
		  "prior", "smallint", "varchar", "privileges", "start",
		  "vargraphic", "public", "succsessful", "view", "synonym",
		  "raw", "sysdate", "whenever", "rename", "where", "resource",
		  "table", "with", "revoke", "then", "row", "to", "rowid", "trigger");


		for($i = 0; $i < count($check_arr); $i++){
			
			if(strrpos(strtolower($str), $check_arr[$i]) !== false){
				return false;
			}
		}

		return true;

	}

	$FFIO=$_POST['FIO'];
	$EMAIL=$_POST['E-mail'];
	$COMMENT = $_POST['Message_text'];

	if(valParametr($FFIO) && valParametr($EMAIL) && valParametr($COMMENT)){
		$s=OCIParse($c,"Insert into REVIEWS
					(FFIO,EMAIL,COMMENT_REV,DATE_REV)
					values('".$FFIO."','".$EMAIL."','".$COMMENT."',sysdate)");
			
		OCIExecute($s, OCI_DEFAULT);
		
	    OCICommit($c); 	
	} else {
		die("Введено недопустимое значение. Запись не была сохранена.");
	}


	

?>