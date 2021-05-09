<?php 
    session_start();
    include "db_connect.php";
    error_reporting(E_NOTICE);
    error_reporting(E_WARNING);

if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
}


?>
<?php
        if (!empty($_GET["id"])) {
        $characterid = mysqli_real_escape_string($conn,$_GET["id"]);

        $acbonus = 0;
        $acbonusstring = "";
        $defensebonusstring = "";
        $defensebonus = 0;
        $attacks = 1;

            
     $sql = "SELECT * FROM `characters` WHERE `character_id` LIKE ?";
    if($stmt = mysqli_prepare($conn,$sql)){
    mysqli_stmt_bind_param($stmt, "i", $characterid);
        if (mysqli_stmt_execute($stmt)){
            $stmt->execute();
            $result = $stmt->get_result();
                      
            $row = $result->fetch_array(MYSQLI_ASSOC);
//                    echo "<pre>";
//                        echo var_dump($row);
//                    echo "</pre>";
            
        if (!empty($_SESSION["user_id"])): {
            $userid = $_SESSION["user_id"];
            if ($userid == $characteruser): {
                $characterowner = 1;
                } endif;
            } else: {
                $characterowner = 0;
            } endif;

            $charactername = $row['Character Name']; 
            $characteruser = $row['User'];
            
            $sql = "SELECT `campaigns`.`campaign_id`, `campaigns`.`campaign_name`, `campaigns`.`campaign_owner`
                    FROM `campaigns`
                    LEFT JOIN `characters` ON `campaigns`.`campaign_id` = `characters`.`campaign`
                    WHERE `characters`.`character_id` = $characterid";
            if($stmt = mysqli_prepare($conn,$sql)): {
                if (mysqli_stmt_execute($stmt)): {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $campaign = $result->fetch_all(MYSQLI_ASSOC);
                    $campaignname = $campaign[0]['campaign_name'];
                    $campaigndm = $campaign[0]['campaign_owner'];
                } endif;
            } endif;
            
            $characterancestry = $row['Character Race'];
//            $characterclass = $row['Character Class'];
            $campaign = $row['campaign'];
            $level = $row['Character Level'];
            $characterheritage = $row['Character Subrace'];
//            $charactersubclass = $row['Character Subclass'];
            $currenthitdie = $row['hitdie'];

            $sql = "SELECT `character-classes`.`character-class-id`, `character-classes`.`class-id`, `character-classes`.`levels`, `character-classes`.`subclass-id`, `classes`.`name`, `character-classes`.`lvl-4-asi`, `character-classes`.`lvl-6-asi`, `character-classes`.`lvl-8-asi`, `character-classes`.`hitdice` FROM `character-classes`  
            INNER JOIN `classes` ON `character-classes`.`class-id` = `classes`.`id`
            WHERE `character-classes`.`character-id` LIKE $characterid";
            $result1 = $mysqli->query($sql);
            $classes = $result1->fetch_all(MYSQLI_ASSOC);

            $curr_hp = $row['Curr_HP'];
            $max_hp = $row['Max_HP'];
            $temp_hp = 0;
            $temp_hp = $row['TempHP'];
            
//            ABILITY SCORES
            
//            We start by taking the base scores
            $basestrength = $row['str'];
            $basedexterity = $row['dex'];
            $baseconstitution = $row['con'];
            $baseintelligence = $row['intell'];
            $basewisdom = $row['wis'];
            $basecharisma = $row['cha'];
            
//            Getting Racial and Subracial Scores
            $racestrength = $row['race-str'];
            $racedexterity = $row['race-dex'];
            $raceconstitution = $row['race-con'];
            $raceintelligence = $row['race-int'];
            $racewisdom = $row['race-wis'];
            $racecharisma = $row['race-cha'];

            $subracestrength = $row['subrace-str'];
            $subracedexterity = $row['subrace-dex'];
            $subraceconstitution = $row['subrace-con'];
            $subraceintelligence = $row['subrace-int'];
            $subracewisdom = $row['subrace-wis'];
            $subracecharisma = $row['subrace-cha'];

//            Getting ASIs
            
            for ($i=0; $i < count($classes); $i++) {
                $classlevel = $classes[$i]['levels'];
                if ($classlevel == 4): {
                    $lvl4asis = $classes[$i]['lvl-4-asi'];
                    $asi1 = substr($lvl4asis,0,1);
                        if ($asi1 == 1): {
                            $asistrength = $asistrength + 1;
                        } elseif ($asi1 == 2): {
                            $asidexterity = $asidexterity + 1;
                        } elseif ($asi1 == 3): {
                            $asiconstitution = $asiconstitution + 1;
                        } elseif ($asi1 == 4): {
                            $asiintelligence = $asiintelligence + 1;
                        } elseif ($asi1 == 5): {
                            $asiwisdom = $asiwisdom + 1;
                        } elseif ($asi1 == 6): {
                            $asicharisma = $asicharisma + 1;
                        } endif;
                    $asi2 = substr($lvl4asis,2,1);
                        if ($asi2 == 1): {
                            $asistrength = $asistrength + 1;
                        } elseif ($asi2 == 2): {
                            $asidexterity = $asidexterity + 1;
                        } elseif ($asi2 == 3): {
                            $asiconstitution = $asiconstitution + 1;
                        } elseif ($asi2 == 4): {
                            $asiintelligence = $asiintelligence + 1;
                        } elseif ($asi2 == 5): {
                            $asiwisdom = $asiwisdom + 1;
                        } elseif ($asi2 == 6): {
                            $asicharisma = $asicharisma + 1;
                        } endif;
                    } endif;
                    
            }
            


            $strength = $basestrength + $racestrength + $subracestrength + $asistrength;
            $dexterity = $basedexterity + $racedexterity + $subracedexterity + $asidexterity;
            $constitution = $baseconstitution + $raceconstitution + $subraceconstitution + $asiconstitution;
            $intelligence = $baseintelligence + $raceintelligence + $subraceintelligence + $asiintelligence;
            $wisdom = $basewisdom + $racewisdom + $subracewisdom + $asiwisdom;
            $charisma = $basecharisma + $racecharisma + $subracecharisma + $asicharisma;
            
// Strength
            if ($strength < 2): {
                $strengthmod = -5;
            } elseif ($strength < 4): {
                $strengthmod = -4;
            } elseif ($strength < 6): {
                $strengthmod = -3;
            } elseif ($strength < 8): {
                $strengthmod = -2;
            } elseif ($strength < 10): {
                $strengthmod = -1;
            } elseif ($strength < 12): {
                $strengthmod = 0;
            } elseif ($strength < 14): {
                $strengthmod = 1;
            } elseif ($strength < 16): {
                $strengthmod = 2;
            } elseif ($strength < 18): {
                $strengthmod = 3;
            } elseif ($strength < 20): {
                $strengthmod = 4;
            } elseif ($strength < 22): {
                $strengthmod = 5;
            } elseif ($strength < 24): {
                $strengthmod = 6;
            } elseif ($strength < 26): {
                $strengthmod = 7;
            } elseif ($strength < 28): {
                $strengthmod = 8;
            } elseif ($strength < 30): {
                $strengthmod = 9;
            } else: {
                $strengthmod = 10;
            } endif;

// Dexterity
            if ($dexterity < 2): {
                $dexteritymod = -5;
            } elseif ($dexterity < 4): {
                $dexteritymod = -4;
            } elseif ($dexterity < 6): {
                $dexteritymod = -3;
            } elseif ($dexterity < 8): {
                $dexteritymod = -2;
            } elseif ($dexterity < 10): {
                $dexteritymod = -1;
            } elseif ($dexterity < 12): {
                $dexteritymod = 0;
            } elseif ($dexterity < 14): {
                $dexteritymod = 1;
            } elseif ($dexterity < 16): {
                $dexteritymod = 2;
            } elseif ($dexterity < 18): {
                $dexteritymod = 3;
            } elseif ($dexterity < 20): {
                $dexteritymod = 4;
            } elseif ($dexterity < 22): {
                $dexteritymod = 5;
            } elseif ($dexterity < 24): {
                $dexteritymod = 6;
            } elseif ($dexterity < 26): {
                $dexteritymod = 7;
            } elseif ($dexterity < 28): {
                $dexteritymod = 8;
            } elseif ($dexterity < 30): {
                $dexteritymod = 9;
            } else: {
                $dexteritymod = 10;
            } endif;

// Constitution
            if ($constitution < 2): {
                $constitutionmod = -5;
            } elseif ($constitution < 4): {
                $constitutionmod = -4;
            } elseif ($constitution < 6): {
                $constitutionmod = -3;
            } elseif ($constitution < 8): {
                $constitutionmod = -2;
            } elseif ($constitution < 10): {
                $constitutionmod = -1;
            } elseif ($constitution < 12): {
                $constitutionmod = 0;
            } elseif ($constitution < 14): {
                $constitutionmod = 1;
            } elseif ($constitution < 16): {
                $constitutionmod = 2;
            } elseif ($constitution < 18): {
                $constitutionmod = 3;
            } elseif ($constitution < 20): {
                $constitutionmod = 4;
            } elseif ($constitution < 22): {
                $constitutionmod = 5;
            } elseif ($constitution < 24): {
                $constitutionmod = 6;
            } elseif ($constitution < 26): {
                $constitutionmod = 7;
            } elseif ($constitution < 28): {
                $constitutionmod = 8;
            } elseif ($constitution < 30): {
                $constitutionmod = 9;
            } else: {
                $constitutionmod = 10;
            } endif;

// Intelligence
            if ($intelligence < 2): {
                $intelligencemod = -5;
            } elseif ($intelligence < 4): {
                $intelligencemod = -4;
            } elseif ($intelligence < 6): {
                $intelligencemod = -3;
            } elseif ($intelligence < 8): {
                $intelligencemod = -2;
            } elseif ($intelligence < 10): {
                $intelligencemod = -1;
            } elseif ($intelligence < 12): {
                $intelligencemod = 0;
            } elseif ($intelligence < 14): {
                $intelligencemod = 1;
            } elseif ($intelligence < 16): {
                $intelligencemod = 2;
            } elseif ($intelligence < 18): {
                $intelligencemod = 3;
            } elseif ($intelligence < 20): {
                $intelligencemod = 4;
            } elseif ($intelligence < 22): {
                $intelligencemod = 5;
            } elseif ($intelligence < 24): {
                $intelligencemod = 6;
            } elseif ($intelligence < 26): {
                $intelligencemod = 7;
            } elseif ($intelligence < 28): {
                $intelligencemod = 8;
            } elseif ($intelligence < 30): {
                $intelligencemod = 9;
            } else: {
                $intelligencemod = 10;
            } endif;

// Wisdom
            if ($wisdom < 2): {
                $wisdommod = -5;
            } elseif ($wisdom < 4): {
                $wisdommod = -4;
            } elseif ($wisdom < 6): {
                $wisdommod = -3;
            } elseif ($wisdom < 8): {
                $wisdommod = -2;
            } elseif ($wisdom < 10): {
                $wisdommod = -1;
            } elseif ($wisdom < 12): {
                $wisdommod = 0;
            } elseif ($wisdom < 14): {
                $wisdommod = 1;
            } elseif ($wisdom < 16): {
                $wisdommod = 2;
            } elseif ($wisdom < 18): {
                $wisdommod = 3;
            } elseif ($wisdom < 20): {
                $wisdommod = 4;
            } elseif ($wisdom < 22): {
                $wisdommod = 5;
            } elseif ($wisdom < 24): {
                $wisdommod = 6;
            } elseif ($wisdom < 26): {
                $wisdommod = 7;
            } elseif ($wisdom < 28): {
                $wisdommod = 8;
            } elseif ($wisdom < 30): {
                $wisdommod = 9;
            } else: {
                $wisdommod = 10;
            } endif;

// Charisma
            if ($charisma < 2): {
                $charismamod = -5;
            } elseif ($charisma < 4): {
                $charismamod = -4;
            } elseif ($charisma < 6): {
                $charismamod = -3;
            } elseif ($charisma < 8): {
                $charismamod = -2;
            } elseif ($charisma < 10): {
                $charismamod = -1;
            } elseif ($charisma < 12): {
                $charismamod = 0;
            } elseif ($charisma < 14): {
                $charismamod = 1;
            } elseif ($charisma < 16): {
                $charismamod = 2;
            } elseif ($charisma < 18): {
                $charismamod = 3;
            } elseif ($charisma < 20): {
                $charismamod = 4;
            } elseif ($charisma < 22): {
                $charismamod = 5;
            } elseif ($charisma < 24): {
                $charismamod = 6;
            } elseif ($charisma < 26): {
                $charismamod = 7;
            } elseif ($charisma < 28): {
                $charismamod = 8;
            } elseif ($charisma < 30): {
                $charismamod = 9;
            } else: {
                $charismamod = 10;
            } endif;


//Proficiency Bonus
            if ($level < 5): {
                $profbonus = 2;
            } elseif ($level < 9): {
                $profbonus = 3;
            } elseif ($level < 13): {
                $profbonus = 4;
            } elseif ($level < 17): {
                $profbonus = 5; 
            } else: {
                $profbonus = 6;
            } endif;
            
//            $sql = "SELECT `name` FROM `classes` WHERE `id`LIKE $characterclass";
//            $result1 = $mysqli->query($sql);
//            $row1 = $result1->fetch_assoc();
//            $classname = $row1['name'];
            

//            echo "<pre>";
//            print_r($classes);
//            echo "</pre>";
            

                
            $sql = "SELECT * FROM `races` WHERE `race-id`LIKE $characterancestry";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $ancestryname = $row1['name'];
            $speed = $row1['race-speed'];
            
            $sql = "SELECT `campaign_name` FROM `campaigns` WHERE `campaign_id`LIKE $campaign";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $campaignname = $row1['campaign_name'];
            
            if (!empty($characterheritage)): {
            $sql = "SELECT `name` FROM `subraces` WHERE `id`LIKE $characterheritage";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $heritagename = $row1['name'];
            $heritagespeed = $row1['subrace-speed'];
            if (!empty($heritagespeed)): {
                $speed = $speed + $heritagespeed;
            } endif;
//            unset($characterheritage);
            } else: {
               $heritagename = "None"; 
            } endif;
            
            $breadcrumbname = $charactername;
            
            for ($i=0; $i < count($classes); $i++) {
                $classname = $classes[$i]['name'];
                $subclassid = $classes[$i]['subclass-id'];
                $classlevel = $classes[$i]['levels'];
                $classid = $classes[$i]['class-id'];
                $classhitdice = $classes[$i]['hitdice'];
                $classrelationship = $classes[$i]['character-class-id'];
                

                
                $sql = "SELECT * FROM `classes` WHERE `id` LIKE $classid";
                $result1 = $mysqli->query($sql);
                $row1 = $result1->fetch_assoc();
                $extra_attack1 = $row1['extra-attack-1'];
                $extra_attack2 = $row1['extra-attack-2'];
                $extra_attack3 = $row1['extra-attack-3'];
                $hitdie = $row1['hitdie'];
                
                $hitdiearr = array (
                        'class' => $classname,
                        'class-id' => $classid,
                        'hitdie' => $hitdie,
                        'levels' => $classlevel,
                        'hitdice' => $classhitdice,
                        'relationship-id' => $classrelationship
                    );
                
                $mdhitdie_array[] = $hitdiearr;
                
                if ($classlevel >= $extra_attack3): {
                    $attacks = 4;
                } elseif ($classlevel >= $extra_attack2): {
                    $attacks = 3;
                } elseif ($classlevel >= $extra_attack1): {
                    $attacks = 2;
                } endif;
                   
//                $characterclass = $classes[$i]['class-id'];
               if (!empty($subclassid)): {
                        $subclassid = $classes[$i]['subclass-id'];
//                        $charactersubclass = $subclassid;
                        $sql = "SELECT `name` FROM `subclasses` WHERE `id` LIKE $subclassid";
                        $result1 = $mysqli->query($sql);
                        $row1 = $result1->fetch_assoc();
                        $subclassname = $row1['name'];
            //            unset($charactersubclass);
                } endif;

                        
            
                if (!empty($subclassname)):{
                    if ($breadcrumbname === $charactername): {
                        $breadcrumbname = $breadcrumbname . " - " . $ancestryname . " Level " . $classlevel ." " .  $classname . " (" . $subclassname . ")";
                    } else: {
                        $breadcrumbname = $breadcrumbname . " / Level " . $classlevel . " " . " " . $classname . " (" . $subclassname . ")";    
                    } endif;
                    if (empty($classchunk)): {
                        $classchunk = $classname . " (" . $subclassname . ")";
                    } else: {
                        $classchunk = $classchunk . " / ". $classname . " (" . $subclassname . ")";
                    } endif;
                } else: {
                    if ($breadcrumbname === $charactername): {
                        $breadcrumbname = $breadcrumbname . " - " . $ancestryname . " Level " . $classlevel ." " .  $classname;
                    } else: {
                        $breadcrumbname = $breadcrumbname . " / Level " . $classlevel . " " . " " . $classname;
                    } endif;
                    $classchunk = $classchunk . " / " . $classname;
                } endif;
                unset($subclassname);
            }
            
            
 
            
//            CHARACTER INVENTORY
            
        $sql = "SELECT * 
            FROM `character-inventories` 
            INNER JOIN `items` ON `character-inventories`.`item-id` = `items`.`Item-ID` 
            WHERE `character-inventories`.`character-id` LIKE ?";
            
            
                
        if($stmt = mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($stmt, "i", $characterid);
        if (mysqli_stmt_execute($stmt)){
            $stmt->execute();
            $result = $stmt->get_result();

            $inventory = $result->fetch_all(MYSQLI_ASSOC);


        }
        }

//            Attunable Items
            
        $sql = "SELECT * 
                FROM `character-inventories` 
                INNER JOIN `items` ON `character-inventories`.`item-id` = `items`.`Item-ID` 
                WHERE `character-inventories`.`character-id` LIKE ? AND `items`.`requires-attunement` LIKE 1";

        if($stmt = mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($stmt, "i", $characterid);
        if (mysqli_stmt_execute($stmt)){
            $stmt->execute();
            $result = $stmt->get_result();

            $attunementitems = $result->fetch_all(MYSQLI_ASSOC);


            }   
        }

//            Attuned Items

        ?>
<!doctype html>
<html>
    
<head>
    <title>Monkehh's DM Tools</title>
   <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="dmtools.css" rel="stylesheet" type="text/css">

<script>
var RestDiv; 
var characterid = <?php echo $characterid; ?>
    
    $(document).ready(function() {
        
        $('[data-toggle="tooltip"]').tooltip();
        
        var currentHP = <?php echo $curr_hp ?>;
        var tempHP = <?php 
            if (!empty($temp_hp)) :{
                echo $temp_hp;     
            } else: {
                echo 0;
            } endif;

            
            ?>;
        var maxHP = <?php echo $max_hp ?>;
        var characterid = <?php echo $characterid ?>;
        var HPModifier = 0;

        $("#btn-heal").click(function(){
            
            HPModifier = parseInt(document.getElementById("hp-changer").value);
            if (HPModifier > 0) {
            if ((currentHP + HPModifier) > maxHP){
                currentHP = maxHP;
            } else {
            currentHP = currentHP + HPModifier;
            }
            $("#curr-hp").load("hp_handler.php", {newHP: currentHP, characterid: characterid}); 
            }
            });
        $("#btn-dmg").click(function(){
            HPModifier = parseInt(document.getElementById("hp-changer").value);
            if (HPModifier > 0) {
            if ((currentHP + tempHP - HPModifier) < 0){
                currentHP = 0;
            } else {
                if (tempHP > HPModifier) {
                    tempHP = tempHP - HPModifier;
                } else {
                    currentHP = currentHP - HPModifier + tempHP;
                    tempHP = 0; 
                }
            }
            $("#curr-hp").load("hp_handler.php", {newHP: currentHP, characterid: characterid});
            $("#temp-hp").load("hp_handler.php", {tempHP: tempHP, characterid: characterid});
            }
            });
        $("#btn-temp").click(function(){
            tempHP = parseInt(window.prompt("How many Temporary Hitpoints to add?"));
            $("#temp-hp").load("hp_handler.php", {tempHP: tempHP, characterid: characterid});
            });
        });

function skillselector(selector){
    var id = selector.id;
    var selectedABI = $(selector).val();
    var skill = id.substring(0,1);
    var divToUpdate = "#" + skill + "-bonus";
    var characterid = <?php echo $characterid ?>;
    var profBonus = <?php echo $profbonus; ?>;
    
    if (selectedABI == 1) {
    var abilitymod = <?php echo $strengthmod; ?>;    
    } else if (selectedABI == 2) {
    var abilitymod = <?php echo $dexteritymod; ?>;        
    } else if (selectedABI == 3) {
    var abilitymod = <?php echo $constitutionmod; ?>;        
    } else if (selectedABI == 4) {
    var abilitymod = <?php echo $intelligencemod; ?>;
    } else if (selectedABI == 5) {
    var abilitymod = <?php echo $wisdommod; ?>; 
    } else if (selectedABI == 6) {
    var abilitymod = <?php echo $charismamod; ?>;    
    }
    
//    alert("Skill Selector Changed: " + id + "\nSkill Selected: " + skill + "\nSelected Ability ID: " + selectedABI + "\nDiv to be updated: " + divToUpdate + "\nAbility Modifier: " + abilitymod + "\nCharacter: " + characterid + "\nProf Bonus: " + profBonus);
    
    $(divToUpdate).load("skill-bonus-handler.php", {selectedABI: selectedABI, skill: skill, abilitymod: abilitymod, characterid: characterid, profBonus: profBonus});
    
    
}
    
    //This function manages the display of the tabs for the central box. 
function boxpaginator(selected) {
    var Actions = document.getElementById("actionsdiv");
    var Features = document.getElementById("featuresdiv");
    var Inventory = document.getElementById("inventorydiv");
    var Spells = document.getElementById("spellsdiv");
    var Retainers = document.getElementById("retainersdiv");
    var featurescontainer = document.getElementById("features-container").childNodes;
    
    if (selected === "Features") {
    Actions.style.display = "none";
    Spells.style.display = "none";
    Features.style.display = "block";
    Inventory.style.display = "none";
    Retainers.style.display = "none";
    } else if (selected === "Actions") {
    Actions.style.display = "block";
    Spells.style.display = "none";
    Features.style.display = "none";
    Inventory.style.display = "none";
    Retainers.style.display = "none";
    } else if (selected === "Inventory") {
    Actions.style.display = "none";
    Spells.style.display = "none";
    Features.style.display = "none";
    Inventory.style.display = "block";
    Retainers.style.display = "none";
    } else if (selected === "Spells") {
    Actions.style.display = "none";
    Spells.style.display = "block";
    Features.style.display = "none";
    Inventory.style.display = "none";
    Retainers.style.display = "none";
    } else if (selected === "Retainers") {
    Actions.style.display = "none";
    Spells.style.display = "none";
    Features.style.display = "none";
    Inventory.style.display = "none";
    Retainers.style.display = "block";        
    }
}

function tablesearch(inputfield, searchfield) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById(inputfield);
  filter = input.value.toUpperCase();
  table = document.getElementById("inventory-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 1; i < (tr.length - 1); i+=2) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        if (tr[i].classList.contains("ButtonFiltered")){
        tr[i].classList.remove("SearchFiltered");
        } else {
        tr[i].style.display = "";
        tr[i].classList.remove("SearchFiltered");
//        tr[i+1].style.display = "";
        }
      } else {
        tr[i].style.display = "none";
        tr[i].classList.add("SearchFiltered");
//        tr[i+1].style.display = "none";
      }
    }
  }
}

