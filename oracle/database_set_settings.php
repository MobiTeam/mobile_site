﻿<?php


   require_once('database_connect.php');
   require_once('../auth/ad_functions.php');

	
	 $ID=$_POST['id_user'];
	 $Code=$_POST['code'];
	 $SUB = $_POST['subgrp'];
	 $QUERY = $_POST['def_query'];
	

	
	$sql="update SETTINGS set CODE_SETTINGS='".$Code."', USER_SUBGROUP = '" . $SUB . "', DEFAULT_TMTB_QUERY = '" . $QUERY . "'
	where ID_USER='".$ID."'";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s);

?>