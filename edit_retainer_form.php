<?php 
    error_reporting(0);
    session_start();

if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
}
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

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script type='text/javascript'>
function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('retainer-portrait');
  output.style.backgroundImage = "url('" + reader.result; + "')"
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
</script>     

<link href="dmtools.css" rel="stylesheet" type="text/css">
    
    </head>
<body>
<?php include "page-header.php"; ?> 
<?php 
        include "db_connect.php";
        $userid = $_SESSION['user_id'];
        $retainer_id = $_GET['id'];
        
        $sql = "SELECT * FROM `user-retainers` WHERE `User-Retainer-ID` LIKE $retainer_id";    
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();

        $retainer_user_id = $row['User'];
            
        if ($retainer_user_id=$userid): {
            
        $retainername = $row['Retainer-Name'];
        $retainerlevel = $row['Retainer-Level'];
        $retainertypeid = $row['Retainer-Type'];
        $assoc_character = $row['Assoc-Character'];
        $primarycolor = $row['primary-colour'];
        $secondarycolor = $row['secondary-colour'];
        $fontcolor = $row['profile-font-toggle']; 
    ?>    

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a href="myretainers.php">My Retainers</a></li>
    <li class="breadcrumb-item"><a>Edit Retainer: <?php echo $retainername; ?></a></li>  
  </ol>
</nav>
    
<div class=container-flex style="padding-left:1em;">
    <div class="row">
        <div class="col-md-6 user-control-part">

<form method="post" enctype="multipart/form-data" action="/edit_retainer.php">
<fieldset>
    <?php        
            
        $sql = "SELECT * FROM `characters` WHERE `character_id` LIKE $assoc_character";
        
            
            
        $result2 = $mysqli->query($sql);
        if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $assoc_character = $row2['Character Name'];
        }
    
        $sql ="SELECT RetainerName FROM retainer WHERE RetainerID LIKE $retainertypeid";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $retainertype = $row['RetainerName'];
            
        $userid = $_SESSION['user_id'];
    

        $pdo = new PDO('mysql:host=localhost;dbname=dnd','monkehh','177300Milan!');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//        $q = $pdo->query('SELECT RetainerName, RetainerBaseClass FROM retainer');
        $q = $pdo->query('SELECT `classes`.`name`,`retainer`.`RetainerName`, `retainer`.`RetainerBaseClass`, `retainer`.`RetainerID` FROM `retainer` INNER JOIN `classes` ON `retainer`.`RetainerBaseClass` = `classes`.`id` WHERE `retainer`.`Creator_user` LIKE 1 OR `retainer`.`Creator_user` LIKE ' . $userid . ' ORDER BY `classes`.`name`');
    
        $retainers = $q->fetchAll();   
//        echo "<pre>";
//        print_r($retainers);
//        echo "</pre>";

        $stmt = $mysqli->prepare("SELECT `Character Name` FROM `characters` WHERE `User` LIKE $userid");
        $stmt->execute();
        $characters = [];
            
        foreach ($stmt->get_result() as $row2) {
            $characters[] = $row2['Character Name'];
        } 
    ?>
<!-- Form Name -->
<legend>Edit Retainer</legend>

    

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="name">Retainer Name</label>  
  <div class="col-md-12">
  <input id="name" name="name" type="text" value=<?php echo '"'.$retainername.'"' ?> class="form-control input-md" required="">  
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-12 control-label" for="type">Retainer Type</label>
  <div class="col-md-12">
<select name="type" id="type" class="form-control" value="<?php echo '"'.$retainertype.'"' ?>">  
   <?php
    
          
