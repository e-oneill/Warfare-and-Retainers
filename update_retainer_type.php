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


if (isset($_POST['updateretainer'])) {
include "db_connect.php";
$changes = array();
$saves = $_POST['saves'];
$retainerid = mysqli_real_escape_string($conn, $_POST['retainerid']);
$sql = "SELECT * FROM `retainer` WHERE `RetainerID` LIKE ?";
if($stmt = mysqli_prepare($conn,$sql)) {
mysqli_stmt_bind_param($stmt, "i", $retainerid);
mysqli_stmt_execute($stmt);
$result = $stmt->get_result();
$row = $result->fetch_array(MYSQLI_ASSOC);
$currentretainername = $row['RetainerName'];
$currentsave2 = $row['Retainer-Save2'];
$currentsecabi = $row['Retainer-Secondary-Abi'];
$creatorid = $row['Creator_user'];
$currentsig2 = $row['Signature-Attack-2'];
}
//echo $creatorid;
//echo $_SESSION['user_id'];
$retainersecondary = mysqli_real_escape_string($conn, $_POST['Retainer-Sec-Abi']);
if ((($creatorid == $_SESSION['user_id']) or ($_SESSION['user_id'] == 1)) and !empty($_SESSION['user_id'])) {

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

$sql = "UPDATE `retainer` SET `RetainerName` = ?, `RetainerBaseClass` = ?, `Armor-Type` = ?, `Retainer-Pri-Abi` = ?, `Retainer-Save1` = ? WHERE `RetainerID` LIKE ?";
if($stmt = mysqli_prepare($conn,$sql)) {
    mysqli_stmt_bind_param($stmt, "siiiii", $retainername, $retainerbaseclass, $retainerarmortype, $retainerprimary, $retainersave1, $retainerid);

    $retainername = mysqli_real_escape_string($conn, $_POST['retainername']);
    if ($retainername != $currentretainername) {
        array_push($changes, "Retainer Name was change from ". $currentretainername . " to " . $retainername);  
    }
    $retainerbaseclass = mysqli_real_escape_string($conn, $_POST['RetainerBaseClass']);
    $retainerarmortype = mysqli_real_escape_string($conn, $_POST['armor-type']);
    $retainerprimary = mysqli_real_escape_string($conn, $_POST['Retainer-Pri-Abi']);
    
    $retainersave1 = mysqli_real_escape_string($conn, $saves[0]);
    
    mysqli_stmt_execute($stmt);
}
    
if (!empty($retainersecondary)) {
    $sql = "UPDATE `retainer` SET `Retainer-Secondary-Abi` = ? WHERE `RetainerID` LIKE ?";
    if ($stmt = mysqli_prepare($conn,$sql)) {
    mysqli_stmt_bind_param($stmt,"ii", $retainersecondary, $retainerid);
    mysqli_stmt_execute($stmt);
    }
}

if (empty($retainersecondary) and (!empty($currentsecabi))) {
    $sql = "UPDATE `retainer` SET `Retainer-Secondary-Abi` = NULL WHERE `RetainerID` LIKE ?";
    if ($stmt = mysqli_prepare($conn,$sql)) {
    mysqli_stmt_bind_param($stmt,"i", $retainerid);
    mysqli_stmt_execute($stmt);    
        
    }
}

if (!empty($saves[1])) {
$sql = "UPDATE `retainer` SET `Retainer-Save2` = ? WHERE `RetainerID` LIKE ?";
if ($stmt = mysqli_prepare($conn,$sql)) {
    mysqli_stmt_bind_param($stmt,"ii",$retainersave2, $retainerid);
    $retainersave2 = mysqli_real_escape_string($conn, $saves[1]);
    mysqli_stmt_execute($stmt);
}
}

if (empty($saves[1]) and !empty($currentsave2)) {
$sql = "UPDATE `retainer` SET `Retainer-Save2` = NULL WHERE `RetainerID` LIKE ?";
    if ($stmt = mysqli_prepare($conn,$sql)) {
    mysqli_stmt_bind_param($stmt, "i",$retainerid);
    mysqli_stmt_execute($stmt);
    }
}



/// SKILLS 
$newskills = $_POST['skills'];
    
    
$sql = "SELECT * FROM `retainer-skills` WHERE `Retainer-Type` LIKE ?";
if ($stmt = mysqli_prepare($conn,$sql)) {
    mysqli_stmt_bind_param($stmt, "i",$retainerid);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    // Loop through the SQL result and populate the array
    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                $skills[] = $row;
    }
    
    foreach ($newskills as $newskill) {
            if (in_array($newskill, array_column($skills,'Skill'))) {
                //do nothing if the skill is already in the array
//                echo "Skill already in array:" . $newskill . "<br>";
                reset($skills);
            } else {
                //add new skill if not found in the array
            $sql = "INSERT INTO `retainer-skills` (`Retainer-Skill-Cross-ID`, `Retainer-Type`,`Skill`) VALUES (NULL, ?, ?)";   
            if ($stmt = mysqli_prepare($conn,$sql)) {
//            echo "Found new skill to add:" . $newskill . "<br>";
            mysqli_stmt_bind_param($stmt,"ii", $retainerid, $newskill);
//            mysqli_report(MYSQLI_REPORT_ALL);
            mysqli_stmt_execute($stmt);
            reset($skills);
            }    
        }       
    }
    
    foreach ($skills as $skill) {
            if (in_array($skill['Skill'], $newskills)) {
                //do nothing if the skill is still in the array
//                echo "Skill still in array:" . $skill['Skill'] . "<br>";
                reset($newskills);
            } else {
                //delete many-to-many relationship new skill if not found in the array
            $sql = "DELETE FROM `retainer-skills` WHERE `Retainer-Type` LIKE ? AND `Skill` LIKE ?";   
            if ($stmt = mysqli_prepare($conn,$sql)) {
//            echo "Found skill to be removed:" . $skill['Skill'] . "<br>";
            mysqli_stmt_bind_param($stmt,"ii", $retainerid, $skill['Skill']);
            mysqli_stmt_execute($stmt);
            reset($newskills);
            }    
        }      
    }
    
//    $row = $result->fetch_array(MYSQLI_ASSOC);
//    echo "<pre>";
//    print_r($skills);
//    echo "</pre>";
    
    
///// SIGNATURE ATTACKS
$sql = "UPDATE `retainer-actions` SET `Retainer-Action-Name`= ?,`Is-Signature-Attack`= ?,`Retainer-Action-Type`= ?,`Retainer-Action-Duration`= ?,`Retainer-Action-Uses`= ?,`Retainer-Action-Text`= ? WHERE `Retainer-Action-ID` LIKE ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sissisi", $actionname, $sigattackbool, $actiontype, $actionduration, $actionuses, $actiontext, $actionid );
    $actionname = mysqli_real_escape_string($conn, $_POST['sig-one-name']);
    $sigattackbool = mysqli_real_escape_string($conn, $_POST['sig-one-bool']);
    if (!empty($_POST['sig-one-type'])) {
    $actiontype = mysqli_real_escape_string($conn, $_POST['sig-one-type']);
    } else {
        $actiontype = NULL;
    }
    $actionduration = mysqli_real_escape_string($conn, $_POST['sig-one-duration']);
    $actionuses = mysqli_real_escape_string($conn,$_POST['sig-one-uses']);
    $actiontext = mysqli_real_escape_string($conn,$_POST['sig-one-text']);
    $actionid = mysqli_real_escape_string($conn, $_POST['sig-one-id']);
    mysqli_stmt_execute($stmt); 
//    echo "Action-Duration: " . $actionduration . "<br>";

    if (!empty($currentsig2) and empty($_POST['sig-two-name'])) {
            $sql = "UPDATE `retainer` SET `Signature-Attack-2` = NULL WHERE `RetainerID` LIKE ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $retainerid);
            mysqli_stmt_execute($stmt); 
//            echo "Remove foreign key to signature-attack-2";
        }
        $sql = "DELETE FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $actionid);
            $actionid = mysqli_real_escape_string($conn, $_POST['sig-two-id']);
            mysqli_stmt_execute($stmt); 
        }
    }
    elseif (!empty($currentsig2)) {
    mysqli_stmt_bind_param($stmt, "sissisi", $actionname, $sigattackbool, $actiontype, $actionduration, $actionuses, $actiontext, $actionid );
    $actionname = mysqli_real_escape_string($conn, $_POST['sig-two-name']);
    $sigattackbool = mysqli_real_escape_string($conn, $_POST['sig-two-bool']);
    if (!empty($_POST['sig-two-type'])) {
        $actiontype = mysqli_real_escape_string($conn, $_POST['sig-two-type']);
    } else {
        $actiontype = NULL;
    }
    $actionduration = mysqli_real_escape_string($conn, $_POST['sig-two-duration']);
    $actionuses = mysqli_real_escape_string($conn,$_POST['sig2-uses']);
    $actiontext = mysqli_real_escape_string($conn,$_POST['sig-two-text']);
    $actionid = mysqli_real_escape_string($conn, $_POST['sig-two-id']);
    mysqli_stmt_execute($stmt); 
    } 
    
}

