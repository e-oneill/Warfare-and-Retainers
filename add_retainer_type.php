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


echo "<pre>";
print_r($_POST);
echo "</pre>";

$sql = "INSERT INTO `retainer-actions` (`Retainer-Action-ID`, `Retainer-Action-Name`,`Is-Signature-Attack`, `Retainer-Action-Type`, `Retainer-Action-Duration`, `Retainer-Action-Uses`, `Retainer-Action-Text`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "sissis", $sig_one_name, $is_sig, $sig_one_type, $sig_one_duration, $sig_one_uses, $sig_one_text);
    $sig_one_name = mysqli_real_escape_string($conn, $_POST['sig-one-name']);
    $is_sig = 1;
    $sig_one_type = mysqli_real_escape_string($conn, $_POST['sig-one-type']);
    $sig_one_duration = mysqli_real_escape_string($conn, $_POST['sig-one-duration']);
    $sig_one_uses = mysqli_real_escape_string($conn, $_POST['sig-one-uses']); 
    $sig_one_text = mysqli_real_escape_string($conn, $_POST['sig-one-text']);
    mysqli_stmt_execute($stmt);
    $sig_att_one = $stmt->insert_id;
}
    else {
        array_push($errors, "Failed adding signature attack 1");
    }

if (!empty($_POST['sig-two-name'])) {
    $sql = "INSERT INTO `retainer-actions` (`Retainer-Action-ID`, `Retainer-Action-Name`,`Is-Signature-Attack`, `Retainer-Action-Type`, `Retainer-Action-Duration`, `Retainer-Action-Uses`, `Retainer-Action-Text`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "sissis", $sig_two_name, $is_sig, $sig_two_type, $sig_two_duration, $sig_two_uses, $sig_two_text);
    $sig_two_name = mysqli_real_escape_string($conn, $_POST['sig-two-name']);
    $sig_two_text = mysqli_real_escape_string($conn, $_POST['sig-two-text']);
    $sig_two_type = mysqli_real_escape_string($conn, $_POST['sig-two-type']);
    $sig_two_duration = mysqli_real_escape_string($conn, $_POST['sig-two-duration']);
    $sig_two_uses = mysqli_real_escape_string($conn, $_POST['sig-two-uses']);
    $is_sig = 1;
    mysqli_stmt_execute($stmt);
    $sig_att_two = $stmt->insert_id;
}
    else {
        array_push($errors, "Failed adding signature attack 1");
    }
}

$sql = "INSERT INTO `retainer-actions` (`Retainer-Action-ID`, `Retainer-Action-Name`,`Is-Signature-Attack`, `Retainer-Action-Type`, `Retainer-Action-Duration`, `Retainer-Action-Uses`, `Retainer-Action-Text`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "sissis", $spec_act_one_name, $is_sig, $spec_act_one_type, $spec_act_one_duration, $spec_act_one_uses, $spec_act_one_text);
    $spec_act_one_name = mysqli_real_escape_string($conn, $_POST['spec-act-one-name']);
    $spec_act_one_text = mysqli_real_escape_string($conn, $_POST['spec-act-one-text']);
    $spec_act_one_type = mysqli_real_escape_string($conn, $_POST['spec-act-one-type']);
    $spec_act_one_duration = mysqli_real_escape_string($conn, $_POST['spec-act-one-duration']);
    $spec_act_one_uses = mysqli_real_escape_string($conn, $_POST['spec-act-one-uses']);
    $is_sig = 0;
    mysqli_stmt_execute($stmt);
    $spec_act_one = $stmt->insert_id;
}
    else {
        array_push($errors, "Failed adding level 3 special action");
    }

$sql = "INSERT INTO `retainer-actions` (`Retainer-Action-ID`, `Retainer-Action-Name`,`Is-Signature-Attack`, `Retainer-Action-Type`, `Retainer-Action-Duration`, `Retainer-Action-Uses`, `Retainer-Action-Text`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "sissis", $spec_act_two_name, $is_sig, $spec_act_two_type, $sig_two_duration, $sig_two_uses, $spec_act_two_text);
    $spec_act_two_name = mysqli_real_escape_string($conn, $_POST['spec-act-two-name']);
    $spec_act_two_text = mysqli_real_escape_string($conn, $_POST['spec-act-two-text']);
    $spec_act_two_type = mysqli_real_escape_string($conn, $_POST['spec-act-two-type']);
    $spec_act_two_duration = mysqli_real_escape_string($conn, $_POST['spec-act-two-duration']);
    $spec_act_two_uses = mysqli_real_escape_string($conn, $_POST['spec-act-two-uses']);
    $is_sig = 0;
    mysqli_stmt_execute($stmt);
    $spec_act_two = $stmt->insert_id;
}
    else {
        array_push($errors, "Failed adding level 5 special action");
    }
                                                