//        sort($retainers, SORT_STRING);
//        foreach ($retainers as $key => $item)  {
//            $value = $item['RetainerName'];
//            printf('<option>%s</option>option>',$value);
//            
//        }
    
        $lastoptiongroup = "";
        $array_keys = array_keys($retainers);
        $last_key = end($array_keys);
        $optgroups = [];
        
        reset($retainers);
        foreach ($retainers as $key => $item)  {
            $value = $item['RetainerName'];
            $itemid = $item['RetainerID'];
            $optiongroup = $item['name'];
            
            if ($lastoptiongroup === "") {
            echo '<optgroup label=' . $optiongroup . '>';
            // CHECK IF THE CURRENT RETAINER IS THE OPTION BEING INSERTED
            if ($itemid == $retainertypeid) {
                echo '<option value="'.$itemid.'" selected="selected">'.$value.'</option>';
            } else {
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            }
                
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                } 
            }
            elseif (($lastoptiongroup == $optiongroup) and ($key !== $last_key)) {
            // CHECK IF THE CURRENT RETAINER IS THE OPTION BEING INSERTED
            if ($itemid == $retainertypeid) {
                echo '<option value="'.$itemid.'" selected="selected">'.$value.'</option>';
            } else {
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            }
                
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                }   
            }
            elseif (($lastoptiongroup !== $optiongroup) and ($key !== $last_key)) {
            echo '</optgroup>';
            echo '<optgroup label=' . $optiongroup . '>';
                
            // CHECK IF THE CURRENT RETAINER IS THE OPTION BEING INSERTED
            if ($itemid == $retainertypeid) {
                echo '<option value="'.$itemid.'" selected="selected">'.$value.'</option>';
            } else {
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            }
                
                
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                }  
            }
            elseif (($lastoptiongroup == $optiongroup) and ($key == $last_key)) {
            // CHECK IF THE CURRENT RETAINER IS THE OPTION BEING INSERTED
            if ($itemid == $retainertypeid) {
                echo '<option value="'.$itemid.'" selected="selected">'.$value.'</option>';
            } else {
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            }
                
            echo '</optgroup>';
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                } 
            }
            elseif (($lastoptiongroup !== $optiongroup) and ($key == $last_key)) {
            echo '</optgroup>';
            echo '<optgroup label=' . $optiongroup . '>';
            // CHECK IF THE CURRENT RETAINER IS THE OPTION BEING INSERTED
            if ($itemid == $retainertypeid) {
                echo '<option value="'.$itemid.'" selected="selected">'.$value.'</option>';
            } else {
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            }
                
            echo '</optgroup>';
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                } 
            }
            
        }
    
    
    ?>  
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-12 control-label" for="level">Level</label>
  <div class="col-md-12">
    <select id="level" name="level" class="form-control">
        
    <?php
    for ($i = 1; $i < 8; $i++) {
    
        if ($i != $retainerlevel):{
        echo "<option>".$i."</option>";
        
//        if ($i=$retainerlevel):{
//        echo "<option selected>".$i."</option>";
//        }
//        elseif ($i!=$retainerlevel): {
//        echo "<option>".$i."</option>";    
//        }
//        endif;
//        '<option value="'.$i.'">'.$i.'</option>';
    }
        else: {
           echo "<option selected>".$i."</option>"; 
        }
        endif;
    }
            ?>
    </select>
  </div>
</div>
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-12 control-label" for="assoc-character">Character</label>
  <div class="col-md-12">
<select name="assoc-character" id="array" class="form-control">
    <option value="NULL">Unassigned</option>
    <?php
              
        sort($retainers, SORT_STRING);
        foreach ($characters as $value)  {
            
            if ($value!=$assoc_character): {
                echo '<option value="'.$value.'">'.$value.'</option>';   
            }
            elseif ($value=$assoc_character): {
            echo '<option value="'.$value.'"selected>'.$value.'</option>';   
            
            }
            
            endif;           
        }
            
    
    ?>      
    </select>
    <a style="font-style: italic;">Who does this retainer serve?</a>
  </div>
</div>

<div class="form-group">


<div id="wrapper" class="col">
<img id="output_image" style="width:100%;"/>
  <label class="form-button" id="image-button" for="image" style="width:100%; padding-top:0.5rem; margin-left: 0;" onclick="preview_image(event)"> + Character Image</label>
 <input id="image" type="file" accept="image/*" name="image" onchange="preview_image(event)">
 
</div>
</div>
    
<!--<div class="form-group">-->
<div class="row" style="justify-content:spread-evenly;">
<div class="col-12">
<label class="col-12 control-label" for="font">Colors</label>  
</div>
<!--  <div class="col-md-2">-->
<div class="col-4" style="padding-left: 30px;">
  <div class="checkbox">
      <input type="color" name="font-color" id="font-color" value=<?php echo '"'. $fontcolor . '"' ?>>
    </div>
     Portrait Font
  </div>
<!--    </div>-->
<!--</div>-->
<!--<div class="form-group">-->
<div class="col-4">
<!--  <div class="col-md-2">-->
  <div class="checkbox">
      <input type="color" name="primary-color" id="primary-color" value=<?php echo '"'. $primarycolor . '"' ?>>
    </div>
     Primary Colour
