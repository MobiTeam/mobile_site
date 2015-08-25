<?php
   
    require_once('../oracle/database_connect.php');
    
	$sql = "merge into BAD_NEWS_LINKS using dual on (URL = '".$article_url."')
					when not matched then
					INSERT (URL) values ('".$article_url."')";
	
	$s = OCIParse($c,$sql);
	OCIExecute($s, OCI_DEFAULT); 
	OCICommit($c); 

	

?>