<?php

//error_reporting(E_ALL);
 
    session_start();

    $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
    $referer_parsed_path = parse_url($referer, PHP_URL_PATH);
//    $referer_parsed = (isset($referer_parsed['path']) ? $e['path'] : '/');
    $referer_parsed_path = preg_replace(array('/^\//','/\/$/'), "", $referer_parsed_path);

if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
}

include "db_connect.php";
$userid = $_SESSION['user_id'];

$retainerid = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "DELETE FROM `user-retainers` WHERE `USER-Retainer-ID` LIKE ? AND `User` LIKE ?";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "ii", $retainerid, $userid);
    mysqli_stmt_execute($stmt);   
}

echo $retainerid;

header("location:$referer_parsed_path");

?>