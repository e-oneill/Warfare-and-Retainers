<?php
include "db_connect.php";
if (isset($_POST['relationship'])): {
    $relationship = mysqli_escape_string($conn, $_POST['relationship']);
    $hitdiespent = mysqli_escape_string($conn, $_POST['hitdiespent']);

    $sql = "SELECT * FROM `character-classes` WHERE `character-class-id` LIKE ?";
    if ($stmt = mysqli_prepare($conn, $sql)): {
                    mysqli_stmt_bind_param($stmt, "i", $relationship);
                    mysqli_stmt_execute($stmt); 
                    $result = $stmt->get_result();

                    $row = $result->fetch_assoc();
                    $currenthitdie = $row['hitdice'];


    if ($hitdiespent == 1): {
        $newhitdie = $currenthitdie - 1;
        $sql = "UPDATE `character-classes` SET `hitdice`=? WHERE `character-class-id` LIKE ?";
        if ($stmt = mysqli_prepare($conn, $sql)): {
                    mysqli_stmt_bind_param($stmt, "ii", $newhitdie, $relationship);
                    mysqli_stmt_execute($stmt); 
        } endif;
    } else: {
        $newhitdie = $currenthitdie + 1;
        $sql = "UPDATE `character-classes` SET `hitdice`=? WHERE `character-class-id` LIKE ?";
        if ($stmt = mysqli_prepare($conn, $sql)): {
                    mysqli_stmt_bind_param($stmt, "ii", $newhitdie, $relationship);
                    mysqli_stmt_execute($stmt); 
        } endif;
    } endif;


      } endif;
} elseif (isset($_POST['characterid'])): {
    $characterid = mysqli_escape_string($conn, $_POST['characterid']);
    
    
    $sql = "SELECT * FROM `character-classes` WHERE `character-id` LIKE ?";
    if ($stmt = mysqli_prepare($conn, $sql)): {
        mysqli_stmt_bind_param($stmt, "i", $characterid);
        $stmt->execute();
        $result = $stmt->get_result();
        $classes = $result->fetch_all(MYSQLI_ASSOC);
        for ($i = 0; $i < count($classes); $i++) {
            $relationship = $classes[$i]['character-class-id'];
            $level = $classes[$i]['levels'];
            $currenthitdice = $classes[$i]['hitdice'];
            $resthitdie = floor($level / 2);
            if (($currenthitdice + $resthitdie) > $level): {
                $newhitdie = $level;  
            } else: {
                $newhitdie = $currenthitdice + $resthitdie;
            } endif;
            $sql = "UPDATE `character-classes` SET `hitdice`= ? WHERE `character-class-id` LIKE ?";
            if ($stmt = mysqli_prepare($conn, $sql)): {
                mysqli_stmt_bind_param($stmt, "ii", $newhitdie, $relationship);
                mysqli_stmt_execute($stmt); 
            } endif;
        }
    } endif;
    
} endif;
?>