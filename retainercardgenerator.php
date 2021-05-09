 <?php
error_reporting(0);
    session_start();

if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
}
        include "db_connect.php";

if (!empty($_GET["id"])) {
        $retainerid = mysqli_real_escape_string($conn,$_GET["id"]);
        $userid = $_SESSION["user_id"];
        
        $sql = "SELECT * FROM `user-retainers` WHERE `User-Retainer-ID` LIKE $retainerid";
        $result = $mysqli->query($sql);
        $row3 = $result->fetch_assoc();
        $portrait = $row3['image'];
        $fontcolor = $row3['profile-font-toggle'];
        $primarycolor = $row3['primary-colour'];
        $secondarycolor = $row3['secondary-colour'];
        $retainerlevel = $row3["Retainer-Level"];
        $retainername = $row3["Retainer-Name"];
        $retainertype = $row3["Retainer-Type"];
    }
elseif (!empty($_POST["id"])) {
        $retainerid = mysqli_real_escape_string($conn,$_POST["id"]);
        $userid = $_SESSION["user_id"];
        
        $sql = "SELECT * FROM `user-retainers` WHERE `User-Retainer-ID` LIKE $retainerid";
        $result = $mysqli->query($sql);
        $row3 = $result->fetch_assoc();
        $portrait = $row3['image'];
        $fontcolor = $row3['profile-font-toggle'];
        $primarycolor = $row3['primary-colour'];
        $secondarycolor = $row3['secondary-colour'];
        $retainerlevel = $row3["Retainer-Level"];
        $retainername = $row3["Retainer-Name"];
        $retainertype = $row3["Retainer-Type"];    
}
elseif (empty($_GET["id"])) {
//    echo "Using the quick generator";
    $image = $_FILES;
    // get text
    $target = "temp/".basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
        
    }else{
        $msg = "Failed to upload image";
        }
        $retainertype = $_POST["keyword"];
        $retainerlevel = $_POST["retainerlevel"];
        $retainername = $_POST["name"];
        $fontcolor = $_POST["font-color"];
        $primarycolor = $_POST['primary-color'];
        $secondarycolor = $_POST['secondary-color'];
        
    
    

        $sql = "SELECT * FROM retainer WHERE RetainerID LIKE '%" . $retainertype . "%'";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $retainertype = $row['RetainerID'];
        $portrait = $target;
//        echo $portrait;
    

}



                if (!empty($row3['Assoc-Character']) ) {
            $characterid = $row3['Assoc-Character'];  
            $sql = "SELECT * FROM `characters` WHERE `character_id` LIKE $characterid";
            $result = $mysqli->query($sql);
            $row = $result->fetch_assoc();
            $cardcharacter = $row['Character Name'];
//            print_r($row);
            }  
    
//        $keyword = "cutpurse";
//        $retainerlevel = 3;
//        $retainername = "Rolo";

        //Search database for keyword
        //echo "<h2>Lookup $keyword</h2>";     
        $sql = "SELECT * FROM `retainer` WHERE `RetainerID` LIKE $retainertype";
        $result = $mysqli->query($sql);
        
        
   
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
        ?>

<div id="retainer-front" class="card-front" style=
     <?php 
        echo '"border-color:'.$primarycolor.'";'
     ?>
     
     >
            <div id="retainer-card" class="container-fluid">
       
        <div id="retainer-portrait" class="row character-portrait" style="background-image: url(<?php echo $portrait; ?>);">

                    <?php
                        $retainerarmorid = $row["Armor-Type"];
                        $retainerpriabi = $row["Retainer-Pri-Abi"];
                        $retainersecabi = $row["Retainer-Secondary-Abi"];
                        $retainersigatt1 = $row["Signature-Attack-1"];
                        $retainersigatt2 = $row["Signature-Attack-2"];
                        $specialact1 = $row["Special-Action-1"];
                        $specialact2 = $row["Special-Action-2"];
                        $specialact3 = $row["Special-Action-3"];
