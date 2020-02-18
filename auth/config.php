<?php
header("Access-Control-Allow-Origin: *");
define('DB_SERVER', '10.13.48.44');
define('DB_USERNAME', 'web');
define('DB_PASSWORD', 'web');
define('DB_NAME', 'web');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>