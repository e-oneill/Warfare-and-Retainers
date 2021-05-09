<?php
//four variables to connect to database  
$host = "localhost";
$username = "id13307111_root";
$user_pass = "177300Milan!";
$database_in_use = "id13307111_dnd";
    
//create data if it's available
$mysqli = new mysqli($host, $username, $user_pass, $database_in_use);
$user_db = mysqli_connect($host, $username, $user_pass, $database_in_use);

?>