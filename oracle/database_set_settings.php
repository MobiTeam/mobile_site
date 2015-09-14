<?php


   require_once('database_connect.php');
   require_once('../auth/ad_functions.php');

	
	 $ID=$_POST['id_user'];
	 $Code=$_POST['code'];
	

	
	$sql="update SETTINGS set CODE_SETTINGS='".$Code."'
	where ID_USER='".$ID."'";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s);

?>