//                        $fontcolor = $row3['profile-font-toggle'];
                    ?>
            
                <div class="npc-top-block">
                <div class="npc-name" style=<?php 
                    echo '"color:'.$fontcolor.';"';
                        
                     ?>
                     >
                    <?php
                    echo $retainername;
                    ?>
                </div>
                <div class="npc-type" style=<?php 
                    echo '"color:'.$fontcolor.';"';
                        
                     ?>
                     >
                    
                    <?php

                        echo $row["RetainerName"] . "<br> Level " . $retainerlevel . " <br>";
//                        echo $row3['profile-font-toggle'];
                    }
            
                    
            $sql = "SELECT * FROM `retainer-armor-types` WHERE `Retainer-Armor-ID` LIKE $retainerarmorid";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                    echo "AC: " . $row1["Retainer-Armor-Class"];
                }
              ?>      
                </div>
            </div>
        </div>
        <div class="linedivider" style=
     <?php 
        echo '"background:'.$primarycolor.'";'
     ?>
     
     
             
             ></div>
        <div id="retainer-abilities" class="container npc-abilities-container">
        <div class="row npc-abilities-background" style=
     <?php 
        echo '"background:'.$primarycolor.'";'
     ?>
     
     
             
             >
<!--            <div class="npc-abilities-background">-->
<!--                <div class="row" style="padding-left:18px;">-->
    <div class="npc-ability-mod-cont col-5" style=
     <?php 
        echo '"background:'.$secondarycolor.'";'
     ?>>
          <div class="row npc-ability-row">          
     <?php 
            if  (!empty($retainersecabi)) : {
                
                ?>
                <div class="col-4">
                    +4
                </div>    
                 <div class="col-4">
                    +4
                </div>
                 <div class="col-4">
                    +3
                </div>   
        <?php    }
            else: {
        ?>        
                <div class="col-6">
                    +4
                </div>    
                 <div class="col-6">
                    +3
                </div>
           <?php        
            }
            endif;
        ?>           
         </div>   
        <div class="row">        
   <?php 
            if  (!empty($retainersecabi)) : {
                
                ?>
      <div class="col-4">
                    <?php
            
            $sql = "SELECT * FROM `abilityscores` WHERE `AbiID` LIKE $retainerpriabi";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                    echo '<a class="abiabb">' . $row1["AbiScoreAbbr"] . "</a>";
                }
            
            ?>
        </div>
        <div class="col-4">
                   <?php
            
            $sql = "SELECT * FROM `abilityscores` WHERE `AbiID` LIKE $retainersecabi";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                    echo '<a class="abiabb">' . $row1["AbiScoreAbbr"] . "</a>";
                }
            
            ?>
        </div>
        <div class="col-4">
                        <a class="abiabb">OTH</a>
        </div>  
<?php   
            }
            else :{
            ?>    
        <div class="col-6">
                    <?php
            
            $sql = "SELECT * FROM `abilityscores` WHERE `AbiID` LIKE $retainerpriabi";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                    echo '<a class="abiabb">' . $row1["AbiScoreAbbr"] . "</a>";
                }
            
            ?>
        </div> 
        <div class="col-6">
                        <a class="abiabb">OTH</a>
        </div> 
                
<?php       
            }
                endif;
                ?>
        </div>            
    </div>
              
              
              

                        
    
                  
                <div class="npc-skill-cont col-6" style=
     <?php 
        echo '"background:'.$secondarycolor.'";'
     ?>>
                    <a style="font-family: Montserrat;">Skills</a><br>
                    <a class="skills">
                    
    <?php
            $sql= "SELECT `Skill Name`,`AbiID` FROM `skills` JOIN `retainer-skills` ON `skills`.`Skill ID` = `retainer-skills`.`Skill` JOIN `retainer` ON `retainer-skills`.`Retainer-Type` = `retainer`.`RetainerID` WHERE `retainer`.`RetainerID` LIKE $retainertype";
            $retainerskillresult = $mysqli->query($sql);
            $retainerskillarray = mysqli_fetch_all($retainerskillresult);
            
