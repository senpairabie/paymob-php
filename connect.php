<?php
///////////////////////////////
//DESKTOP-32RL6R4\SQLEXPRESSc
$dsn = "mysql:host=localhost;dbname=test";
$user = "root";
$password = "";
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8mb4",   // arabic  ==> utf8
   
);

// utf8mb4
/* 
'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
*/
   

try{
    $connect = new PDO($dsn, $user , $password , $option );
    $connect->setAttribute(PDO::ATTR_ERRMODE , PDO:: ERRMODE_EXCEPTION );
    //for security
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
    header("Access-Control-Allow-Methods: POST, OPTIONS , GET");

    include "function.php";

   // checkAuthenticate();

}catch( PDOException $e){
    echo $e-> getMessage() ;

}

?>