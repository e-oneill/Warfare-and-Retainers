<?php
error_reporting(0);
//error_reporting(E_ALL);
    session_start();

if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
}
?>
<?php include "update_retainer_type.php";?>
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

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>

<!-- CHANGE TEXT AREAS TO RTF-->
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script type='text/javascript'>
function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
 document.getElementById("image-button").innerHTML = "Upload New Image";
}

function URL_add_parameter(url, param, value)
    {
    var hash       = {};
    var parser     = document.createElement('a');

    parser.href    = url;

    var parameters = parser.search.split(/\?|&/);

    for(var i=0; i < parameters.length; i++) {
        if(!parameters[i])
            continue;

        var ary      = parameters[i].split('=');
        hash[ary[0]] = ary[1];
    }

    hash[param] = value;

    var list = [];  
    Object.keys(hash).forEach(function (key) {
        list.push(key + '=' + hash[key]);
    });

    parser.search = '?' + list.join('&');
//    return parser.href;
    location.href = parser.search;
}
    
$(document).ready(function(){
 
  // Initialize select2
  $("#skills").select2();

  // Read selected option
  $('#but_read').click(function(){
    var username = $('#skills option:selected').text();
    var userid = $('#skills').val();

    $('#result').html("id : " + userid + ", name : " + username);

  });
    
    // Initialize select2
  $("#saves").select2();

  // Read selected option
  $('#but_read').click(function(){
    var username = $('#saves option:selected').text();
    var userid = $('#saves').val();

    $('#result').html("id : " + userid + ", name : " + username);

  });
});

</script>     

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src='select2/dist/js/select2.min.js' type='text/javascript'></script>

<!-- CSS -->
<link href='select2/dist/css/select2.min.css' rel='stylesheet' type='text/css'>
<link href="dmtools.css" rel="stylesheet" type="text/css">
    
    </head>
<body>
<?php include "page-header.php"; ?>
<hr>
    

<br/>
<div id='result'></div>
    
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a>My Retainers</a></li>
  </ol>
</nav>
 <?php 
          

if (!empty($_SESSION['username'])) {
    
     include "db_connect.php";
    
    $sql = "SELECT * FROM retainer WHERE RetainerID LIKE ?";
    
    if($stmt = mysqli_prepare($conn,$sql)){
    $retainerid = mysqli_real_escape_string($conn, $_GET['id']);
    mysqli_stmt_bind_param($stmt, "i", $retainerid);
        if (mysqli_stmt_execute($stmt)){
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) {
        
                
            $retainername = $row['RetainerName'];    
            $baseclass = $row['RetainerBaseClass'];
            $id = $row['RetainerID'];
            $user_creator = $row['Creator_user'];
            $armor_id = $row['Armor-Type'];
            $primaryabi = $row['Retainer-Pri-Abi'];
            $secondaryabi = $row['Retainer-Secondary-Abi'];
            $save1 = $row['Retainer-Save1'];
            $save2 = $row['Retainer-Save2'];
            $sig1 = $row['Signature-Attack-1'];
            $sig2 = $row['Signature-Attack-2'];
            $spec1 = $row['Special-Action-1'];
            $spec2 = $row['Special-Action-2'];
            $spec3 = $row['Special-Action-3'];
            
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $save1";
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $save1name = $row2['AbilityScoName'];
            if (!empty($save2)) {
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $save2";
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $save2name = $row2['AbilityScoName'];    
            }
            
            if (!empty($secondaryabi)) {
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $primaryabi OR `AbiID` LIKE $secondaryabi";
            $abilities = $mysqli->query($sql);
   
            }
            else {
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $primaryabi";
            $abilities = $mysqli->query($sql);
            }
             
            $sql = "SELECT `skills`.`Skill ID`,`skills`.`Skill Name`  FROM `retainer-skills` INNER JOIN `skills` ON `retainer-skills`.`Skill` = `skills`.`Skill ID` WHERE `Retainer-Type` LIKE $id";
            $result2 = $mysqli->query($sql);
//            $skills = $result2->fetch_all();
                
            while ($row2 = $result2->fetch_assoc()){
                $skills[] = $row2;
            }    
                
                
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $sig1";
            $result2 = $mysqli->query($sql);
            $sig1row = $result2->fetch_assoc();
            

            
            if (!empty($sig2)) {
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $sig2";
            $result2 = $mysqli->query($sql);
            $sig2row = $result2->fetch_assoc();
            }

            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $spec1";
            $result2 = $mysqli->query($sql);
            $spec1row = $result2->fetch_assoc();

                
            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $spec2";
            $result2 = $mysqli->query($sql);
            $spec2row = $result2->fetch_assoc();

            $sql = "SELECT * FROM `retainer-actions` WHERE `Retainer-Action-ID` LIKE $spec3";
            $result2 = $mysqli->query($sql);
            $spec3row = $result2->fetch_assoc();
            
//            echo "<pre>";
//            print_r($spec2row);
//            echo "</pre>";
                
            }
            }
            else {
                echo "ID for Retainer Type was incorrect or you do not have permissions to edit!";
            }
        }
            
    } else {
        echo "SQL boolean came up false";
    }

    
    
  
            ?>
