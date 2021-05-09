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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
// clearly using jQuery here ;) 
$(document).ready(function() {

  $("select[name='classes']").change(function() {

    $("select[name='type'] :selected").removeAttr("selected");

    // using text value to match second select option groups could just as easily be based on value then label text
    var arr = $("select[name='classes'] :selected").text();

    if (arr !== 'All') { // arbitrary value to show all 
      $("select[name='type']").children("optgroup").hide();
      $("select[name='type']").children("optgroup[label='" + arr + "']").show();
    } else {
      $("select[name='type']").children("optgroup").show();
    }
    
  });

});    


// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2({
        width: 'resolve'
    });
});    
</script>    
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
    
//var PrimaryInput = document.getElementById("primaryselector");
//var PrimaryColor = document.getElementById("primaryselector").Value;
//
//PrimaryInput.addEventListener("input", function() {
//    document.getElementById("primary_border_color").style.borderColor = document.getElementById("primaryselector").Value;                      
//                              }, false);
//    
//$('#primary-color').click(function(){
//    popup('/map/', 300, 300, 'map'); 
//    return false;
//});
    
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
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a>My Retainers</a></li>
  </ol>
</nav>
 <?php 
          

if (!empty($_SESSION['username'])) {

     include "db_connect.php";
        
//        $stmt = $mysqli->prepare("SELECT RetainerName, RetainerBaseClass FROM retainer");
//        
//        $stmt->execute();
//        $retainers = [];
        $userid = $_SESSION['user_id'];
    
    
        $pdo = new PDO('mysql:host=localhost;dbname=dnd','monkehh','177300Milan!');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $q = $pdo->query('SELECT `classes`.`name`,`retainer`.`RetainerName`, `retainer`.`RetainerBaseClass`, `retainer`.`RetainerID` FROM `retainer` INNER JOIN `classes` ON `retainer`.`RetainerBaseClass` = `classes`.`id` WHERE `retainer`.`Creator_user` LIKE 1 OR `retainer`.`Creator_user` LIKE ' . $userid . ' ORDER BY `classes`.`name`');
    
        $retainers = $q->fetchAll();
    
        
    
//        foreach ($stmt->get_result() as $row) {
//            $retainers[] = $row['RetainerBaseClass'];
//            $retainers[] = $row['RetainerName'];
//        }
        
        $userid = $_SESSION['user_id'];    
        $stmt = $mysqli->prepare("SELECT `Character Name` FROM `characters` WHERE `User` LIKE $userid");
        $stmt->execute();
        $characters = [];
            
        foreach ($stmt->get_result() as $row1) {
            $characters[] = $row1['Character Name'];
        }  
            ?>
<div class=container-flex style="padding-left:1em;">

        
<form method="post" action="/add_retainer.php" enctype="multipart/form-data">
<fieldset>
<div class="row">
<div class="col-md-6 col-lg-4">
<div class="form-part">
<!-- Form Name -->
<legend class="form-legend">Basics</legend>
<hr>

<!-- Text input-->
<div class="form-group">
  <label class="control-label" for="name">Character</label>  
  <div class="">
  <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="control-label" for="level">Level</label>
  <div class="">
    <select id="level" name="level" class="form-control" value="1">
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

<!-- Select Basic -->



<!-- File Button --> 
<div class="form-group">


<div id="wrapper" class="col">
<img id="output_image" style="width:100%;"/>
  <label class="form-button" id="image-button" for="image" style="width:100%; padding-top:0.5rem; margin-left: 0;" onclick="preview_image(event)"> + Character Image</label>
 <input id="image" type="file" accept="image/*" name="image" onchange="preview_image(event)">
 
</div>
</div>
<div class="form-group">
  <label class="control-label" for="type">Type</label>
  <div>
    <select id="type" name="type" class="form-control" style="width:100%;">
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
      <?php print_r($optgroups); ?>
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
    
    <script>
// clearly using jQuery here ;) 
$(document).ready(function() {

  $("select[name='firstSelect']").change(function() {

    $("select[name='secondSelect'] :selected").removeAttr("selected");

    // using text value to match second select option groups could just as easily be based on value then label text
    var arr = $("select[name='firstSelect'] :selected").text();

    if (arr !== 'All') { // arbitrary value to show all 
      $("select[name='secondSelect']").children("optgroup").hide();
      $("select[name='secondSelect']").children("optgroup[label='" + arr + "']").show();
    } else {
      $("select[name='secondSelect']").children("optgroup").show();
    }
    
  });

});
        </script>
    
<div class="form-group">
  <label class="control-label" for="assoc-character">Retainer to</label>
  <div class="">
<select name="assoc-character" id="array" class="form-control">
    <option></option>
    <?php
    
          
        sort($retainers, SORT_STRING);
        foreach ($characters as $value)  {
            echo '<option>'.$value.'</option>';
            
        }
    
            
    
    ?>      
    </select>
    <a style="font-style: italic;">Who does this retainer serve?</a>
  </div>
</div>
</div>
</div>

<div class="col-md-6 col-lg-4">    
<div class="form-part">

<!-- Form Name -->
<legend class="form-legend">Colors</legend>
<hr>
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
  <div class="col-md-12">
    <button id="createretainer" name="createretainer" class="btn form-button" style="width:100%;margin-left: 8px;">Add Retainer</button> 
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