function equipgear(item) {
    checkboxused = item.id;
    equipped = $('#' + checkboxused).prop('checked');
    inventoryentry = checkboxused.substring(0,1);
    
    if (equipped === true) {
        equipped = 1;
    } else {
        equipped = 0;
    }
    
//    alert(inventoryentry + "\n" + equipped);
    
    $.ajax({
        method: "post",
        url: "equipment.php",
        data: {inventoryentry: inventoryentry, equipped: equipped },
        success: function() {
            $("#ACDiv").load(location.href + " #ACDiv", function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
            $("#actionsdiv").load(location.href + " #actionsdiv", function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            
        }    
    });
    
    
}
    
 
    
function hitdie(checkbox,relationship) {
    checkboxused = checkbox.id;
//    restDiv = checkbox.parentNode.parentNode.id;
//    alert(restDIV);
    hitdiespent = $('#' + checkboxused).prop('checked');
    
    if (hitdiespent === true) {
        hitdiespent = 1
    } else {
        hitdiespent = 0
    }
    
    $.ajax({
        method: "post",
        url: "hitdice.php",
        data: {relationship: relationship, hitdiespent: hitdiespent},
        success: function() {
            if (checkbox.parentNode.parentNode.id == "short-rest-block") {
                $("#long-rest-block").load(window.location.href + " #long-rest-block" );
            } else if (checkbox.parentNode.parentNode.id == "long-rest-block"){
                $("#short-rest-block").load(window.location.href + " #short-rest-block" );
            }
            
            
        }
    });

}
    
function changebuttontext(button,text) {
    button.innerHTML = text;
}
    
function completerest(button,type) {
    if (type == "Short") {
    for (var i=0; i <localStorage.length; i++){
        AbiArr = window.localStorage.getItem(localStorage.key(i));
        if (AbiArr.abilityrecharge == "Short Rest" && AbiArr.characterid == <?php echo $characterid; ?>)  {
            AbiArr.abilitystatus = 0;
            window.localStorage.setItem(localStorage.key(i), JSON.stringify(AbiArr));
        } 
    }
    button.innerHTML = "Take a Short Rest";
    btn.classList.add('btn-success');
    btn.classList.remove('btn-warning');
    } else if (type == "Long") {
    for (var i=0; i <localStorage.length; i++){
        AbiArr = window.localStorage.getItem(localStorage.key(i));
        if (AbiArr.abilityrecharge == "Short Rest" && AbiArr.characterid == <?php echo $characterid; ?>) {
            AbiArr.abilitystatus = 0;
            window.localStorage.setItem(localStorage.key(i), JSON.stringify(AbiArr));
        } else if (AbiArr.abilityrecharge == "Long Rest" && AbiArr.characterid == <?php echo $characterid; ?>) {
            AbiArr.abilitystatus = 0;
            window.localStorage.setItem(localStorage.key(i), JSON.stringify(AbiArr));
        }
        
    }

    $.ajax({
        method: "post",
        url: "hitdice.php",
        data: {characterid: characterid},
        success: function() {
            
                $("#long-rest-block").load(window.location.href + " #long-rest-block" );
            
                $("#short-rest-block").load(window.location.href + " #short-rest-block" );
            
            
            
        }
    });
    
    button.innerHTML = "Take a Long Rest"
    btn.classList.add('btn-success');
    btn.classList.remove('btn-warning');    
    }
    
    $("#actionsdiv").load(window.location.href + " #actionsdiv" );
    $("#featuresdiv").load(window.location.href + " #features-inner-div" );
}
    
function rest(button, type) {
//    alert(button + " " + type);
    btn = document.getElementById(button);
          
    btn.classList.remove('btn-success');
    btn.classList.add('btn-warning');
    if (type == "Short") {
    changebuttontext(btn,"Taking short rest, click to cancel... 3");
    setTimeout(() => {changebuttontext(btn,"Taking short rest, click to cancel... 2");}, 1000);
    setTimeout(() => {changebuttontext(btn,"Taking short rest, click to cancel... 1");}, 2000);
    setTimeout(() => {completerest(btn,type);}, 3000);
    } else if (type == "Long") {
    changebuttontext(btn,"Taking long rest, click to cancel... 3");
    setTimeout(() => {changebuttontext(btn,"Taking long rest, click to cancel... 2");}, 1000);
    setTimeout(() => {changebuttontext(btn,"Taking long rest, click to cancel... 1");}, 2000);
    setTimeout(() => {completerest(btn,type);}, 3000);        
    }
}

function viewretainer(retainerid) {
    if (retainerid === "Return to table") {
    document.getElementById("retainer-card-container").style.display = "none";
    document.getElementById("retainers-table").style.display = "block";        
    } else {
    $("#retainer-card").load("retainercardgenerator.php", {id: retainerid});
    document.getElementById("retainer-card-container").style.display = "block";
    document.getElementById("retainers-table").style.display = "none";
    }
}

function panelselection(Tab, SubTab) {
    if (Tab === "Features") {
        if (SubTab === "All") {
            document.getElementById("classfeatures").style.display = "block";
            document.getElementById("racefeatures").style.display = "block";
            document.getElementById("featsfeatures").style.display = "block";
        }
        else if (SubTab === "Class") {
            document.getElementById("classfeatures").style.display = "block";
            document.getElementById("racefeatures").style.display = "none";
            document.getElementById("featsfeatures").style.display = "none";
        }
        else if (SubTab === "Racial") {
            document.getElementById("classfeatures").style.display = "none";
            document.getElementById("racefeatures").style.display = "block";
            document.getElementById("featsfeatures").style.display = "none";
        }
        else if (SubTab === "Feats") {
            document.getElementById("classfeatures").style.display = "none";
            document.getElementById("racefeatures").style.display = "none";
            document.getElementById("featsfeatures").style.display = "block";
        }
    } else if (Tab === "Actions") {
        if (SubTab === "All") {
        document.getElementById("attacks").style.display = "block";
        document.getElementById("generalactions").style.display = "block";
        document.getElementById("bonusactions").style.display = "block";
        document.getElementById("reactions").style.display = "block";
        } else if (SubTab === "Attacks") {
        document.getElementById("attacks").style.display = "block";
        document.getElementById("generalactions").style.display = "none";
        document.getElementById("bonusactions").style.display = "none";
        document.getElementById("reactions").style.display = "none";            
        } else if (SubTab === "Combat Actions") {
        document.getElementById("attacks").style.display = "none";
        document.getElementById("generalactions").style.display = "block";
        document.getElementById("bonusactions").style.display = "none";
        document.getElementById("reactions").style.display = "none";            
        } else if (SubTab === "Bonus Actions") {
        document.getElementById("attacks").style.display = "none";
        document.getElementById("generalactions").style.display = "none";
        document.getElementById("bonusactions").style.display = "block";
        document.getElementById("reactions").style.display = "none";            
        } else if (SubTab === "Reactions") {
        document.getElementById("attacks").style.display = "none";
        document.getElementById("generalactions").style.display = "none";
        document.getElementById("bonusactions").style.display = "none";
        document.getElementById("reactions").style.display = "block";               
        }
    }
}

function storeAbilityUse(checkbox, recharge) {
    checkboxelem = document.getElementById(checkbox);
    AbilityUsed = $('#' + checkbox).prop('checked');
    if (AbilityUsed === true) {
        const AbiArray = {
            type: "char-sheet-action",
            characterid: <?php echo $characterid ?>,
            abilitystatus: 1,
            abilityrecharge: "Short Rest",
        }
        window.localStorage.setItem(checkbox, JSON.stringify(AbiArray));
    } else {
        const AbiArray = {
            type: "char-sheet-action",
            characterid: <?php echo $characterid ?>,
            abilitystatus: 0,
            abilityrecharge: "Short Rest",
        }
        window.localStorage.setItem(checkbox, JSON.stringify(AbiArray));        
    }
    
}
    
function checkAbilityUse(checkbox, recharge) {
    if (window.localStorage.getItem(checkbox) === null){
        document.getElementById(checkbox).checked = false;
    } else {
      AbiArr = JSON.parse(window.localStorage.getItem(checkbox));
        if (AbiArr.abilitystatus == 1) {
            document.getElementById(checkbox).checked = true;
            
        } else {
            document.getElementById(checkbox).checked = false;
        }
    }
    
    
}

</script>    
    
    </head>
<body>
<?php include "page-header.php"; 

    ?>

    
    
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a href="mycharacters.php">My Characters</a></li>
    <li class="breadcrumb-item"><a><?php echo $breadcrumbname; ?></a></li>
  </ol>
</nav>
<div id="retainer-container" class="container-flex retainer-container">
<div class="row" style="max-width:97vw;">
<div id="retainer-col" class="col-md-12">  
<!--    -->
<!-- NAME AND LEVEL BLOCK   -->
<!--    -->
<div class="row" style="display:none;">
        <div class="col-12 col-md-4">
<!--            <a class="charsheet-heading">Character Name</a> <br>-->
            <span class="charsheet-name">
        <?php 
        echo $charactername;    
            ?>
            </span><br>
            <a><?php echo $classchunk; ?></a>
        </div>
        <div class="col-12 col-md-4">
        <div class="row">
            <div class="col-6">
            <a class="charsheet-heading">Level</a> <br>
            <a class="charsheet-text">
          <?php 
        echo $level;    
            ?>   
                </a>
            </div>
            <div class="col-6">
                <a class="charsheet-heading">Experience Points</a>
                <a class="charsheet-text"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <a class="charsheet-heading">Ancestry</a> <br> 
            <a class="charsheet-text">
          <?php 
        echo $ancestryname;    
            ?> 
                </a>
            </div>
            <div class="col-6">
                <a class="charsheet-heading">Heritage</a> <br>
            <a class="charsheet-text">
          <?php 
        echo $heritagename;    
            ?> 
                </a>
            </div>
        </div>
        </div>

</div>
    
<div class="row">
    <div class="col-12">
    <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#short-rest-cont">Short Rest</button>
    <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#long-rest-cont">Long Rest</button>
    <div id="rest-accordion">   
        <div class="collapse col-xl-3 rest-block" id="short-rest-cont" data-parent="#rest-accordion">
            <div id="short-rest-block">
            <a>Short Rest</a><br>
            <p>During a short rest, some abilities recover and you can spend any number of Hit Dice to recover hit points. You roll a dice, of a size based on your class or classes, and add your constitution modifier.</p>

            <?php

            for ($i=0; $i < count($mdhitdie_array); $i++) {
                $classlevels = $mdhitdie_array[$i]['levels'];
                $classhitdie = $mdhitdie_array[$i]['hitdie'];
                $currenthitdie = $mdhitdie_array[$i]['hitdice'];
                $relationship = $mdhitdie_array[$i]['relationship-id'];
                $hitdieused = $classlevels - $currenthitdie;

                ?>
                <div class="hitdie">
                    <?php
                    echo "d" . $classhitdie . "+" . $constitutionmod . "<br>";
                    for ($x=1; $x <= $classlevels; $x++) {
                        if ($x <= $hitdieused): {
                            echo '<input type="checkbox" class="hitdie-checkbox" name="hitdie" id="hitdie-' . $x . '" value="' . $x . '" checked onclick="hitdie(this,' . $relationship . ')">';   
                        } else: {
                            echo '<input type="checkbox" class="hitdie-checkbox" name="hitdie" id="hitdie-' . $x . '" value="' . $x . '"  onclick="hitdie(this,' . $relationship . ')">';
                        } endif;
                    }

                ?>    
                </div>    
            <?php
            }            
            ?>
                <button class="btn btn-success" id="short-rest-confirm" style="margin:0.25rem; margin-left:0rem; width:100%" onclick="rest(this.id,'Short')">Take Short Rest</button>
            </div>
        </div>
        <div class="collapse col-xl-3 rest-block" id="long-rest-cont" data-parent="#rest-accordion">
            <div id="long-rest-block">
            <a>Long Rest</a><br>
            <p>Before taking a long rest, you regain half of your hit dice. You can then spend any amount of hit dice. You also regain one level of exhaustion.</p>

            <?php

            for ($i=0; $i < count($mdhitdie_array); $i++) {
                $classlevels = $mdhitdie_array[$i]['levels'];
                $classhitdie = $mdhitdie_array[$i]['hitdie'];
                $currenthitdie = $mdhitdie_array[$i]['hitdice'];
                $relationship = $mdhitdie_array[$i]['relationship-id'];
                $hitdieused = $classlevels - $currenthitdie;

                ?>
                <div class="hitdie">
                    <?php
                    echo "d" . $classhitdie . "+" . $constitutionmod . "<br>";
                    for ($x=1; $x <= $classlevels; $x++) {
                        if ($x <= $hitdieused): {
                            echo '<input type="checkbox" class="hitdie-checkbox" name="hitdie" id="hitdie-' . $x . '" value="' . $x . '" checked onclick="hitdie(this,' . $relationship . ')">';   
                        } else: {
                            echo '<input type="checkbox" class="hitdie-checkbox" name="hitdie" id="hitdie-' . $x . '" value="' . $x . '"  onclick="hitdie(this,' . $relationship . ')">';
                        } endif;
                    }

                ?>    
                </div>    
            <?php
            }            
            ?>
                <button class="btn btn-success" id="long-rest-confirm" style="margin:0.25rem; margin-left:0rem; width:100%" onclick="rest(this.id,'Long')">Take Long Rest</button>
            </div>
        </div>
    </div>
    </div>    
</div>
<!--    -->
<!--  ABILITY SCORES BLOCK  -->
<!--    -->
<div class="row charsheet-abilities-block">
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                    <a class="charsheet-abi-name">Strength</a> <br>
                    <a class="charsheet-abi-score">
                            <?php 
                            if ($strengthmod > 0): {
                                echo "+ " . $strengthmod; 
                            } else: {
                                echo $strengthmod;
                            } endif;
                            ?>

                    </a>
                    <div class="abi-mod-container" style="margin-bottom: 2rem;">
                        <div class="content">
                            <a class="charsheet-abi-mod">
                            <?php 
                                echo $strength;
                            ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                    <a class="charsheet-abi-name">Dexterity</a> <br>
                    <a class="charsheet-abi-score">
                        <?php 
                        if ($dexteritymod > 0): {
                            echo "+" . $dexteritymod; 
                        } else: {
                            echo $dexteritymod;
                        } endif;
                        ?>
                    </a>
                    <div class="abi-mod-container">
                        <div class="content">
                            <a class="charsheet-abi-mod">

                            <?php 
                                echo $dexterity;
                            ?>                            
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                    <a class="charsheet-abi-name">Constitution</a> <br>
                    <a class="charsheet-abi-score">                    
                        <?php 
                            if ($constitutionmod > 0): {
                                echo "+" . $constitutionmod; 
                            } else: {
                                echo $constitutionmod;
                            } endif;
                        ?> 
                    </a>
                    <div class="abi-mod-container">
                        <div class="content">
                            <a class="charsheet-abi-mod">
                        <?php 
                            echo $constitution;
                        ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                    <a class="charsheet-abi-name">Intelligence</a> <br>
                    <a class="charsheet-abi-score">                    
                    <?php 
                        if ($intelligencemod > 0): {
                            echo "+" . $intelligencemod; 
                        } else: {
                            echo $intelligencemod;
                        } endif;
                    ?>
                    </a>
                    <div class="abi-mod-container">
                        <div class="content">
                            <a class="charsheet-abi-mod">

                            <?php 
                                echo $intelligence;
                            ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                    <a class="charsheet-abi-name">Wisdom</a> <br>
                    <a class="charsheet-abi-score">
                    <?php 
                        if ($wisdommod > 0): {
                            echo "+" . $wisdommod; 
                        } else: {
                            echo $wisdommod;
                        } endif;
                    ?>
                    </a>
                    <div class="abi-mod-container">
                        <div class="content">
                            <a class="charsheet-abi-mod">

                            <?php 
                                echo $wisdom;
                            ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                    <a class="charsheet-abi-name">Charisma</a><br>
                    <a class="charsheet-abi-score">
                    <?php 
                        if ($charismamod > 0): {
                            echo "+" . $charismamod; 
                        } else: {
                            echo $charismamod;
                        } endif;
                    ?>
                    </a>
                    <div class="abi-mod-container">
                        <div class="content">
                            <a class="charsheet-abi-mod">

                            <?php 
                                echo $charisma;
                            ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    
<!--PROF BONUS AND SPEED-->
    
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                <a class="charsheet-abi-name">Prof. Bonus</a> <br>
                    <a class="charsheet-abi-score">
                    <?php 
                    echo "+" . $profbonus;
                    ?>
                    </a>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2 col-xl-1">
                <div class="abi-score-container">
                <a class="charsheet-abi-name">Speed (ft.)</a> <br>
                    <a class="charsheet-abi-score">
                        <?php
                        echo $speed;
                        ?>
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="abi-score-container">
                    <div class="row">
                    <div class="col-3">
                        <a id="btn-heal" class="btn btn-sm btn-success" style="color: white;">Healing</a><br>
                        <input type ="number" min="1" id="hp-changer" class="charsheet-health-modifier"/><br>
                        <a id="btn-dmg" class="btn btn-sm btn-danger" style="color: white;">Damage</a>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <a class="hitpoints-top-row">Current</a>
                            </div>
                            <div class="col-6">
                                <a class="hitpoints-top-row">Max</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a class="hitpoints">
                                <div id="curr-hp">
                                <?php 
                                    echo $curr_hp;
                                ?>
                                </div>
                                </a>
                                
                            </div>
                            <div class="col-6">
                                <a class="hitpoints">
                                <?php
                                    echo $max_hp;
                                ?>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a class="hitpoints-bottom-row">Hitpoints</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <a class="hitpoints-top-row">Temp</a><br>
                        <a id="temp-hp" class="hitpoints">
                        <?php 
                            if ($temp_hp > 0): {
                                echo $temp_hp;
                            } else : {
                             echo "--";    
                            } endif;
                        ?>                         
                        </a>
                        <br><a href="#" id="btn-temp" class="btn btn-sm btn-success">Add</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
<div class="row">
    <div class="col-12 col-lg-4 col-xl-3">
         <div class="skills-container">
                <a class="skills-heading">Skills</a>

                    <div class="row skills-header-row">
                        <div class="col-1">Prof.</div>
                        <div class="col-2">Ability</div>
                        <div class="col-6">Skill</div>
                        <div class="col-3" style="text-align:center;">Bonus</div>
                    </div>

    <?php
                  $sql = "SELECT * FROM `skills`";
                    if($stmt = mysqli_prepare($conn,$sql)){
                    if (mysqli_stmt_execute($stmt)){
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $skills = $result->fetch_all(MYSQLI_ASSOC);
    //                        echo print_r($skills);
                        $keys = array_keys($skills);

                        $sql = "SELECT `skill-id`,`expertise` FROM `character-skills` WHERE `character-id` LIKE $characterid";
                        $stmt = mysqli_prepare($conn, $sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $proficiencies = $result->fetch_all(MYSQLI_ASSOC);
    //                    echo print_r($proficiencies);

                        for ($i=0; $i < count($skills); $i++) {

                        array_search($skills[$i]['Skill ID'],array_column($proficiencies, 'skill-id'), TRUE);    

                        ?>
    <div class="row">
                        <div class="col-1">
                        <?php 
                        if (array_search($skills[$i]['Skill ID'],array_column($proficiencies, 'skill-id'), TRUE)): {
                        $is_proficient = 1;    
                        ?>
                        <span class="oi oi-circle-check"></span>
                        <?php
                        } else: {
                        $is_proficient = 0;    
                        }    endif; 
                        ?>
                        </div>
                        <div class="col-2">
                        <select id="<?php echo $skills[$i]['Skill ID']?>-abi-selector" class="skill-abi-selector" onchange='skillselector(this)'>
                        <?php 
                            if ($skills[$i]['AbiID'] == 1): {
                            ?>
                        <option value="1" selected>Str</option>
                        <option value="2">Dex</option>  
                        <option value="3">Con</option>
                        <option value="4">Int</option>
                        <option value="5">Wis</option>
                        <option value="6">Cha</option>

                            <?php
                        } elseif ($skills[$i]['AbiID'] == 2): {
                                ?>
                        <option value="1">Str</option>
                        <option value="2" selected>Dex</option>  
                        <option value="3">Con</option>
                        <option value="4">Int</option>
                        <option value="5">Wis</option>
                        <option value="6">Cha</option>
                            <?php
                        } elseif ($skills[$i]['AbiID'] == 3): {
                            ?>
                        <option value="1">Str</option>
                        <option value="2">Dex</option>  
                        <option value="3" selected>Con</option>
                        <option value="4">Int</option>
                        <option value="5">Wis</option>
                        <option value="6">Cha</option>
                            <?php
                            } elseif ($skills[$i]['AbiID'] == 4): {
                             ?>
                        <option value="1">Str</option>
                        <option value="2">Dex</option>  
                        <option value="3">Con</option>
                        <option value="4" selected>Int</option>
                        <option value="5">Wis</option>
                        <option value="6">Cha</option>
                            <?php
                            } elseif ($skills[$i]['AbiID'] == 5): {
                            ?>
                        <option value="1">Str</option>
                        <option value="2">Dex</option>  
                        <option value="3">Con</option>
                        <option value="4">Int</option>
                        <option value="5" selected>Wis</option>
                        <option value="6">Cha</option>                        
                            <?php
                            } elseif ($skills[$i]['AbiID'] == 6): {
                            ?>
                        <option value="1">Str</option>
                        <option value="2">Dex</option>  
                        <option value="3">Con</option>
                        <option value="4">Int</option>
                        <option value="5">Wis</option>
                        <option value="6" selected>Cha</option>                          
                            <?php
                            } endif; ?>
                        </select>
                        </div>
                        <div class="col-6"><?php echo $skills[$i]['Skill Name']; ?></div>
                        <div class="col-3" style="text-align: center;">
                        <div id="<?php echo $skills[$i]['Skill ID']; ?>-bonus">
                        <?php
                        $modifier = 0;
                        if (!empty($is_proficient)): {
                        $modifier = $profbonus;    
                        } endif;
                        if ($skills[$i]['AbiID'] == 1): {
                        $modifier = $modifier + $strengthmod;    
                        } elseif ($skills[$i]['AbiID'] == 2): {
                        $modifier = $modifier + $dexteritymod;     
                        } elseif ($skills[$i]['AbiID'] == 3): {
                        $modifier = $modifier + $constitutionmod; 
                        } elseif ($skills[$i]['AbiID'] == 4): {
                        $modifier = $modifier + $intelligencemod; 
                        } elseif ($skills[$i]['AbiID'] == 5): {
                        $modifier = $modifier + $wisdommod; 
                        } elseif ($skills[$i]['AbiID'] == 6): {
                        $modifier = $modifier + $charismamod; 
                        } endif;
                        if ($modifier > 0): {
                        echo "+". $modifier;    
                        } elseif ($modifier < 0): {
                        echo $modifier;    
                        } else: {
                        echo "0";
                        } endif;
                        ?>
                        </div>
                        </div>
                    </div>                

                        <?php

                        }
                    }
                    }
                ?>


                </div>
    </div>
    <div class="col-12 col-lg-8 col-xl-5">
        <div class="skills-container">
        <button role="button" id="actionsbutton" class="btn features-heading" onclick="boxpaginator('Actions')">Actions</button> <button role="button" id="spellbutton" class="btn features-heading" onclick="boxpaginator('Spells')">Spells</button> <button id="featuresbutton" class="btn features-heading" onclick="boxpaginator('Features')">Features</button> <button id="inventorybutton" class="btn features-heading" onclick="boxpaginator('Inventory')">Inventory</button> <button id="retainerbutton" class="btn features-heading" onclick="boxpaginator('Retainers')">Retainers</button> <button id="unitbutton" class="btn features-heading" onclick="boxpaginator('Units')">Units</button>

    <div id="features-container">  
<!---->
<!--    INVENTORY BLOCK -->
<!--            -->
    <div id="inventorydiv" style="display: none;">
            <?php
//            echo "<pre>";
//            print_r($inventory);
//            echo "</pre>";
            ?>
        <div class="col-12">
            <button class="btn btn-light">All</button> <button class="btn btn-light">Inventory</button> <button class="btn btn-light">Attunement</button>
        </div>
        <div class="row featuresscroller">
        <div class="col-12 featuresblock" id="equipment">
            <input type="text" class="form-control input-md" id="typesearch" onkeyup='tablesearch("typesearch",0)' placeholder="Type here to search Inventory for keywords" style="margin-top: .5rem; margin-bottom: 0.5rem; padding-left: 10px;">
            <?php 
                $cp = $row['cp'];
                $cpvalue = $cp / 100;
                $sp = $row['sp'];
                $spvalue = $sp / 10;
                $gp = $row['gp'];  
                $ep = $row['ep'];
                $epvalue = $ep / 2;
                $pp = $row['pp'];
                $ppvalue = $pp * 10;
                
            ?>
                <a>Currency:</a>
                <a data-toggle="tooltip" data-html="true" data-original-title="Copper: 1/100 GP <br> Value: <?php echo $cpvalue ; ?> Gold."><img src="img/cp.png" class="currencyimg" alt="CP:"/> <?php echo $cp; ?></a>  
                <a data-toggle="tooltip" data-html="true" data-original-title="Silver: 1/10 GP <br> Value: <?php echo $spvalue ; ?> Gold."><img src="img/sp.png" class="currencyimg" alt="SP:"/> <?php echo $sp; ?></a>  
                <a data-toggle="tooltip" data-html="true" data-original-title="Electrum: 1/2 GP <br> Value: <?php echo $epvalue ; ?> gp."><img src="img/ep.png" class="currencyimg" alt="EP:"/> <?php echo $ep; ?></a>
                <a data-toggle="tooltip" data-html="true" data-original-title="Gold."><img src="img/gp.png" class="currencyimg" alt="GP:"/> <?php echo $gp; ?></a> 
                <a data-toggle="tooltip" data-html="true" data-original-title="Platinum: 10 GP <br> Value: <?php echo $ppvalue ; ?> gp."><img src="img/pp.png" class="currencyimg" alt="PP:"/> <?php echo $pp; ?></a>
            <table id="inventory-table" class="table inventory-table" style="max-width:95%; margin-left: 15px;">
                <colgroup>
                    <col span="1" style="width:10%;">
                    <col span="1" style="width:60%;">
                    <col span="1" style="width:10%;">
                    <col span="1" style="width:10%;">
                    <col span="1" style="width:10%;">
                </colgroup>
                
                <thead>
                <tr>
                    <th>Equip</th>
                    <th>Name</th>
                    <th>Weight</th>
                    <th>Quantity</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                
        <?php
            
            for ($i=0; $i < count($inventory); $i++) {
                $itemid = $inventory[$i]['Item-ID'];
                $name = $inventory[$i]['Item-Name'];
                $weight = $inventory[$i]['Item-Weight'];
                $rarity = $inventory[$i]['item-rarity'];
                $equippable = $inventory[$i]['equippable'];
                $equipped = $inventory[$i]['equipped'];
                $itemtype = $inventory[$i]['item-type'];
                $itemsubtype = $inventory[$i]['item-subtype'];
                $quantity = 1;
                $value = $inventory[$i]['Item-Value'];
                $inventoryid = $inventory[$i]['inventory-entry-id'];
                
                $inventoryweight = $inventoryweight + ($weight * $quantity)

                ?>
                <tr class="inventory-<?php echo $itemtype; ?>">
                    <td>
                    <?php 
//                        echo $equippable;
//                        echo $equipped;
                        if ($equippable === 1): {
                            if ($equipped === 1):{
                            ?>
                               <input type="checkbox" name="<?php echo $inventoryid . '-equipcheckbox' ?>" id="<?php echo $inventoryid . '-equipcheckbox' ?>" checked onclick="equipgear(this)"> 
                            <?php
                            } else: {
                            ?>
                               <input type="checkbox" name="<?php echo $inventoryid . '-equipcheckbox' ?>" id="<?php echo $inventoryid . '-equipcheckbox' ?>" onclick="equipgear(this)"> 
                            <?php
                            } endif;

                        } endif;
                    ?>
                    </td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $weight . " lbs."; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo $value . " gp"; ?></td>
                </tr>
                <tr style="display:none;">
                    <td colspan=3><?php echo $itemtype . " (" . $itemsubtype . ")"; ?></td>
                    <td colspan=1><a class="btn btn-sm btn-danger" style="color:white;">-</a> <a class="btn btn-sm btn-success" style="color:white;">+</a> </td>
                    <td colspan=1></td>
                </tr>
                    
            <?php
                
            }
            
            ?>


                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td style="text-align:right;">Total:</td>
                    <td colspan=3><?php echo $inventoryweight . "/" . ($strength * 15) . " lbs."; ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-12 featuresblock" id="attunement">
        Attunement
            <div class="row">
            <div class="col-12">
                Requires Attunement<br>
                
                <?php
            
                for ($i = 0; $i < count($attunementitems); $i++) {
                $itemid = $attunementitems[$i]['Item-ID'];
                $name = $attunementitems[$i]['Item-Name'];
                $weight = $attunementitems[$i]['Item-Weight'];
                $rarity = $attunementitems[$i]['item-rarity'];
                $equippable = $attunementitems[$i]['equippable'];
                $attuned = $attunementitems[$i]['attuned'];
                $itemtype = $attunementitems[$i]['item-type'];
                $itemsubtype = $attunementitems[$i]['item-subtype'];
                $quantity = 1;
                $value = $attunementitems[$i]['Item-Value'];
                $inventoryid = $attunementitems[$i]['inventory-entry-id'];

                            if ($attuned == 1):{
                            ?>
                               <input type="checkbox" name="<?php echo $inventoryid . '-attunecheckbox' ?>" id="<?php echo $inventoryid . '-attunecheckbox' ?>" checked onclick="attunement(this)"> 
                            <?php
                            } else: {
                            ?>
                               <input type="checkbox" name="<?php echo $inventoryid . '-attunecheckbox' ?>" id="<?php echo $inventoryid . '-attunecheckbox' ?>" onclick="attunement(this)"> 
                            <?php
                            } endif;

                    ?>
                <a class="magic-item"><?php echo $name; ?></a>
                
                
                <?php
                }
            
                ?>
            </div>
        </div>
        </div>
        </div>
    </div>
        
            
            
<!--            -->
<!-- FEATURES BLOCK                -->
<!--                -->
<!--                -->
                
    <div id="featuresdiv" style="display: none;">
        <div id="features-inner-div">
            <button class="btn btn-light" onclick="panelselection('Features','All')">All</button> <button class="btn btn-light" onclick="panelselection('Features','Class')">Class Features</button> <button class="btn btn-light" onclick="panelselection('Features','Racial')">Ancestral Features</button> <button class="btn btn-light" onclick="panelselection('Features','Feats')">Feats</button>
                <div class="row featuresscroller">
                <div id="classfeatures" class="col-12 featuresblock">
                <a class="features-subhead">Class Features</a><br>
                <?php
                
                for ($i=0; $i < count($classes); $i++) {
                    
                    $characterclass = $classes[$i]['class-id'];
                    $charactersubclass = $classes[$i]['subclass-id'];
                
                if (empty($charactersubclass)):{
                $sql = "SELECT `class-features`.`class-feature-id`,`class-features`.`class-feature-option`, `class-features`.`level-3-options`, `class-features`.`level-7-options`, `class-features`.`level-10-options`, `class-features`.`level-15-options`, `class-features`.`level-18-options`, `class-features`.`class-feature-name`, `class-features`.`class-feature-description`, `class-features`.`class-feature-snippet`, `class-features`.`class-feature-action`, `class-features`.`class-feature-uses`, `class-features`.`class-feature-recharge` FROM `class-features` LEFT JOIN `class-features-to-classes` ON `class-features`.`class-feature-id` = `class-features-to-classes`.`class-feature-id` WHERE `class-features-to-classes`.`class-id` LIKE $characterclass AND `level` <= $level";
                } else: {
                $sql = "SELECT `class-features`.`class-feature-id`,`class-features`.`class-feature-option`, `class-features`.`level-3-options`, `class-features`.`level-7-options`, `class-features`.`level-10-options`, `class-features`.`level-15-options`, `class-features`.`level-18-options`, `class-features`.`class-feature-name`, `class-features`.`class-feature-description`, `class-features`.`class-feature-snippet`, `class-features`.`class-feature-action`, `class-features`.`class-feature-uses`, `class-features`.`class-feature-recharge`  

                FROM `class-features` LEFT OUTER JOIN `class-features-to-classes` ON `class-features`.`class-feature-id` = `class-features-to-classes`.`class-feature-id` 
                
                WHERE `class-features-to-classes`.`class-id` LIKE $characterclass AND `class-features-to-classes`.`level` <= $level

                UNION 

                SELECT `class-features`.`class-feature-id`,`class-features`.`class-feature-option`, `class-features`.`level-3-options`, `class-features`.`level-7-options`, `class-features`.`level-10-options`, `class-features`.`level-15-options`, `class-features`.`level-18-options`, `class-features`.`class-feature-name`, `class-features`.`class-feature-description`, `class-features`.`class-feature-snippet`, `class-features`.`class-feature-action`, `class-features`.`class-feature-uses`, `class-features`.`class-feature-recharge`
                    
                FROM `class-features` LEFT OUTER JOIN `class-features-to-subclasses` ON `class-features`.`class-feature-id` = `class-features-to-subclasses`.`class-feature-id` 
                
                WHERE `class-features-to-subclasses`.`subclass-id` LIKE $charactersubclass AND `class-features-to-subclasses`.`level` <= $level";    
                
                } endif;
                
                $result1 = $mysqli->query($sql);
                $classfeatures = $result1->fetch_all(MYSQLI_ASSOC);
//                echo "<pre>";
//                print_r($classfeatures);
//                echo "</pre>";
            
                for ($i=0; $i < count($classfeatures); $i++) {
                $name = $classfeatures[$i]['class-feature-name'];
                $id = $classfeatures[$i]['class-feature-id'];
                $description = $classfeatures[$i]['class-feature-description'];
                $snippet =  $classfeatures[$i]['class-feature-snippet'];
                $uses = $classfeatures[$i]['class-feature-uses'];
                $recharge = $classfeatures[$i]['class-feature-recharge'];
                $option = $classfeatures[$i]['class-feature-option'];
                    ?>
                
                <a class="class-feature-title"><?php echo $name; ?></a><br>
                <a class="class-feature-description"><?php echo $snippet; ?></a><br>
                       
                     
                    <?php
                    if (!empty($uses)):{ 
                        echo '<div class="uses-checkbox">';
                        for ($x=0; $x < $uses; $x++) {
                            $currentuse = $x + 1;
                            $checkboxid = $characterid . '-feature-' . $id . '-' . $currentuse;
                        ?>   
                        <input  type="checkbox" name="<?php echo $id . '-uses'; ?>" id="<?php echo $checkboxid;?>" value="<?php echo $currentuse; ?>" onclick='storeAbilityUse(<?php echo '"' . $checkboxid . '","' . $recharge . '"'; ?>)'>
                        <script>
                        checkAbilityUse(<?php echo '"' . $checkboxid . '","' . $recharge . '"'; ?>)
                        </script>
                        <?php
                        }
                    ?>
                      / <?php echo $recharge . '<br> </div>'; ?>      
                    <?php
                    } endif;
                    
                if (!empty($option)) :{
                $sql = "SELECT * FROM `class-feature-options`
                        INNER JOIN `character-class-feature-options-selections` ON `class-feature-options`.`id` = `character-class-feature-options-selections`.`class-feature-option-id`
                        WHERE `character-class-feature-options-selections`.`characterid` LIKE $characterid
                        AND `class-feature-options`.`parent-class-feature` LIKE $id";
                $result1 = $mysqli->query($sql);
                $optionselected = $result1->fetch_all(MYSQLI_ASSOC);
//                echo '<pre>';
//                print_r($optionselected);
//                echo '</pre>';
                    
                    for ($y=0; $y < count($optionselected); $y++) {
                    

                $optionid = $optionselected[$y]['class-feature-option-id'];
                        
                $optionname = $optionselected[$y]['class-feature-option-name'];
                $optiondescription = $optionselected[$y]['class-feature-option-description'];
                $optionsnippet = $optionselected[$y]['class-feature-option-snippet'];
                        
//                        dealing with fighting style if it is there
                    if ($optionid === "1"): {
//                        creating bonus for archery fighting style, is used later when calculating ranged weapon attacks
                        $archerybonus = 2;
                    } elseif ($optionid === "2"): {
//                        For simplicity, we assume that armor is always worn
                        
                        $defensebonus = 1;
                        $defensebonusstring = " + 1 (Defense Fighting Style)";
                    } elseif ($optionid === 3): {
//                        For simplicity, we assume that dueling is always active
                        $acbonus = $acbonus + 1;
                        $acbonusstring = $acbonusstring . " + 1 (Dueling Fighting Style)";                        
                    } 
                        
                        endif; ?>
                
                <a class="class-feature-option-title"><?php echo $optionname; ?></a><br>
                <a class="class-feature-option-description"><?php echo $optionsnippet; ?></a><br>
                    
                    
                <?php
                }
                }   endif; 
                
                unset($name);
                unset($id);
                unset($description);
                unset($snippet);
                unset($uses);
                unset($recharge);
                unset($option);
                    
                    
                }
                
                }
                
            
            
                ?>
    
                </div>
                <div id="racefeatures" class="col-12 featuresblock">
                <a class="features-subhead">Ancestry Features</a><br>
                    <?php
                    if (!empty($characterheritage)): {
                    $sql = "SELECT `class-features`.`class-feature-id`,`class-features`.`class-feature-option`, `class-features`.`level-3-options`, `class-features`.`level-7-options`, `class-features`.`level-10-options`, `class-features`.`level-15-options`, `class-features`.`level-18-options`, `class-features`.`class-feature-name`, `class-features`.`class-feature-description`, `class-features`.`class-feature-snippet`, `class-features`.`class-feature-action`, `class-features`.`class-feature-uses`, `class-features`.`class-feature-recharge` 
                    FROM `class-features` 
                    LEFT JOIN `class-feature-to-races` ON `class-features`.`class-feature-id` = `class-feature-to-races`.`class-feature-id` 
                    WHERE `class-feature-to-races`.`race-id` LIKE $characterancestry";
                        
                        
                    
                    
                    } else: {
                        
                    } endif;
                    
                $result1 = $mysqli->query($sql);
                $ancestryfeatures = $result1->fetch_all(MYSQLI_ASSOC);
//                echo "<pre>";
//                print_r($classfeatures);
//                echo "</pre>";
            
                for ($i=0; $i < count($classfeatures); $i++) {
                $name = $ancestryfeatures[$i]['class-feature-name'];
                $id = $ancestryfeatures[$i]['class-feature-id'];
                $description = $ancestryfeatures[$i]['class-feature-description'];
                $snippet =  $ancestryfeatures[$i]['class-feature-snippet'];
                $uses = $ancestryfeatures[$i]['class-feature-uses'];
                $recharge = $ancestryfeatures[$i]['class-feature-recharge'];
                $option = $ancestryfeatures[$i]['class-feature-option'];
                    ?>
                
                <a class="class-feature-title"><?php echo $name; ?></a><br>
                <a class="class-feature-description"><?php echo $snippet; ?></a><br>
                       
                     
                    <?php
                    if (!empty($uses)):{ 
                        echo '<div class="uses-checkbox">';
                        for ($x=0; $x < $uses; $x++) {
                            $currentuse = $x + 1;
                        ?>    
                            <input  type="checkbox" name="<?php echo $optionid . '-uses'; ?>" id="<?php echo 'feature-' . $optionid . '-' . $currentuse;?>" value="<?php echo $currentuse; ?>">
                        <?php
                        }
                    ?>
                      / <?php echo $recharge . '<br> </div>'; ?>      
                    <?php
                    } endif;
                    
                if (!empty($option)) :{
                $sql = "SELECT * FROM `class-feature-options`
                        INNER JOIN `character-class-feature-options-selections` ON `class-feature-options`.`id` = `character-class-feature-options-selections`.`class-feature-option-id`
                        WHERE `character-class-feature-options-selections`.`characterid` LIKE $characterid
                        AND `class-feature-options`.`parent-class-feature` LIKE $id";
                $result1 = $mysqli->query($sql);
                $optionselected = $result1->fetch_all(MYSQLI_ASSOC);
//                echo '<pre>';
//                print_r($optionselected);
//                echo '</pre>';
                    
                    for ($y=0; $y < count($optionselected); $y++) {
                    

                $optionid = $optionselected[$y]['class-feature-option-id'];
                        
                $optionname = $optionselected[$y]['class-feature-option-name'];
                $optiondescription = $optionselected[$y]['class-feature-option-description'];
                $optionsnippet = $optionselected[$y]['class-feature-option-snippet'];
                        
                ?>
                
                <a class="class-feature-option-title"><?php echo $optionname; ?></a><br>
                <a class="class-feature-option-description"><?php echo $optionsnippet; ?></a><br>
                    
                    
                <?php
                    }
                }   endif; 
                
                unset($name);
                unset($id);
                unset($description);
                unset($snippet);
                unset($uses);
                unset($recharge);
                unset($option);
                    
                    
                }
                
                    
                    
            
                    ?>
                </div>
                <div id="featsfeatures" class="col-12 featuresblock"></div>
                </div>
            </div>
            </div>
            
<!--            -->
<!-- SPELLS BLOCK-->
<!--            -->
    <div id="spellsdiv" style="display: none;"></div>    

            
            
<!--          ACTIONS BLOCK      -->
<!--ACTIONS ARE POPULATED LAST, SO WE HAVE ALL MODIFIERS-->
<!---->
                
    <div id="actionsdiv">
        <button class="btn btn-light" onclick="panelselection('Actions','All')">All</button> <button class="btn btn-light" onclick="panelselection('Actions','Attacks')">Attacks</button> <button class="btn btn-light" onclick="panelselection('Actions','Combat Actions')">Combat Actions</button> <button class="btn btn-light" onclick="panelselection('Actions','Bonus Actions')">Bonus Actions</button> <button class="btn btn-light" onclick="panelselection('Actions','Reactions')">Reactions</button>
        <div class="row featuresscroller">    
        <div id="attacks" class="col-12 featuresblock">
        <a class="features-subhead">Attacks</a><br>
        <div class="col-12" style="text-align:right;">
            <b>Attacks per Attack Action: <?php echo $attacks; ?></b>
        </div>
        <table class="table table-sm">
            <thead class="thead-light">
            <tr>
                <th style="width:20%;">
                <a class="attacks-heading">Attack</a>
                </th>
                <th style="width:15%;">
                <a class="attacks-heading">Range</a>
                </th>
                <th style="width:10%;">
                <a class="attacks-heading">Hit</a>
                </th>
                <th style="width:15%;">
                <a class="attacks-heading">Damage</a>
                </th>
                <th style="width 40%;">
                <a class="attacks-heading">Special</a>
                </th>
            </tr>
            </thead>
            <tbody>

<?php 
                for ($i=0; $i < count($inventory); $i++) {
                
                $itemid = $inventory[$i]['Item-ID'];
                $name = $inventory[$i]['Item-Name'];
                $weight = $inventory[$i]['Item-Weight'];
                $rarity = $inventory[$i]['item-rarity'];
                $equippable = $inventory[$i]['equippable'];
                $equipped = $inventory[$i]['equipped'];
                $itemtype = $inventory[$i]['item-type'];
                $itemsubtype = $inventory[$i]['item-subtype'];
                $quantity = 1;
                $value = $inventory[$i]['Item-Value'];
                $inventoryid = $inventory[$i]['inventory-entry-id'];
//                $itemid = $inventory[$i]['item-id'];
                
//                    echo $equipped;
                    
                if ($equipped === 1): {
                $sql = "SELECT * FROM `attacks` INNER JOIN `item-attacks` ON `attacks`.`attack-id` = `item-attacks`.`attack-id` WHERE `item-attacks`.`item-id` LIKE ?";   
                    if($stmt = mysqli_prepare($conn,$sql)){
                    mysqli_stmt_bind_param($stmt, "i", $itemid);
                        if (mysqli_stmt_execute($stmt)){
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $itemarray = $result->fetch_all(MYSQLI_ASSOC);
                            
                    for ($x=0; $x < count($itemarray); $x++) {        
                    $attackbonus = 0;
//                            echo "<pre>";
//                            print_r($itemarray);
//                            echo "</pre>";
                    ?>
                            
                            <tr>
                                <td>
                                <a class="attacks-name" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="attack-details"><?php echo $itemarray[$x]['attack-name']; ?></a>
                                </td>
                                <td>
                                <a class="attacks-entry"><?php echo $itemarray[0]['attack-range']; ?></a>
                                </td>
                                <td>
                                    <div class="rollable">
                                    <a class="attacks-entry">
                                    <?php
                                        if ($itemarray[$x]['ranged-attack'] == 1): {
                                            if (!empty($archerybonus)): {
                                                $attackbonus = $attackbonus + $archerybonus; 
                                            } endif;
                                        $attackbonus = $attackbonus + $dexteritymod + $profbonus;    
                                        } else: {
                                            if ($itemarray[$x]['finesse-attack'] == 0): {
                                                $attackbonus = $strengthmod + $profbonus;

                                            } elseif ($itemarray[$x]['finesse-attack'] == 1): {
                                                if ($dexteritymod > $strengthmod): {
                                                $attackbonus = $dexteritymod + $profbonus;    
                                                } else: {
                                                $attackbonus = $strengthmod + $profbonus;    
                                                } endif;
                                            } endif;
                                        } endif;

                                    if ($attackbonus > 0): {
                                        echo "+" . $attackbonus;
                                    }   else: {
                                        echo $attackbonus;
                                    }   endif;      
                                    ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="rollable" style="display:inline-block;">
                                    <a class="attacks-entry">
                                    <?php
                                        echo $itemarray[$x]['attack-damage-die'];
                                        if ($itemarray[$x]['ranged-attack'] == 1): {
                                        $damagebonus = $dexteritymod;    
                                        } else: {
                                            if ($itemarray[$x]['finesse-attack'] == 0): {
                                                $damagebonus = $strengthmod;

                                            } elseif ($itemarray[$x]['finesse-attack'] == 1): {
                                                if ($dexteritymod > $strengthmod): {
                                                $damagebonus = $dexteritymod;    
                                                } else: {
                                                $damagebonus = $strengthmod;    
                                                } endif;
                                            } endif;
                                        } endif;

                                    if ($damagebonus > 0): {
                                        echo "+" . $damagebonus;
                                    }   elseif ($damagebonus < 0): {
                                        echo $damagebonus;
                                    }   endif;      
                                    ?> 
                                    </a>
                                    </div>
                                    <?php 
                                    if ($itemarray[$x]['attack-damage-type'] == "Piercing"): {
                                    ?>
                                    <img src="game-icons\piercing.svg" style="width:1rem; display:inline-block;" data-toggle="tooltip" title="Piercing Damage"/>
                                    <?php
                                    } elseif ($itemarray[$x]['attack-damage-type'] == "Bludgeoning"): {
                                    ?>
                                    <img src="game-icons\bludgeoning.svg" style="width:1rem; display:inline-block;" data-toggle="tooltip" title="Bludgeoning Damage"/>    
                                    <?php
                                    } elseif ($itemarray[$x]['attack-damage-type'] == "Slashing"): {
                                    ?>
                                    <img src="game-icons\slashing.svg" style="width:1rem; display:inline-block;" data-toggle="tooltip" title="Slashing Damage"/>   
                                    <?php
                                    } endif;                    
                                    ?>
                                </td>
                                <td>
                                    <a class="attacks-notes"><?php echo $itemarray[$x]['attack-notes']; ?></a>
                                </td>

                            </tr>    
                        
                <?php
                            }   
                        }
                    } 
                } endif;
            }
            
            ?>
            
            <tr>
                <td>
                    <a class="attacks-name" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="attack-details">Unarmed Strike</a>
                </td>
                <td>
                    <a class="attacks-entry">Melee</a>
                </td>
                <td>
                    <div class="rollable">
                    <a class="attacks-entry">
                        <?php 
                        $unarmedstrikehit = $strengthmod + $profbonus;
                        if ($unarmedstrikehit > 0): {
                            echo "+" . $unarmedstrikehit;
                        } else: {
                            echo $unarmedstrikehit;
                        } endif;
                        ?>


                    </a>
                    </div>
                </td>
                <td>
                    <div class="rollable" style="display:inline-block;">
                    <a class="attacks-entry">
                        1
                    </a>
                    </div>
                    <img src="game-icons\bludgeoning.svg" style="width:1rem; display:inline-block;" data-toggle="tooltip" title="Bludgeoning Damage"/>
                </td>
                <td>
                    <a class="attacks-notes"></a>
                </td>

            </tr>    
            </tbody>
        </table>        
        </div>
        <div id="generalactions" class="col-12 featuresblock">
        <a class="features-subhead">Combat Actions</a><br>
            <div class="panel-group" id="generalactions-accordion">
            <a class="action-name" data-toggle="collapse" role="button" data-target="#attack-description" >Attack</a>, 
            <a class="action-name" data-toggle="collapse" role="button" data-target="#spellcast-description" >Cast a Spell</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#dash-description" >Dash</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#disengage-description" >Disengage</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#dodge-description" >Dodge</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#help-description" >Help</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#hide-description" >Hide</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#ready-description" >Ready</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#search-description" >Search</a>,
            <a class="action-name" data-toggle="collapse" role="button" data-target="#object-description" >Use an Object</a>
<!--

            <a class="action-name" data-toggle="collapse" role="button" data-target="#attack-description" aria-expanded="false" aria-controls="attack-description">Hide</a>, 
            <a class="action-name" data-toggle="collapse" role="button" data-target="#attack-description" aria-expanded="false" aria-controls="attack-description">Ready</a>, 
            <a class="action-name" data-toggle="collapse" role="button" data-target="#attack-description" aria-expanded="false" aria-controls="attack-description">Search</a>, 
            <a class="action-name" data-toggle="collapse" role="button" data-target="#attack-description" aria-expanded="false" aria-controls="attack-description">Use an Object</a>
-->
            <div id="accordion-group">
                <div id="attack-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Attack: </b>The most common action to take in combat is the Attack action, whether you are swinging a sword, firing an arrow from a bow, or brawling with your fists. With this action, you make one melee or ranged attack. See the "Making an Attack" section for the rules that govern attacks. Certain features, such as the Extra Attack feature of the fighter, allow you to make more than one attack with this action.</p>
                </div>
                <div id="spellcast-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Cast a spell: </b>Spellcasters such as wizards and clerics, as well as many monsters, have access to spells and can use them to great effect in combat. Each spell has a casting time, which specifies whether the caster must use an action, a reaction, minutes, or even hours to cast the spell. Casting a spell is, therefore, not necessarily an action. Most spells do have a casting time of 1 action, so a spellcaster often uses his or her action in combat to cast such a spell.</p>
                </div>
                <div id="dash-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Dash: </b>When you take the Dash action, you gain extra movement for the current turn. The increase equals your speed, after applying any modifiers. With a speed of 30 feet, for example, you can move up to 60 feet on your turn if you dash.</p>
                <p>Any increase or decrease to your speed changes this additional movement by the same amount. If your speed of 30 feet is reduced to 15 feet, for instance, you can move up to 30 feet this turn if you dash.</p>
                </div>
                <div id="disengage-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Disengage: </b>If you take the Disengage action, your movement doesn't provoke opportunity attacks for the rest of the turn.</p>
                </div>
                <div id="dodge-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Dodge: </b>When you take the Dodge action, you focus entirely on avoiding attacks. Until the start of your next turn, any attack roll made against you has disadvantage if you can see the attacker, and you make Dexterity saving throws with advantage. You lose this benefit if you are incapacitated or if your speed drops to 0.</p>
                </div>
                <div id="help-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Help: </b>You can lend your aid to another creature in the completion of a task. When you take the Help action, the creature you aid gains advantage on the next ability check it makes to perform the task you are helping with, provided that it makes the check before the start of your next turn.</p>
                <p>Alternatively, you can aid a friendly creature in attacking a creature within 5 feet of you. You feint, distract the target, or in some other way team up to make your ally's attack more effective. If your ally attacks the target before your next turn, the first attack roll is made with advantage.</p>
                </div>
                <div id="hide-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Hide: </b>When you take the Hide action, you make a Dexterity (Stealth) check in an attempt to hide, following the rules for hiding. If you succeed, you gain certain benefits, as described in the "Unseen Attackers and Targets" section later in this chapter.</p>
                </div>
                <div id="ready-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Ready: </b>Sometimes you want to get the jump on a foe or wait for a particular circumstance before you act. To do so, you can take the Ready action on your turn, which lets you act using your reaction before the start of your next turn.</p>
                <p>First, you decide what perceivable circumstance will trigger your reaction. Then, you choose the action you will take in response to that trigger, or you choose to move up to your speed in response to it.</p>
                </div>
                <div id="search-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Search: </b>When you take the Search action, you devote your attention to finding something. Depending on the nature of your search, the GM might have you make a Wisdom (Perception) check or an Intelligence (Investigation) check.</p>
                </div>
                <div id="object-description" class="collapse action-description" data-parent="#accordion-group"><p><b>Use an object: </b>You normally interact with an object while doing something else, such as when you draw a sword as part of an attack. When an object requires your action for its use, you take the Use an Object action. This action is also useful when you want to interact with more than one object on your turn.</p>
                </div>
            </div>
            </div>
        </div>
        <div id="bonusactions" class="col-12 featuresblock">
        <a class="features-subhead">Bonus Actions</a><br>
        <a class="action-name">Offhand Attack, Cast a Spell</a>
        </div>
        <div id="reactions" class="col-12 featuresblock">
        <a class="features-subhead">Reactions</a><br>
        <a class="action-name">Opportunity attack, Readied action, Cast a spell</a>    
        </div>
        
        </div>
    </div>

<!---->
<!--            RETAINERS BLOCK     -->
<!---->
            

    <div id="retainersdiv" style="display: none;">
        
        <?php    
        $sql = "SELECT * FROM `user-retainers` WHERE `Assoc-Character` LIKE $characterid";
        $result = $mysqli->query($sql);
        $character = "";
        
        
        if ($result->num_rows > 0): {
?>
            <div id="retainers-table">

<!--table table-striped custab col-lg-10 col-md-11 col-xs-12-->
            
    <table id="myretainertable" class="table">
    <thead>

        <tr>
            <th style="width: 40%;">Name</th>
            <th style="width: 30%;">Type</th>
            <th style="width: 10%;">Level</th>
            <th style="width: 20%;"></th>
        </tr>
            </thead>
           
    <?php
            // output data of each row
            while($row = $result->fetch_assoc()) {
        
                
            $retainername = $row['Retainer-Name'];    
            $typeid = $row['Retainer-Type'];
            $retainer_id = $row['User-Retainer-ID'];
            $retainerlevel = $row['Retainer-Level'];
            if (!empty($row['Assoc-Character'])){ 
            $assoc_character = $row['Assoc-Character'];
            
            
            $sql = "SELECT * FROM `characters` WHERE `character_id` LIKE $assoc_character";
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $assoc_character = $row2['Character Name'];} else {
            $assoc_character = "Unassigned";    
            }
               
            $sql = "Select * FROM `retainer` WHERE `RetainerID` LIKE $typeid";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $type = $row1['RetainerName']; ?>
    
    <tr>
                <td><?php echo $retainername; ?></td>
                <td><?php echo $type; ?></td>
                <td><?php echo $retainerlevel; ?></td>
                <td class="text-center">
                <a class="btn btn-success btn-xs cstbtn-retainer-table" onclick="viewretainer(<?php echo $retainer_id; ?>)"><span class="glyphicon glyphicon-edit"></span>View</a> 
        </td>
    </tr> 
    
            
    
    <?php
    } 
        ?>

    </table>
</div>
            
     <?php       
        } endif;
                                
            ?>
        
    <div id="retainer-card-container" style="display: none;">        
        <a class="btn btn-warning btn-xs cstbtn-retainer-table" onclick="viewretainer('Return to table')" style="margin-bottom:.25rem;"><span class="glyphicon glyphicon-edit"></span>Back to Table</a> 
        <div id="retainer-card">
            
        </div>
    </div>    
</div>


    </div>
    </div>
    </div>
    <div id="initiative-armor-class-block" class="col-12 col-lg-4 col-xl-4">
        
        <div class="row">
            <div class="col-2" style="padding-right:5px;">
            <div class="small-block-container" style="text-align: center;">
                <a class="small-block">Init</a><br>
                <a class="ac-text">+4</a>
            </div>
            </div>
            <div class="col-2" style="padding-right:5px; padding-left: 5px;">
            <div  class="small-block-container" style="text-align: center;">
            <div id="ACDiv">
            <a class="small-block">AC</a><br>
                
                <?php
            $sql = "SELECT * FROM `armors` INNER JOIN `character-inventories` ON `armors`.`item-id` = `character-inventories`.`item-id` WHERE `character-inventories`.`character-id` = $characterid AND `character-inventories`.`equipped` = 1"; 
            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result();
            $armorequipped = $result->fetch_all(MYSQLI_ASSOC);
//            echo "<pre>";
//            print_r($armorequipped);
//            echo "</pre>";
            if (!empty($armorequipped)): {
                $armorac = $armorequipped[0]['armor-class'];
                $armormaxdex = $armorequipped[0]['max-dex-bonus'];
                $armorname = $armorequipped[0]['armor-name'];

                if ($dexteritymod < $armormaxdex): {
                    $armordexmod = $dexteritymod;
                    $armorcalculation = "AC = " . $armorac . " (from " . $armorname .") + " . $armordexmod . " (Dexterity Modifier)";
                } elseif ($armormaxdex > 0): {
                    $armordexmod = $armormaxdex;
                    $armorcalculation = "AC = " . $armorac . " (from " . $armorname .") + " . $armordexmod . " (Dexterity Modifier limited by armor)";
                } else: {
                    $armordexmod = 0;
                    $armorcalculation = "AC = " . $armorac . " (from " . $armorname .")";
                } endif;

                $armorclass = $armorac + $armordexmod + $defensebonus;
                $armorcalculation = $armorcalculation . $defensebonusstring;
            } else: {
            $armorclass = 10 + $dexteritymod;
            $armorcalculation = "AC = 10 + " . $dexteritymod . " (Dexterity Modifier)";
            } endif;
            
            $armorclass = $armorclass + $acbonus;
            $armorcalculation = $armorcalculation . $acbonusstring;
                ?>
<!--
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0"
                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
            <g>
                    <path d="M461.144,60.883L260.312,0.633c-2.809-0.844-5.808-0.844-8.62,0L50.858,60.883c-6.345,1.903-10.69,7.743-10.69,14.367
                        v220.916c0,28.734,11.632,58.148,34.573,87.425c17.522,22.36,41.762,44.813,72.048,66.736
                        c50.877,36.828,100.975,59.42,103.083,60.363c1.95,0.873,4.039,1.31,6.129,1.31c2.089,0,4.179-0.436,6.129-1.31
                        c2.108-0.943,52.205-23.535,103.082-60.363c30.285-21.923,54.525-44.376,72.047-66.736c22.941-29.276,34.573-58.69,34.573-87.425
                        V75.25C471.833,68.626,467.489,62.786,461.144,60.883z M441.833,296.166c0,50.852-51.023,98.534-93.826,129.581
                        c-38.374,27.833-77.291,47.583-92.005,54.678c-14.714-7.095-53.632-26.845-92.006-54.678
                        c-42.804-31.047-93.828-78.729-93.828-129.581V86.41l185.833-55.75l185.832,55.75V296.166z"/>
                    
            </g>
            </svg>       
-->
            <a class="ac-text" data-toggle="tooltip" data-type="html" data-original-title="<?php echo $armorcalculation?>"><?php echo $armorclass; ?></a>
            </div>
            </div>
            
            </div>
            <div class="col-4" style="padding-right:5px; padding-left: 5px;">
            <div class="small-block-container">
                <a class="small-block">Defences</a><br>
                <a class="conditions-resistances-none">Resistances and Immunities to damage types will appear here.</a>
            </div>
            </div>
            <div class="col-4" style="padding-left: 5px;">
            <div class="small-block-container">
                <a class="small-block">Conditions</a><br>
                <a class="conditions-resistances-none">Conditions you are suffering will appear here.</a>
            </div>
            </div>
        </div>
        
</div>
            
</div>
            
        <?php
                
        }
        else {
            array_push($errors, "Invalid Character ID provided");
            }
        }
        
//        $sql = "SELECT * FROM `user-retainers` WHERE `User-Retainer-ID` LIKE $retainerid";
//        $result = $mysqli->query($sql);
//        $row3 = $result->fetch_assoc();
//        $portrait = $row3['image'];
//        $fontcolor = $row3['profile-font-toggle'];
//        $primarycolor = $row3['primary-colour'];
//        $secondarycolor = $row3['secondary-colour'];
//        $retainerlevel = $row3["Retainer-Level"];
//        $retainername = $row3["Retainer-Name"];
//        $retainertype = $row3["Retainer-Type"];
    }
            
            

       

//        include "retainercardgenerator.php";
        
        ?>
  
            
            
            
        </div>
    </div>
</div>
    