<div style="padding:2rem;">   
<?php
    
    include "changes.php";
    ?>
<?php
$formlink = '"edit_retainer_type.php?id=' . $retainerid . '"';    
    ?>
<form method="post" action=<?php echo $formlink; ?> enctype="multipart/form-data">

<fieldset>
<div class="row">
<div class="col-md-12 col-lg-6">
<div class="user-control-part">
<legend class="form-legend">Basics</legend>
<hr>    
 <div class="form-group">
  <label class="col-md-12 control-label" for="retainername">Name</label>  
  <div class="col-md-12">
  <input id="retainerid" name="retainerid" type="hidden" placeholder="" class="form-control input-md hidden" required="" 
         <?php echo 'value="'.$retainerid.'"'; ?> 
         > 
  <input id="retainername" name="retainername" type="text" placeholder="" class="form-control input-md" required="" 
         <?php echo 'value="'.$retainername.'"'; ?> 
         > 
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-12 control-label" for="RetainerBaseClass">Class</label>
  <div class="col-md-12">
    <select id="RetainerBaseClass" name="RetainerBaseClass" class="form-control">
    <?php
    $stmt = "SELECT `id`, `name` FROM classes";
    $result = $mysqli->query($stmt);
    
    while ($row = $result->fetch_assoc())
    {
        if ($row['id'] == $baseclass) {
           echo '<option value="' . $row['id'] . '" selected="selected">' . $row['name'] . '</option>'; 
        } else {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
    }
          

    
    ?>    
    
    </select>
    <a class="help-block">Select the class that this retainer is based on.</a>
    </div>
</div>


<!-- Select Basic -->
<div class="form-group" style="margin-bottom:1.5rem;">
  <label class="col-md-12 control-label" for="armor-type">Armor</label>
  <div class="col-md-12">
    <select id="armor-type" name="armor-type" class="form-control">
    <?php 
        if ($armor_id == 1) {
      ?> 
      <option value="1" selected="selected">Light</option>
      <option value="2">Medium</option>
      <option value="3">Heavy</option>
        <?php    
        } elseif ($armor_id == 2) {  
            ?>
      <option value="1">Light</option>
      <option value="2" selected="selected">Medium</option>
      <option value="3">Heavy</option>
        <?php
        } elseif ($armor_id == 3) {
        ?>
      <option value="1">Light</option>
      <option value="2" >Medium</option>
      <option value="3" selected="selected">Heavy</option>

        <?php
        }
        ?>
        
    </select>
      <a class="help-block">Light: 13 AC | Medium: 15 AC | Heavy: 18 AC</a>
      </div>
    </div> 
</div>
</div>
<div class="col-md-12 col-lg-6">
<div class="user-control-part">
<legend class="form-legend">Stats</legend>
<hr>
    
<div class="col-12">
<strong>Abilities</strong>
</div>
<div class="col-12" style="margin-bottom:1rem;">
<a>Select a primary ability for the character, and a secondary (if applicable)</a>
    

    
</div>
<div class="col-6 form-col"><strong>Primary Ability</strong></div>
   <div class="col-5 form-col" style="margin-bottom:1rem;">
    <select id="Retainer-Pri-Abi" name="Retainer-Pri-Abi" class="form-control" style="width: 119%;">
<?php 
    $sql = "SELECT `AbiID`,`AbilityScoName` FROM `abilityscores`";
    $abiresult = $mysqli->query($sql);
    while ($sixability = $abiresult->fetch_assoc()){
        $sixabilities[] = $sixability;
    }
//    echo "<pre>";    
//    print_r($sixabilities);  
//    echo "</pre>"
        
    foreach ($sixabilities as $ability) {
        
            if ($ability['AbiID']==$primaryabi) {
                echo '<option value="'.$ability['AbiID'].'" selected="selected">'.$ability['AbilityScoName'].'</option>';    
            } else {

                echo '<option value="'.$ability['AbiID'].'">'.$ability['AbilityScoName'].'</option>';
            }
        }
        
            ?>
    </select>
  </div>
  
<div class="col-6 form-col">
    <div class="checkbox">
    <strong style="padding-left:0rem;">Secondary Ability</strong>
    </div>
    </div>
    <div class="col-5 form-col" >
    <select id="Retainer-Sec-Abi" name="Retainer-Sec-Abi" class="form-control" value="0" style="width: 119%;">
        <option value="0">None</option>
<?php 
//    echo "<pre>";    
//    print_r($sixabilities);  
//    echo "</pre>"
        
    foreach ($sixabilities as $ability) {
        
            if ($ability['AbiID']==$secondaryabi) {
                echo '<option value="'.$ability['AbiID'].'" selected="selected">'.$ability['AbilityScoName'].'</option>';    
            } else {

                echo '<option value="'.$ability['AbiID'].'">'.$ability['AbilityScoName'].'</option>';
            }
        }
        
            ?>
    </select>
    </div>
    <div class="col-6 form-col" style="margin-top: 1.25rem;">
    <div class="checkbox">
    <strong style="padding-left:0rem;">Saves</strong>
    </div>
    </div>
    <div class="col-5 form-col" >
    <select id='saves' name="saves[]" class="selectpicker" style="width:119%; margin-left: -5%;" multiple>
<?php 
//    echo "<pre>";    
//    print_r($sixabilities);  
//    echo "</pre>"
        
    foreach ($sixabilities as $ability) {
        
            if (($ability['AbiID']==$save1) or ($ability['AbiID']==$save2)) {
                echo '<option value="'.$ability['AbiID'].'" selected="selected">'.$ability['AbilityScoName'].'</option>';    
            } else {

                echo '<option value="'.$ability['AbiID'].'">'.$ability['AbilityScoName'].'</option>';
            }
        }
        
            ?>
    </select>
    </div>
    <hr>
    <div class="col-12" style="margin-bottom: 0.25rem;">
    <strong>Skills</strong>
    </div>
    <div class="col-12" style="margin-bottom:.75rem;">
<select id='skills' name="skills[]" class="selectpicker" style="width:100%; margin-left: -5%;" multiple>
        <?php
    $stmt = "SELECT `Skill ID`, `Skill Name` FROM skills";
    $result = $mysqli->query($stmt);
    while ($row = $result->fetch_assoc())
    {
        if (array_search($row['Skill ID'],array_column($skills,'Skill ID')) !== false) {
           echo '<option value="' . $row['Skill ID'] . '" selected="selected">' . $row['Skill Name'] . '</option>'; 
        } else {
           echo '<option value="' . $row['Skill ID'] . '">' . $row['Skill Name'] . '</option>'; 
        }
        
    }
          

    
    ?>
    
</select>
  </div>

</div>
</div>
    
<div class="col-md-12 col-lg-12">
<div class="user-control-part">
<legend class="form-legend">Actions</legend>
<hr>
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-6">
<label class="control-label">Signature Attack</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
    <input type="hidden" name="sig-one-id" value<?php echo '="'.$sig1row['Retainer-Action-ID'].'"';?>>
    <input type="hidden" name="sig-one-bool" value<?php echo '="'.$sig1row['Is-Signature-Attack'].'"';?>>
    <input id="retainer-action-name" name="sig-one-name" type="text" placeholder="Name" class="form-control input-md" required="" value<?php echo '="'.$sig1row['Retainer-Action-Name'].'"';?>>
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 <?php
        $string = $sig1row["Retainer-Action-Text"];
        $string = str_replace(array("\n", "\r"), '', $string);
        $string = stripslashes($string);
    ?>
    
    
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="sig-one-text" name="sig-one-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."><?php echo $string ?></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="sig-one-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" required="" value<?php echo '="'.$sig1row['Retainer-Action-Type'].'"';?>>
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="sig-one-duration" type="text" placeholder="Action" class="form-control input-md" required="" value<?php echo '="'.$sig1row['Retainer-Action-Duration'].'"';?>>
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-0" value="0" checked="checked" />
      At Will
    </label>
      
<?php 
    
    if ($sig1row['Retainer-Action-Uses'] == 1) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-1" value="1" checked="checked">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-2" value="3" >
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-3" value="5">
      5
    </label>        
<?php    }
    elseif ($sig1row['Retainer-Action-Uses'] == 2) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-2" value="3" checked="checked">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-3" value="5">
      5
    </label>      