//            print_r($retainerskillarray);
            if (empty($retainerskillarray)) {
                echo "Skills have not been set up for this Retainer Type.";
            }
            else {
                foreach($retainerskillarray as $key => $skill) {
                    if ($skill[1]=$retainerpriabi) {
                    
                        if ($key === array_key_last($retainerskillarray)) {
                            echo $skill[0] . " +6";
                        }
                        else {
                            echo $skill[0] . " +6, ";
                        }
                        
                    }
                    else {
                        if ($key === array_key_last($retainerskillarray)) {
                            echo $skill[0] . " +3";
                        }
                        else {
                            echo $skill[0] . " +3, ";  
                        }
                        
                    }
                    
                }
            }
            ?>
                
    
                    </a>
                </div>
<!--                </div>-->
</div>
<!--            </div>-->
        </div>
        <div class="healthline" style="<?php 
        echo 'background:'.$primarycolor.'";'
     ?>"></div>
        <div class="speedline" style="<?php 
        echo 'background:'.$primarycolor.'";'
     ?>"></div>
        <div class="row npc-health-speed-cont" >
            <div class="npc-abilities-background" style=
     <?php 
        echo '"background:'.$primarycolor.'";'
     ?>>
            <div class="npc-health-speed" style="margin-right: 1px;
     <?php 
        echo 'background:'.$secondarycolor.'";'
     ?>" >
                <a>Health:</a>
            </div>
            <div class="npc-health-speed" style="margin-left: 0px; border-radius: 30px 60px 60px 30px; <?php 
        echo 'background:'.$secondarycolor.'";'
     ?>">
                <?php for ($i=0; $i < $retainerlevel; $i++) { ?>
                <input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>
                <?php } ?>
            </div>
            </div>
            <div class="npc-abilities-background" style=
     <?php 
        echo '"background:'.$primarycolor.'";'
     ?>>
            <div class="npc-health-speed" style="margin-right: 1px; <?php 
        echo 'background:'.$secondarycolor.'";'
     ?>">
                <a>Speed:</a>
            </div>
            <div class="npc-health-speed" style="margin-left: 0px; border-radius: 30px 60px 60px 30px; <?php 
        echo 'background:'.$secondarycolor.'";'
     ?>">
                <a>30 ft.</a>
            </div>
            </div>
        
        
        </div>
        
        <div class="row">
            <div class="col">
                <a class="cardheaders">Signature Attacks</a>
            </div>
        </div>
        <div class="row signature-attack">
            <div class="row action-header">
                <div class="col-9 action-header">
                    <a class="signature-attack-header">
            <?php
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $retainersigatt1";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                    echo $row1["Retainer-Action-Name"] . ".";
                      
            ?>
                    </a>
                    <a class="action-type">
            <?php
                    echo $row1["Retainer-Action-Type"] . ".";
                    
            ?>
                    </a>
                </div>
                <div class="col-3 action-duration-header">
                <a class="action-duration">
            <?php
                    echo $row1["Retainer-Action-Duration"] . ".";
                    
            ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col action-text">
                <a class="action-text">
                                <?php
                      $string = $row1["Retainer-Action-Text"];
                    $string = str_replace(array("\n", "\r"), '', $string);
                    $string = stripslashes($string);
                    echo $string;
                    }
            ?>
                    </a>
                </div>
            </div>
        </div>
        <?php 
            if($retainersigatt2 != "") : {
                ?>
        <div class="row signature-attack">
            <div class="row action-header">
                <div class="col-9 action-header">
                    <a class="signature-attack-header">
            <?php
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $retainersigatt2";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                    echo $row1["Retainer-Action-Name"] . ".";
                      
            ?>
                    </a>
                    <a class="action-type">
            <?php
                    echo $row1["Retainer-Action-Type"] . ".";
                    
            ?>
                    </a>
                </div>
                <div class="col-3 action-duration-header">
                <a class="action-duration">
            <?php
                    echo $row1["Retainer-Action-Duration"] . ".";
                    
            ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col action-text">
                <a class="action-text">
                                <?php
                    $string = $row1["Retainer-Action-Text"];
                    $string = str_replace(array("\n", "\r"), '', $string);
                    $string = stripslashes($string);
                    echo $string;
                    }
            ?>
                    </a>
                </div>
            </div>
        </div>
        <?php 
            }
                endif;
                ?>
        <?php 
            if($retainerlevel > 2) : {?>
        <div class="row">
            <div class="col">
                <a class="cardheaders">Special Actions</a>
            </div>
        </div>
        <div class="row signature-attack">
            <div class="row action-header">
                <div class="col-8 action-header">
                    <a class="signature-attack-header">
            <?php
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $specialact1";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                
                    echo $row1["Retainer-Action-Name"] . ".";
                
            ?>
                    </a>
                    <a class="action-type">
            <?php
                    If (empty($row1["Retainer-Action-Name"])) {
                    echo $row1["Retainer-Action-Type"] . ".";
                    }
                    
                    For ($i = 0; $i < $row1{"Retainer-Action-Uses"}; $i++) {
                        echo '<input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>';
                            

                    }
            ?>
                    </a>
                </div>
                <div class="col-4 action-duration-header">
                <a class="action-duration">
            <?php
                    echo $row1["Retainer-Action-Duration"] . ".";
                    
            ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col action-text">
                <a class="action-text">
                                <?php
                    $string = $row1["Retainer-Action-Text"];
                    $string = str_replace(array("\n", "\r"), '', $string);
                    $string = stripslashes($string);
                    echo $string;
                    }
            ?>
                    </a>
                </div>
            </div>
        </div>
        
        <?php if($retainerlevel > 4) : {?>
                
        <div class="row signature-attack">
            <div class="row action-header">
                <div class="col-8 action-header">
                    <a class="signature-attack-header">
            <?php
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $specialact2";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                
                    echo $row1["Retainer-Action-Name"] . ".";
                
            ?>
                    </a>
                    <a class="action-type">
            <?php
                    If (empty($row1["Retainer-Action-Name"])) {
                    echo $row1["Retainer-Action-Type"] . ".";
                    }
                    
                    For ($i = 0; $i < $row1{"Retainer-Action-Uses"}; $i++) {
                        echo '<input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>';
                            

                    }
            ?>
                    </a>
                </div>
                <div class="col-4 action-duration-header">
                <a class="action-duration">
            <?php
                    echo $row1["Retainer-Action-Duration"] . ".";
                    
            ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col action-text">
                <a class="">
                                <?php
                    $string = $row1["Retainer-Action-Text"];
                    $string = str_replace(array("\n", "\r"), '', $string);
                    $string = stripslashes($string);
                    echo $string;
                    }
            ?>
                    </a>
                </div>
            </div>
        </div>
        <?php if($retainerlevel >6): {?>
        <div class="row signature-attack">
            <div class="row action-header">
                <div class="col-8 action-header">
                    <a class="signature-attack-header">
            <?php
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $specialact3";
            $result1 = $mysqli->query($sql);
                while ($row1 = $result1->fetch_array()) {
                
                    echo $row1["Retainer-Action-Name"] . ".";
                
            ?>
                    </a>
                    <a class="action-type">
            <?php
                    If (empty($row1["Retainer-Action-Name"])) {
                    echo $row1["Retainer-Action-Type"] . ".";
                    }
                    
                    For ($i = 0; $i < $row1{"Retainer-Action-Uses"}; $i++) {
                        echo '<input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>';
                            

                    }
            ?>
                    </a>
                </div>
                <div class="col-4 action-duration-header">
                <a class="action-duration">
            <?php
                    echo $row1["Retainer-Action-Duration"] . ".";
                    
            ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div id="actiontext" class="col action-text">
                <a class="action-text">
                                <?php
                    $string = $row1["Retainer-Action-Text"];
                    $string = str_replace(array("\n", "\r"), '', $string);
                    $string = stripslashes($string);
                    echo $string;
                    
                        }
            ?>
                    </a>
                </div>
            </div>
        </div>
            <?php
            } 
               endif; 
            }  
                endif;
            ?>
                   
                    
            
        
        <?php
                }
                 endif;?>
        <div class="row signature-attack">
            <a style="font-size: 11px;"><strong>Retainer to:</strong>
            <?php 
            
                
                    echo $cardcharacter;
            
            
                ?>
                </a>
        </div>
    
    </div>
</div>


            
<?php
                    } else {
                    echo "There was a problem with looking up the Retainer Type.";
                    }
?>