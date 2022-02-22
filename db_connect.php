<?php
//four variables to connect to database  
$host = "localhost";
$username = "monkehh";
$user_pass = "XXXX";
$database_in_use = "dnd";
    
//create data if it's available
$mysqli = new mysqli($host, $username, $user_pass, $database_in_use);
$conn = mysqli_connect($host, $username, $user_pass, $database_in_use);

?>