<?php    }
    elseif ($sig1row['Retainer-Action-Uses'] == 3) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-3" value="5">
      5
    </label>      
    
<?php    } else { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig-one-uses" id="sig1-action-uses-3" value="5">
      5
    </label>      
      
<?php    } ?>      
      
      
    

  </div>
<!--</div>-->
</div>
<label href="#Sig-Attack-2" class="form-button" data-toggle="collapse" data-target="#Sig-Attack-2" style="width:100%;padding-top:0.5rem; margin-left: 0;"> + Second Signature Attack</label>
</div>
    
<!-- SECOND SIGNATURE ATTACK - CHECK IS EMPTY BEFORE DECIDING WHETHER TO IMPORT DATA    -->
    <?php if (!empty($sig2)) {
        
        $string = $sig2row["Retainer-Action-Text"];
        $string = str_replace(array("\n", "\r"), '', $string);
        $string = stripslashes($string);
        
    ?>    
<div id="Sig-Attack-2" class="col-sm-12 col-md-12 col-lg-6 collapse in">
<label class="control-label">Signature Attack</label>
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
    <input type="hidden" name="sig-two-id" value<?php echo '="'.$sig2row['Retainer-Action-ID'].'"';?>>
    <input type="hidden" name="sig-two-bool" value<?php echo '="'.$sig2row['Is-Signature-Attack'].'"';?>>
    <input id="retainer-action-name" name="sig-two-name" type="text" placeholder="Name" class="form-control input-md" value<?php echo '="'.$sig2row['Retainer-Action-Name'].'"';?>>
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="retainer-action-text" name="sig-two-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."><?php echo $string; ?></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="sig-two-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" value<?php echo '="'.$sig2row['Retainer-Action-Type'].'"';?>>
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="sig-two-duration" type="text" placeholder="Action" class="form-control input-md" value<?php echo '="'.$sig2row['Retainer-Action-Duration'].'"';?>>
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-0" value="null" checked="checked">
      At Will
    </label>
      
<?php 
    
    if ($sig2row['Retainer-Action-Uses'] == 1) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-1" value="1" checked="checked">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-2" value="3" >
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-3" value="5">
      5
    </label>        
<?php    }
    elseif ($sig2row['Retainer-Action-Uses'] == 2) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig2e-uses" id="sig2-action-uses-2" value="3" checked="checked">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-3" value="5">
      5
    </label>      