///// SPECIAL ACTIONS
// LEVEL 3
$sql = "UPDATE `retainer-actions` SET `Retainer-Action-Name`= ?,`Is-Signature-Attack`= ?,`Retainer-Action-Type`= ?,`Retainer-Action-Duration`= ?,`Retainer-Action-Uses`= ?,`Retainer-Action-Text`= ? WHERE `Retainer-Action-ID` LIKE ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sissisi", $actionname, $sigattackbool, $actiontype, $actionduration, $actionuses, $actiontext, $actionid );
    $actionname = mysqli_real_escape_string($conn, $_POST['spec-act-one-name']);
    $sigattackbool = 0;
    $actiontype = mysqli_real_escape_string($conn, $_POST['spec-act-one-type']);
    $actionduration = mysqli_real_escape_string($conn, $_POST['spec-act-one-duration']);
    $actionuses = mysqli_real_escape_string($conn,$_POST['spec2-uses']);
    $actiontext = mysqli_real_escape_string($conn,$_POST['spec-act-one-text']);
    $actionid = mysqli_real_escape_string($conn, $_POST['spec-one-id']);
    mysqli_stmt_execute($stmt); 
//    echo "Action-Duration: " . $actionduration . "<br>";
}

// LEVEL 5
$sql = "UPDATE `retainer-actions` SET `Retainer-Action-Name`= ?,`Is-Signature-Attack`= ?,`Retainer-Action-Type`= ?,`Retainer-Action-Duration`= ?,`Retainer-Action-Uses`= ?,`Retainer-Action-Text`= ? WHERE `Retainer-Action-ID` LIKE ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sissisi", $actionname, $sigattackbool, $actiontype, $actionduration, $actionuses, $actiontext, $actionid );
    $actionname = mysqli_real_escape_string($conn, $_POST['spec-act-two-name']);
    $sigattackbool = 0;
    $actiontype = mysqli_real_escape_string($conn, $_POST['spec-act-two-type']);
    $actionduration = mysqli_real_escape_string($conn, $_POST['spec-act-two-duration']);
    $actionuses = mysqli_real_escape_string($conn,$_POST['spec2-uses']);
    $actiontext = mysqli_real_escape_string($conn,$_POST['spec-act-two-text']);
    $actionid = mysqli_real_escape_string($conn, $_POST['spec-two-id']);
    mysqli_stmt_execute($stmt); 
    
