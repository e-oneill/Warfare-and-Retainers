<?php
include "db_connect.php";
$abilitymod = $_POST['abilitymod'];
$characterid = $_POST['characterid'];
$skillid = $_POST['skill'];
$profBonus = $_POST['profBonus'];


$sql = "SELECT `skill-id`,`expertise` FROM `character-skills` WHERE `character-id` LIKE $characterid";
$stmt = mysqli_prepare($conn, $sql);
$stmt->execute();
$result = $stmt->get_result();
$proficiencies = $result->fetch_all(MYSQLI_ASSOC);

if (array_search($skillid,array_column($proficiencies, 'skill-id'), FALSE)): {
$is_proficient = 1;
$abilitymod = $abilitymod + $profBonus;
} else: {
$is_proficient = 0;    
}    endif; 

if ($abilitymod > 0): {
   echo "+" . $abilitymod; 
} else: {
   echo $abilitymod;
} endif;
?>