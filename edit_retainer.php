<?php
 
    session_start();
    
    $changes = array();
    $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
    $referer_parsed = parse_url($referer, PHP_URL_PATH);
    $query_parsed = parse_url($referer, PHP_URL_QUERY); 
//    $referer_parsed = (isset($referer_parsed['path']) ? $e['path'] : '/');
    $referer_parsed = preg_replace(array('/^\//','/\/$/'), "", $referer_parsed);
    $query_parsed = preg_replace(array('/^\//','/\/$/'), "", $query_parsed);

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
$userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
$font_color = mysqli_real_escape_string($conn,$_POST['font-color']);
$primary_color = mysqli_real_escape_string($conn,$_POST['primary-color']);
$secondary_color = mysqli_real_escape_string($conn,$_POST['secondary-color']);



$name = mysqli_real_escape_string($conn, $_POST["name"]);
$type = mysqli_real_escape_string($conn, $_POST["type"]);
$retainerid = mysqli_real_escape_string($conn, $_POST["id"]);
$level = $_POST["level"];
$assoc_char = $_POST["assoc-character"];
echo $assoc_char;
$name = addslashes($name);
$type = addslashes($type);
$level = addslashes($level);
$assoc_char = addslashes($assoc_char);

$sql = "SELECT * FROM `user-retainers` WHERE `User-Retainer-ID` LIKE '$retainerid'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$old_name = $row['Retainer-Name'];
$old_type = $row['Retainer-Type'];
$old_level = $row['Retainer-Level'];
$old_assoc_char = $row['Assoc-Character'];
$old_font_color = $row['profile-font-toggle'];


$sql= "SELECT `character_id` FROM `characters` WHERE `Character Name` LIKE '$assoc_char' AND  `User` LIKE '$userid'"; 
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$assoc_char = $row['character_id'];

$sql = "INSERT INTO `retainer-custom-action` (`id`, `retainer-id`, `Retainer-Action-Name`,`Is-Signature-Attack`, `Retainer-Action-Type`, `Retainer-Action-Duration`, `Retainer-Action-Uses`, `Retainer-Action-Text`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "isissis", $retainerid, $cust_act_name, $is_sig, $cust_act_type, $cust_act_duration, $cust_act_uses, $cust_act_text);
    echo $retainerid. "<br>";
    $cust_act_name = mysqli_real_escape_string($conn, $_POST['cust-act-name']);
    echo $cust_act_name. "<br>";
    $cust_act_text = mysqli_real_escape_string($conn, $_POST['cust-act-text']);
    echo $cust_act_text. "<br>";
    $cust_act_type = mysqli_real_escape_string($conn, $_POST['cust-act-type']);
    echo $cust_act_type. "<br>";
    $cust_act_duration = mysqli_real_escape_string($conn, $_POST['cust-act-duration']);
    echo $cust_act_duration. "<br>";
    $cust_act_uses = mysqli_real_escape_string($conn, $_POST['cust-act-uses']);
    echo $cust_act_uses. "<br>";
    $is_sig = mysqli_real_escape_string($conn, $_POST['cust-act-bool']);;
    echo $is_sig. "<br>";
    mysqli_stmt_execute($stmt);
//    $cust_act = $stmt->insert_id;
}
    else {
        array_push($errors, "Failed adding custom action");
    }



//$sql= "SELECT `RetainerID` FROM `retainer` WHERE `RetainerName` LIKE '$type'"; 
//$result = $mysqli->query($sql);
//$row = $result->fetch_assoc();
//$type = $row['RetainerID'];
echo $type;
if ($name != $old_name): {
$sql = "UPDATE `user-retainers` SET `Retainer-Name` = '$name' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
    
array_push($changes, "Retainer Name changed.");

    
}
endif;

if ($type != $old_type): {
$sql = "UPDATE `user-retainers` SET `Retainer-Type` = '$type' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
    
array_push($changes, "Retainer Type changed.");
    
}
endif; 


if ($level != $old_level): {
$sql = "UPDATE `user-retainers` SET `Retainer-Level` = '$level' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));   

array_push($changes, "Retainer level changed.");
    
}
endif; 

echo "<br>Associated Character: " . $assoc_char . "<br>Currently Associated Character: " . $old_assoc_char;

if ($assoc_char != $old_assoc_char): {
    echo "<br>Associated character is a new character";
    
    
    
    if ($assoc_char === "NULL"): {
        $sql = "UPDATE `user-retainers` SET `Assoc-Character` = NULL WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        echo "Set associated character to null";
    
        array_push($changes, "Retainer character changed.");
    } else: {
$sql = "UPDATE `user-retainers` SET `Assoc-Character` = '$assoc_char' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
echo "set association character to null";
    
array_push($changes, "Retainer character changed.");
}   endif; 
}
endif; 

if ($font_color != $old_font_color): {
$sql = "UPDATE `user-retainers` SET `profile-font-toggle` = '$font_color' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli)); 
    
array_push($changes, "Retainer font toggled.");    
    
}
endif;

$sql = "UPDATE `user-retainers` SET `primary-colour` = '$primary_color' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli)); 

$sql = "UPDATE `user-retainers` SET `secondary-colour` = '$secondary_color' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli)); 
    
array_push($changes, "Retainer font toggled.");    

$sql = "UPDATE `user-retainers` SET `profile-font-toggle` = '$font_color' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli)); 
    
array_push($changes, "Retainer font toggled.");    
    
$db_img = mysqli_connect("localhost","monkehh","177300Milan!","image_upload");

//Init message var

$msg = "";

    
    //get image name
    $image = $_FILES;
    // get text
    mkdir ("images/$userid" . "-" . $_SESSION['username'], "0777");
    $target = "images/$userid" . "-" . $_SESSION['username']."/".basename($_FILES['image']['name']);
    echo "<br>" . $target . "<br>" . $_FILES['image']['tmp_name'] . "<br>";
//    $image_text = mysqli_real_escape_string($db_img, $_POST['image_text']);
    
//    $target = "images/'$userid'/".basename($image);
    
    $sql = "INSERT INTO images (image,image_text) VALUES('$image', '$image_text'))";
    mysqli_query($db_img,$sql);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
        
        $sql = "UPDATE `user-retainers` SET `image` = '$target' WHERE `user-retainers`.`User-Retainer-ID` = '$retainerid'";
        $result = $mysqli->query($sql) or die(mysqli_error($mysqli)); 
    
        array_push($changes, "Retainer portrait changed.");       
        
        
    }else{
        $msg = "Failed to upload image: #".$_FILES["image"]["error"];
        
        }
        
        
        echo $msg;

echo "<h2> Making an update to retainer id $retainerid. <br>";

//Search database for keyword

//echo "<h2>Lookup $keyword</h2>";
//$sql = "INSERT INTO `user-retainers` (`User-Retainer-ID`,`User`, `Retainer-Name`,`Retainer-Level`,`Retainer-Type`,`Assoc-Character`) VALUES (NULL, '$userid', '$name', '$level', '$type', '$assoc_char')";



//$result = $mysqli->query($sql) or die(mysqli_error($mysqli));

//include "search_all_retainer.php";

$returnlocation = $referer_parsed . "?" . $query_parsed;


header("Location: $returnlocation")
?>