<?php    }
    elseif ($sig2row['Retainer-Action-Uses'] == 3) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-3" value="5">
      5
    </label>      
    
<?php    } else { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-3" value="5">
      5
    </label>      
      
<?php    } ?> 
  </div>
<!--</div>-->
</div>
</div>         
<?php        
    } else { 
    
    ?>
<div id="Sig-Attack-2" class="col-sm-12 col-md-12 col-lg-6 collapse in">
<label class="control-label">Signature Attack</label>
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
  <input type="hidden" name="sig-two-bool" value="1">  
  <input id="retainer-action-name" name="sig-two-name" type="text" placeholder="Name" class="form-control input-md">
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="retainer-action-text" name="sig-two-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="sig-two-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" >
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="sig-two-duration" type="text" placeholder="Action" class="form-control input-md" >
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="sig-two-uses" id="sig2-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig2-uses" id="sig2-action-uses-3" value="5">
      5
    </label>   
      

  </div>
  </div>
<!--</div>-->
</div>       
<?php    } 
        $string = $spec1row["Retainer-Action-Text"];
        $string = str_replace(array("\n", "\r"), '', $string);
        $string = stripslashes($string);    
    
    
    ?>

<div class="col-sm-12 col-md-12 col-lg-6">
<label class="control-label">Level 3 Action</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
      <input type="hidden" name="spec-one-id" value<?php echo '="'.$spec1row['Retainer-Action-ID'].'"';?>>
  <input id="retainer-action-name" name="spec-act-one-name" type="text" placeholder="Name" class="form-control input-md" required="" value<?php echo '="'.$spec1row['Retainer-Action-Name'].'"';?>>
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="spec-act-one-text" name="spec-act-one-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."><?php echo $string; ?></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="spec-act-one-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" value<?php echo '="'.$spec1row['Retainer-Action-Type'].'"';?>>
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="spec-act-one-duration" type="text" placeholder="Action" class="form-control input-md" required="" value<?php echo '="'.$spec1row['Retainer-Action-Duration'].'"';?>>
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="spec1-uses" id="retainer-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
<?php 
    
    if ($spec1row['Retainer-Action-Uses'] == 1) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-1" value="1" checked="checked">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-2" value="3" >
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-3" value="5">
      5
    </label>        
<?php    }
    elseif ($spec1row['Retainer-Action-Uses'] == 2) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-2" value="3" checked="checked">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-3" value="5">
      5
    </label>      
