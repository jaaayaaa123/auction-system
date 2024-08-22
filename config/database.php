<?php
// please change configurations for the smooth function of program and database connectivity
$host = 'localhost';    
$dbname = 'auction_system'; 
$username = 'root';    
$password = 'Dev@2020'; 

function getDbConnection() {
    global $host, $dbname, $username, $password;

   
    $conn = new mysqli($host, $username, $password, $dbname);

  
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>