//    echo "Action-Duration: " . $actionduration . "<br>";
}

// LEVEL 7
$sql = "UPDATE `retainer-actions` SET `Retainer-Action-Name`= ?,`Is-Signature-Attack`= ?,`Retainer-Action-Type`= ?,`Retainer-Action-Duration`= ?,`Retainer-Action-Uses`= ?,`Retainer-Action-Text`= ? WHERE `Retainer-Action-ID` LIKE ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sissisi", $actionname, $sigattackbool, $actiontype, $actionduration, $actionuses, $actiontext, $actionid );
    $actionname = mysqli_real_escape_string($conn, $_POST['spec-act-three-name']);
    $sigattackbool = 0;
    $actiontype = mysqli_real_escape_string($conn, $_POST['spec-act-three-type']);
    $actionduration = mysqli_real_escape_string($conn, $_POST['spec-act-three-duration']);
    $actionuses = mysqli_real_escape_string($conn,$_POST['spec3-uses']);
    $actiontext = mysqli_real_escape_string($conn,$_POST['spec-act-three-text']);
    $actionid = mysqli_real_escape_string($conn, $_POST['spec-three-id']);
    mysqli_stmt_execute($stmt);
//    echo "Action-Duration: " . $actionduration . "<br>";
}


    
    
    
    
    
    }

$retainerurl = $referer_parsed_path . "?id=" . $retainerid;     
array_push($changes, "Retainer Record Successfully Updated.");
    
//print_r($changes);
    
    
//header('location:' . $retainerurl);


} 


else {
    echo "You do not have permission to edit this Retainer Type.";
    header('location: index.php');
    
    }
}?>
