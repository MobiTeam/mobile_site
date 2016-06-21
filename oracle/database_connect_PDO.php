<?php

//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ PDO (UPDATE 16.05.2016)

$tns = "  
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)
      (HOST = oradb.ugrasu.ru)
      (PORT = 1521))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = gala)
    )

  )
       ";
$db_username = "MOBILE";
$db_password = "kisupass1993";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try{
    $conn = new PDO("oci:dbname=".$tns.";charset=AL32UTF8",$db_username,$db_password,$opt);
 }catch(PDOException $e){
    echo ($e->getMessage());
}



?>