<?php    }
    elseif ($spec1row['Retainer-Action-Uses'] == 3) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-2" value="3" >
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-3" value="5" checked>
      5
    </label>      
    
<?php    } else { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec1-uses" id="spec1-action-uses-3" value="5">
      5
    </label>      
      
<?php    } ?> 
  </div>
<!--</div>-->
</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-6">
    
<?php
        $string = $spec2row["Retainer-Action-Text"];
        $string = str_replace(array("\n", "\r"), '', $string);
        $string = stripslashes($string);   
    
    ?>
<label class="control-label">Level 5 Action</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
      <input type="hidden" name="spec-two-id" value<?php echo '="'.$spec2row['Retainer-Action-ID'].'"';?>>
  <input id="retainer-action-name" name="spec-act-two-name" type="text" placeholder="Name" class="form-control input-md" required="" value<?php echo '="'.$spec2row['Retainer-Action-Name'].'"';?>>
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="spec-act-one-text" name="spec-act-two-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."><?php echo $string; ?></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="spec-act-two-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" value<?php echo '="'.$spec2row['Retainer-Action-Type'].'"';?>>
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="spec-act-two-duration" type="text" placeholder="Action" class="form-control input-md" required="" value<?php echo '="'.$spec2row['Retainer-Action-Duration'].'"';?>>
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
<?php 
    
    if ($spec2row['Retainer-Action-Uses'] == 1) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-1" value="1" checked="checked">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-2" value="2" >
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-3" value="3">
      5
    </label>        
<?php    }
    elseif ($spec2row['Retainer-Action-Uses'] == 2) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-2" value="2" checked="checked">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-3" value="3">
      5
    </label>      
<?php    }
    elseif ($spec2row['Retainer-Action-Uses'] == 3) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-2" value="2">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-3" value="3" checked>
      5
    </label>      
    
<?php    } else { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-2" value="2">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec2-uses" id="spec2-action-uses-3" value="3">
      5
    </label>      
      
<?php    } ?>
  </div>
<!--</div>-->
</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-6">

<?php
        $string = $spec3row["Retainer-Action-Text"];
        $string = str_replace(array("\n", "\r"), '', $string);
        $string = stripslashes($string);   
    
    ?>

<label class="control-label">Level 7 Action</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
      <input type="hidden" name="spec-three-id" value<?php echo '="'.$spec3row['Retainer-Action-ID'].'"';?>>
  <input id="retainer-action-name" name="spec-act-three-name" type="text" placeholder="Name" class="form-control input-md" required="" value<?php echo '="'.$spec3row['Retainer-Action-Name'].'"';?>>
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="spec-act-three-text" name="spec-act-three-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."><?php echo $string; ?></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="spec-act-three-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" value<?php echo '="'.$spec3row['Retainer-Action-Type'].'"';?>>
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="spec-act-three-duration" type="text" placeholder="Action" class="form-control input-md" required="" value<?php echo '="'.$spec3row['Retainer-Action-Duration'].'"';?>>
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
<?php 
    
    if ($spec3row['Retainer-Action-Uses'] == 1) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-1" value="1" checked="checked">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-2" value="2" >
      3
    </label> 
    <label class="radio-inline" forspec3="retainer-action-uses-3">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-3" value="3">
      5
    </label>        
<?php    }
    elseif ($spec3row['Retainer-Action-Uses'] == 2) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-2" value="2" checked="checked">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-3" value="3">
      5
    </label>      
<?php    }
    elseif ($spec3row['Retainer-Action-Uses'] == 3) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-2" value="2">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-3" value="3" checked>
      5
    </label>      
    
<?php    } else { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-2" value="2">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec3-uses" id="spec3-action-uses-3" value="3">
      5
    </label>      
      
<?php    } ?>
  </div>
<!--</div>-->
</div>
</div>
</div>
</div>     
    
</div>
<div class="col-12">
<div class="user-control-part">
<div class="form-group">

  <label class="col-md-10 control-label" for="createretainer"></label>
  <div class="col-md-10">
    <button id="updateretainer" name="updateretainer" class="btn form-button" style="width:100%;height:100%;font-size:20px;"><strong>Update Retainer Type</strong></button> 
  </div>
</div>
</div>
</div>    

</div>
</fieldset>
 
</form>    


</div>   
    
    
    

<?php 
}
        else {
            ?>
    <a>You must be </a><a href="login.php">logged in</a><a> in to create retainers, if you just want to test the tool, use the </a><a href="quickretainercreator.php">Quick Retainer Creator</a><a>.</a>   
    <?php        
        } ?>
    </body>
</html>