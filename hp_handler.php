<?php
include "db_connect.php";
if (isset($_POST['newHP'])): {
    $newHP = $_POST['newHP'];
    $characterid = $_POST['characterid'];

    $sql = "UPDATE `characters` SET `Curr_HP` = ? WHERE `character_id` LIKE ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ii", $newHP, $characterid);
                mysqli_stmt_execute($stmt); 
    //            echo "Remove foreign key to signature-attack-2";
    }


    echo $newHP;
} elseif (isset($_POST['tempHP'])): {
    $tempHP = $_POST['tempHP'];
    $characterid = $_POST['characterid'];
    $sql = "UPDATE `characters` SET `TempHP` = ? WHERE `character_id` LIKE ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $tempHP, $characterid);
        mysqli_stmt_execute($stmt); 
    //            echo "Remove foreign key to signature-attack-2";
    }

    if (!empty($tempHP)):{
    echo $tempHP; 
    } else: {
    echo "--";
    } endif;

} endif;
?>