<!--  </div>-->
</div>
<div class="col-4">
<!--  <div class="col-md-2">-->
  <div class="checkbox">
      <input type="color" name="secondary-color" id="secondary-color" value=<?php echo '"'. $secondarycolor . '"' ?>>
    </div>
     Secondary Colour
<!--  </div>-->
</div>    

</div>


<!--</div>-->
<!-- Button -->
<div class="form-group">
  <div class="col-md-12">
    <button id="createretainer" name="id" class="btn form-button" style="width:100%;margin-left: 8px;" value= <?php
            echo "$retainer_id"; ?>
            
            >Edit Retainer</button>
  </div>
</div>

  
    
</fieldset>
</form>      
        
        <?php
            
                    }
         else: {
             
             echo "Invalid Retainer ID provided, please try again.";
         }
        endif;
?>
        </div>
        <div class="col-md-4 col-xs-12" style="padding-top: 10px;">
        <?php include "retainercardgenerator.php"; ?>
        </div>
    </div>
</div>

<div class="col-sm-12 col-md-12 col-lg-12">
<label href="#Custom-Attack" class="form-button" data-toggle="collapse" data-target="#Sig-Attack-2" style="width:100%;padding-top:0.5rem; margin-left: 0;"> + Add Custom Action</label>
</div>
<div id="Sig-Attack-2" class="col-sm-12 col-md-12 col-lg-12 collapse">

<label class="control-label">Create Custom Action</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
    <input type="hidden" name="cust-act-id" value<?php echo '="'.$sig1row['Retainer-Action-ID'].'"';?>>
    <input type="hidden" name="cust-act-bool" value<?php echo '="'.$sig1row['Is-Signature-Attack'].'"';?>>
    <input id="retainer-action-name" name="cust-act-name" type="text" placeholder="Name" class="form-control input-md" required="" value<?php echo '="'.$sig1row['Retainer-Action-Name'].'"';?>>
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 <?php
        $string = $sig1row["Retainer-Action-Text"];
        $string = str_replace(array("\n", "\r"), '', $string);
        $string = stripslashes($string);
    ?>
    
    
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="cust-act-text" name="cust-act-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."><?php echo $string ?></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="cust-act-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" required="" value<?php echo '="'.$sig1row['Retainer-Action-Type'].'"';?>>
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
    <label class="control-label" for="retainer-action-duration">Is this a Signature Attack or Special Action?</label> 
<div class="col-8">
      <div class="custom-control custom-radio custom-control-inline">
        <input name="cust-act-bool" id="cust-act-bool_0" type="radio" class="custom-control-input" value="1"> 
        <label for="cust-act-bool_0" class="custom-control-label">Signature Attack</label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input name="cust-act-bool" id="cust-act-bool_1" type="radio" class="custom-control-input" value="0"> 
        <label for="cust-act-bool_1" class="custom-control-label">Action</label>
    </div>
</div>
    <br>
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="cust-act-duration" type="text" placeholder="Action" class="form-control input-md" required="" value<?php echo '="'.$sig1row['Retainer-Action-Duration'].'"';?>>
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-0" value="0" checked="checked" />
      At Will
    </label>
      
<?php 
    
    if ($sig1row['Retainer-Action-Uses'] == 1) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-1" value="1" checked="checked">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-2" value="3" >
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-3" value="5">
      5
    </label>        
<?php    }
    elseif ($sig1row['Retainer-Action-Uses'] == 2) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-2" value="3" checked="checked">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-3" value="5">
      5
    </label>      
<?php    }
    elseif ($sig1row['Retainer-Action-Uses'] == 3) { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-3" value="5">
      5
    </label>      
    
<?php    } else { ?>
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="cust-act-uses" id="sig1-action-uses-3" value="5">
      5
    </label>      
      
<?php    } ?>      
      
      
    

  </div>
<!--</div>-->
</div>

</div> 
    </body>
<script>
var PrimaryInput = document.getElementById("primary-color");
var PrimaryColor = document.getElementById("primary-color").Value;

PrimaryInput.addEventListener("input", function() {
    document.getElementById("primary_border_color").style.borderColor = document.getElementById("primaryselector").Value;                      
                              }, false);
    
//$('#primary-color').click(function(){
//    popup('/map/', 300, 300, 'map'); 
//    return false;
//});
    
</script>    

    
</html>