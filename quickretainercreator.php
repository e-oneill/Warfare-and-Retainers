<?php 
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
<script>
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
</script>
<link href="dmtools.css" rel="stylesheet" type="text/css">
    </head>
<body>
<?php include "page-header.php"; ?>  
    
<div class="col-md-2"></div>
<div class="col-md-10">
    <h1>Retainer Tools</h1>
    

<?php

    include "db_connect.php";
    

?>

    

</div>
    
<?php
        
        
        $pdo = new PDO('mysql:host=localhost;dbname=dnd','monkehh','177300Milan!');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        if (isset($_SESSION['user_id'])) {
            $userid = $_SESSION['user_id'];
            $q = $pdo->query('SELECT `classes`.`name`,`retainer`.`RetainerName`, `retainer`.`RetainerBaseClass`, `retainer`.`RetainerID` FROM `retainer` INNER JOIN `classes` ON `retainer`.`RetainerBaseClass` = `classes`.`id` WHERE `retainer`.`Creator_user` LIKE 1 OR `retainer`.`Creator_user` LIKE '.$userid.' ORDER BY `classes`.`name`');
        }
        else { 
            $userid = NULL; 
            $q = $pdo->query('SELECT `classes`.`name`,`retainer`.`RetainerName`, `retainer`.`RetainerBaseClass`, `retainer`.`RetainerID` FROM `retainer` INNER JOIN `classes` ON `retainer`.`RetainerBaseClass` = `classes`.`id` WHERE `retainer`.`Creator_user` LIKE 1 ORDER BY `classes`.`name`'); 
             }
    
        
    
        $retainers = $q->fetchAll(); 
    ?>
    

<div class="col-md-4">
        <form method="POST" action="/search_keyword_retainer.php" class="form-horizontal" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Quick Retainer Creator</legend>
    
<!-- Text input-->
<div class="form-group">
  <label class="control-label" for="name">Retainer Name</label>  
  <div class="">
  <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Search input-->
<div class="form-group">
  <label class="control-label" for="type">Type</label>
  <div>
    <select id="type" name="keyword" class="form-control" style="width:100%;">
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
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                } 
            }
            elseif (($lastoptiongroup == $optiongroup) and ($key !== $last_key)) {
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                }   
            }
            elseif (($lastoptiongroup !== $optiongroup) and ($key !== $last_key)) {
            echo '</optgroup>';
            echo '<optgroup label=' . $optiongroup . '>';
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                }  
            }
            elseif (($lastoptiongroup == $optiongroup) and ($key == $last_key)) {
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            echo '</optgroup>';
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                } 
            }
            elseif (($lastoptiongroup !== $optiongroup) and ($key == $last_key)) {
            echo '</optgroup>';
            echo '<optgroup label=' . $optiongroup . '>';
            echo '<option value="'.$itemid.'">'.$value.'</option>';
            echo '</optgroup>';
            $lastoptiongroup = $optiongroup;
                 if (in_array($optiongroup, $optgroups) == false) {
                    array_push($optgroups,$optiongroup);
                } 
            }
            
        }
    
    
    ?> 
    </select>
<!--    <a>Select a type of retainer from the dropdown or create a custom one</a> -->
      
<!--
      <pre>
      
      </pre>
-->
      
      
      
    <div style="margin-top:.75rem;">
    <a>Filter Type by class</a>
    <select id="classes" name="classes" class="form-control">
            <option value="0">All</option>
        <?php
        foreach ($optgroups as $class) {
            echo "<option>".$class."</option>";
        }
    
    ?>
    </select>
    </div>
  </div>
</div>
    
<!-- Select Basic -->
<div class="form-group">
  <label class="control-label" for="retainerlevel">Retainer Level</label>
  <div class="">
    <select id="retainerlevel" name="retainerlevel" class="form-control">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
    </select>
  </div>
</div>

<div class="form-group">


<div id="wrapper" class="col">
<img id="output_image" style="width:100%;"/>
  <label class="form-button" id="image-button" for="image" style="width:100%;padding-top:0.5rem; margin-left: 0;" onclick="preview_image(event)"> + Character Image</label>
 <input id="image" type="file" accept="image/*" name="image" onchange="preview_image(event)">
 
</div>
</div>

<div class="row">
<div class="col-xs-12" style="display: flex;white-space: normal;margin-left: 20px;word-wrap: break-word;width: 16%;margin-right: 30px; justify-content: space-between;">
    <div style="padding:1rem;">
      <input type="color" name="font-color" id="font-color" >
     Portrait Font
    </div>
    <div style="padding:1rem;">
<!--    <div class="checkbox">-->
      <input type="color" name="primary-color" id="primaryselector" value="#0080c0">
<!--    </div>-->
     Primary Colour
    </div>
    <div style="padding:1rem;">
      <input type="color" class="jscolor" name="secondary-color" id="secondary-color" value="#005782">
     Secondary Colour
    </div>
</div>  
</div>    
    
    
    
<!-- Button -->
<div class="control-group">
  <label class="control-label" for="Submit"></label>
  <div class="controls">
    <button id="Submit" name="Submit" class="btn btn-info">Create</button>
  </div>
</div>

</fieldset>
</form>
    </div>

<?php
//    include "search_keyword.php";
    
    
$mysqli->close();    
    
    
?>

    </body>
</html>