$sql = "INSERT INTO `retainer-actions` (`Retainer-Action-ID`, `Retainer-Action-Name`,`Is-Signature-Attack`, `Retainer-Action-Type`, `Retainer-Action-Duration`, `Retainer-Action-Uses`, `Retainer-Action-Text`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "sissis", $spec_act_three_name, $is_sig, $spec_act_three_type, $spec_act_three_duration, $spec_act_three_uses, $spec_act_three_text);
    $spec_act_three_name = mysqli_real_escape_string($conn, $_POST['spec-act-three-name']);
    $spec_act_three_text = mysqli_real_escape_string($conn, $_POST['spec-act-three-text']);
    $spec_act_three_type = mysqli_real_escape_string($conn, $_POST['spec-act-three-type']);
    $spec_act_three_duration = mysqli_real_escape_string($conn, $_POST['spec-act-three-duration']);
    $spec_act_three_uses = mysqli_real_escape_string($conn, $_POST['spec-act-three-uses']);
    $is_sig = 0;
    mysqli_stmt_execute($stmt);
    $spec_act_three = $stmt->insert_id;
}
    else {
        array_push($errors, "Failed adding level 7 special action");
    }
if (!empty($_POST['Retainer-Sec-Abi'])) {
    echo "Secondary Ability is set";
    if (!empty($sig_att_two)) {
        echo "Secondary Signature Attack is set";
        $sql = "INSERT INTO `retainer` (`RetainerID`,`RetainerName`, `Creator_user`,`RetainerBaseClass`,`Armor-Type`,`Retainer-Pri-Abi`,`Retainer-Secondary-Abi`, `Retainer-Save1`, `Retainer-Save2`, `Retainer-Abi-Weak`, `Signature-Attack-1`, `Signature-Attack-2`,`Special-Action-1`,`Special-Action-2`,`Special-Action-3`) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if($stmt = mysqli_prepare($conn,$sql)){
            $retainername = mysqli_real_escape_string($conn, $_POST['retainername']);
            $retainerbaseclass = mysqli_real_escape_string($conn, $_POST['RetainerBaseClass']);
            $armortype = mysqli_real_escape_string($conn, $_POST['armor-type']);
            $RetainerPriAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Pri-Abi']);
            $RetainerSecAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Sec-Abi']);
            $RetainerAbiWeak = null;
            $saves = $_POST['saves'];
            $skills = $_POST['skills'];
            $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
            $save1 =  mysqli_real_escape_string($conn,$saves[0]);
            if (!empty($saves[1])) {
            $save2 = mysqli_real_escape_string($conn,$saves[1]);
            }
            else {
            $save2 = NULL;
            }
            mysqli_stmt_bind_param($stmt, "siiiiiiiiiiiii", $retainername, $userid, $retainerbaseclass, $armortype, $RetainerPriAbi, $RetainerSecAbi, $save1, $save2, $RetainerAbiWeak, $sig_att_one,$sig_att_two,$spec_act_one,$spec_act_two,$spec_act_three);


            mysqli_stmt_execute($stmt);
            $retainer_id = $stmt->insert_id;
        }
    }
    else {
        echo "Secondary Signature Attack is not set";
        $sql = "INSERT INTO `retainer` (`RetainerID`,`RetainerName`, `Creator_user`,`RetainerBaseClass`,`Armor-Type`,`Retainer-Pri-Abi`,`Retainer-Secondary-Abi`, `Retainer-Save1`, `Retainer-Save2`, `Retainer-Abi-Weak`, `Signature-Attack-1`, `Special-Action-1`,`Special-Action-2`,`Special-Action-3`) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?)";
            if($stmt = mysqli_prepare($conn,$sql)){
            $retainername = mysqli_real_escape_string($conn, $_POST['retainername']);
            $retainerbaseclass = mysqli_real_escape_string($conn, $_POST['RetainerBaseClass']);
            $armortype = mysqli_real_escape_string($conn, $_POST['armor-type']);
            $RetainerPriAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Pri-Abi']);
            $RetainerSecAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Sec-Abi']);
            $RetainerAbiWeak = null;
            $saves = mysqli_real_escape_string($conn,$_POST['saves']);
            $skills = mysqli_real_escape_string($conn,$_POST['skills']);
            $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
            $save1 =  mysqli_real_escape_string($conn,$saves[0]);
            if (!empty($saves[1])) {
            $save2 = mysqli_real_escape_string($conn,$saves[1]);
            }
            else {
            $save2 = NULL;
            }
            mysqli_stmt_bind_param($stmt, "siiiiiiiiiiii", $retainername, $userid, $retainerbaseclass, $armortype, $RetainerPriAbi, $RetainerSecAbi, $save1, $save2, $RetainerAbiWeak, $sig_att_one,$spec_act_one,$spec_act_two,$spec_act_three);


            mysqli_stmt_execute($stmt);
            $retainer_id = $stmt->insert_id;
        }
    }
    
    }

    
    
    
    else {
            echo "Secondary Ability not set.";
        if (!empty($sig_att_two)) {
        echo "Secondary Signature Attack is set";
        $sql = "INSERT INTO `retainer` (`RetainerID`,`RetainerName`, `Creator_user`,`RetainerBaseClass`,`Armor-Type`,`Retainer-Pri-Abi`, `Retainer-Save1`, `Retainer-Save2`, `Retainer-Abi-Weak`, `Signature-Attack-1`, `Signature-Attack-2`,`Special-Action-1`,`Special-Action-2`,`Special-Action-3`) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if($stmt = mysqli_prepare($conn,$sql)){
            $retainername = mysqli_real_escape_string($conn, $_POST['retainername']);
            $retainerbaseclass = mysqli_real_escape_string($conn, $_POST['RetainerBaseClass']);
            $armortype = mysqli_real_escape_string($conn, $_POST['armor-type']);
            $RetainerPriAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Pri-Abi']);
            $RetainerSecAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Sec-Abi']);
            $RetainerAbiWeak = NULL;
            $saves = $_POST['saves'];
            $skills = $_POST['skills'];
            $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
            $save1 =  mysqli_real_escape_string($conn,$saves[0]);
            if (!empty($saves[1])) {
            $save2 = mysqli_real_escape_string($conn,$saves[1]);
            }
            else {
            $save2 = NULL;
            }
            mysqli_stmt_bind_param($stmt, "siiiiiiiiiiii", $retainername, $userid, $retainerbaseclass, $armortype, $RetainerPriAbi, $save1, $save2, $RetainerAbiWeak, $sig_att_one,$sig_att_two,$spec_act_one,$spec_act_two,$spec_act_three);


            mysqli_stmt_execute($stmt);
            $retainer_id = $stmt->insert_id;
        }
    }
    else {
        echo "Secondary Signature Attack is not set";
        $sql = "INSERT INTO `retainer` (`RetainerID`,`RetainerName`, `Creator_user`,`RetainerBaseClass`,`Armor-Type`,`Retainer-Pri-Abi`, `Retainer-Save1`, `Retainer-Save2`, `Retainer-Abi-Weak`, `Signature-Attack-1`, `Special-Action-1`,`Special-Action-2`,`Special-Action-3`) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?)";
            if($stmt = mysqli_prepare($conn,$sql)){
            $retainername = mysqli_real_escape_string($conn, $_POST['retainername']);
            $retainerbaseclass = mysqli_real_escape_string($conn, $_POST['RetainerBaseClass']);
            $armortype = mysqli_real_escape_string($conn, $_POST['armor-type']);
            $RetainerPriAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Pri-Abi']);
            $RetainerSecAbi = mysqli_real_escape_string($conn, $_POST['Retainer-Sec-Abi']);
            $RetainerAbiWeak = null;
            $saves = $_POST['saves'];
            $skills = $_POST['skills'];
            $userid = mysqli_real_escape_string($conn, $_SESSION['user_id']);
            $save1 =  mysqli_real_escape_string($conn,$saves[0]);
            if (!empty($saves[1])) {
            $save2 = mysqli_real_escape_string($conn,$saves[1]);
            }
            else {
            $save2 = NULL;
            }
            mysqli_stmt_bind_param($stmt, "siiiiiiiiiii", $retainername, $userid, $retainerbaseclass, $armortype, $RetainerPriAbi, $save1, $save2, $RetainerAbiWeak, $sig_att_one,$spec_act_one,$spec_act_two,$spec_act_three);


            mysqli_stmt_execute($stmt);
            $retainer_id = $stmt->insert_id;
        }
    }

    }
    
    if (!empty($skills)) {
        foreach ($skills as $skill) {
            $skill = mysqli_real_escape_string($conn,$skill);
            $sql = "INSERT INTO `retainer-skills` (`Retainer-Skill-Cross-ID`, `Retainer-Type`,`Skill`) VALUES (NULL, ?, ?)";
            if ($stmt = mysqli_prepare($conn,$sql)) {
            
            mysqli_stmt_bind_param($stmt,"ii", $retainer_id, $skill);
            mysqli_stmt_execute($stmt);
            }
            else {
                echo "Something is wrong with the Skill ID or Retainer ID used to fill many-to-many relationship";
            }
        }
    }

header("Location: retainertypes.php?");
?>
<br><a href="index.php">Return to Home</a>