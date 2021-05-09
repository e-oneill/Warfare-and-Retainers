<?php

error_reporting(E_ALL);
 
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
$name = "";
$type = "";
$level = 0;
$assoc_char = "";
$userid = $_SESSION['user_id'];

$name = mysqli_real_escape_string($conn, $_POST["name"]);
$type = mysqli_real_escape_string($conn, $_POST["type"]);
$level = mysqli_real_escape_string($conn, $_POST["level"]);
$assoc_char = mysqli_real_escape_string($conn, $_POST["assoc-character"]);
$font_color = mysqli_real_escape_string($conn, $_POST['font-color']);
$primary_color = mysqli_real_escape_string($conn,$_POST['primary-color']);
$secondary_color = mysqli_real_escape_string($conn, $_POST['secondary-color']);

$name = addslashes($name);
$type = addslashes($type);
$level = addslashes($level);
$assoc_char = addslashes($assoc_char);

echo $name;
echo $type;
echo $level;
echo $assoc_char;

if (!empty($assoc_char)) {
$sql = "SELECT `character_id` FROM `characters` WHERE `Character Name` LIKE ? AND  `User` LIKE ?";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "ss", $assoc_char, $userid);
    $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    $assoc_char = mysqli_real_escape_string($conn, $_POST["assoc-character"]);
    if (mysqli_stmt_execute($stmt)){
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $assoc_char = $row['character_id'];
         }
    }
} else {
    $assoc_char = NULL;
}

//$sql= "SELECT `character_id` FROM `characters` WHERE `Character Name` LIKE '$assoc_char' AND  `User` LIKE '$userid'"; 
//$result = $mysqli->query($sql);
//$row = $result->fetch_assoc();
//$assoc_char = $row['character_id'];

//$sql= "SELECT `RetainerID` FROM `retainer` WHERE `RetainerName` LIKE '$type'"; 
//$result = $mysqli->query($sql);
//$row = $result->fetch_assoc();
//$type = $row['RetainerID'];


//$sql = "SELECT `RetainerID` FROM `retainer` WHERE `RetainerName` LIKE ?";
//if($stmt = mysqli_prepare($conn,$sql)){
//    mysqli_stmt_bind_param($stmt, "s", $type);
//    $type = mysqli_real_escape_string($conn, $_POST['type']);
//    if (mysqli_stmt_execute($stmt)){
//                $stmt->execute();
//                $result = $stmt->get_result();
//                $row = $result->fetch_array(MYSQLI_ASSOC);
//                $type = $row['RetainerID'];
//         }
//    }
//    else {
//            array_push($errors, "Wrong username/password combination");
//        }

echo "<h2> Trying to add a new retainer: $name, a level $level $type, assigned to $assoc_char </h2>";

//Search database for keyword

//echo "<h2>Lookup $keyword</h2>";




$db_img = mysqli_connect("localhost","root","177300Milan","image_upload");

//Init message var

$msg = "";

    
    //get image name
    $image = $_FILES;
    // get text
    mkdir ("images/$userid" . "-" . $_SESSION['username'], "0777");
    $target = "images/$userid" . "-" . $_SESSION['username']."/".basename($_FILES['image']['name']);
   
    
//    $target = "images/'$userid'/".basename($image);
    
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
        
    }else{
        $msg = "Failed to upload image";
        }

//echo $assoc_char;

$result = mysqli_query($db_img,"SELECT * FROM images");


$sql = "INSERT INTO `user-retainers` (`User-Retainer-ID`,`User`, `Retainer-Name`,`Retainer-Level`,`Retainer-Type`,`Assoc-Character`,`image`, `profile-font-toggle`, `primary-colour`, `secondary-colour`) VALUES (NULL, ?, ?, ?, ?, ?,?,?,?,?)";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "isiiissss", $userid, $name, $level, $type, $assoc_char, $target,$font_color,$primary_color, $secondary_color);
    $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    
    mysqli_stmt_execute($stmt);
    $last_id = $stmt->insert_id;
    
    }
    else {
            array_push($errors, "One of the parameters was not in the format expected.");
        }






$url = "retainer.php?id=";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $last_id);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$result = curl_exec($ch);


header("Location:retainer.php?id=$last_id")
?>

<a href="index.php">Return to Home</a>