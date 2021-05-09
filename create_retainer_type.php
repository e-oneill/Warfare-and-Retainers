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
        
//        $stmt = $mysqli->prepare("SELECT `id`, `name` FROM classes");
//        $stmt->execute();
//        $classes = [];
//        $classids = [];
//        $userid = $_SESSION['user_id'];
//    
//        foreach ($stmt->get_result() as $row) {
//            $classes[] = $row['name'];
//            $classids[] = $row['id'];
//        }
        
  
            ?>
<div style="padding:2rem;">   


<form method="post" action="/add_retainer_type.php" enctype="multipart/form-data">

<fieldset>
<div class="row">
<div class="col-md-12 col-lg-6 cust-form-col">
<div class="user-control-part">
<legend class="form-legend">Basics</legend>
<hr>    
 <div class="form-group">
  <label class="col-md-12 control-label" for="retainername">Name</label>  
  <div class="col-md-12">
  <input id="retainername" name="retainername" type="text" placeholder="" class="form-control input-md" required="">
    
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
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
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
      <option value="1">Light</option>
      <option value="2">Medium</option>
      <option value="3">Heavy</option>
    </select>
      <a class="help-block">Light: 13 AC | Medium: 15 AC | Heavy: 18 AC</a>
      </div>
    </div> 
</div>
</div>
<div class="col-md-12 col-lg-6 cust-form-col">
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
      <option value="1">Strength</option>
      <option value="2">Dexterity</option>
      <option value="3">Constitution</option>
      <option value="4">Intelligence</option>
      <option value="5">Wisdom</option>
      <option value="6">Charisma</option>
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
      <option value="1">Strength</option>
      <option value="2">Dexterity</option>
      <option value="3">Constitution</option>
      <option value="4">Intelligence</option>
      <option value="5">Wisdom</option>
      <option value="6">Charisma</option>
    </select>
    </div>
    <div class="col-6 form-col" style="margin-top: 1.25rem;">
    <div class="checkbox">
    <strong style="padding-left:0rem;">Saves</strong>
    </div>
    </div>
    <div class="col-5 form-col" >
    <select id='saves' name="saves[]" class="selectpicker" style="width:119%; margin-left: -5%;" multiple>
      <option value="1">Strength</option>
      <option value="2">Dexterity</option>
      <option value="3">Constitution</option>
      <option value="4">Intelligence</option>
      <option value="5">Wisdom</option>
      <option value="6">Charisma</option>
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
        echo '<option value="' . $row['Skill ID'] . '">' . $row['Skill Name'] . '</option>';
    }
          

    
    ?>
    
</select>
  </div>

</div>
</div>
    
<div class="col-md-12 col-lg-12 cust-form-coll">
<div class="user-control-part">
<legend class="form-legend">Actions</legend>
<hr>
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-6">
<label class="control-label">Signature Attack</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
  <input id="retainer-action-name" name="sig-one-name" type="text" placeholder="Name" class="form-control input-md" required="">
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="sig-one-text" name="sig-one-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="sig-one-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" required="">
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="sig-one-duration" type="text" placeholder="Action" class="form-control input-md" required="">
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="sig-one-uses" id="retainer-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig-one-uses" id="retainer-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig-one-uses" id="retainer-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig-one-uses" id="retainer-action-uses-3" value="5">
      5
    </label>
  </div>
<!--</div>-->
</div>
<label href="#Sig-Attack-2" class="form-button" data-toggle="collapse" data-target="#Sig-Attack-2" style="width:100%;padding-top:0.5rem; margin-left: 0;"> + Second Signature Attack</label>
</div>
<div id="Sig-Attack-2" class="col-sm-12 col-md-12 col-lg-6 collapse in">
<label class="control-label">Signature Attack</label>
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
  <input id="retainer-action-name" name="sig-two-name" type="text" placeholder="Name" class="form-control input-md" >
    
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
      <input type="radio" name="sig-two-uses" id="retainer-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="sig-two-uses" id="retainer-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="sig-two-uses" id="retainer-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="sig-two-uses" id="retainer-action-uses-3" value="5">
      5
    </label>
  </div>
<!--</div>-->
</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-6">
<label class="control-label">Level 3 Action</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
  <input id="retainer-action-name" name="spec-act-one-name" type="text" placeholder="Name" class="form-control input-md" required="">
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="spec-act-one-text" name="spec-act-one-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="spec-act-one-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md" >
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="spec-act-one-duration" type="text" placeholder="Action" class="form-control input-md" required="">
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="spec-act-two-uses" id="retainer-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec-act-one-uses" id="retainer-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec-act-one-uses" id="retainer-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec-act-one-uses" id="retainer-action-uses-3" value="5">
      5
    </label>
  </div>
<!--</div>-->
</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-6">
<label class="control-label">Level 5 Action</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
  <input id="retainer-action-name" name="spec-act-two-name" type="text" placeholder="Name" class="form-control input-md" required="">
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="spec-act-one-text" name="spec-act-two-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="spec-act-two-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md">
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="spec-act-two-duration" type="text" placeholder="Action" class="form-control input-md" required="">
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="spec-act-two-uses" id="retainer-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec-act-two-uses" id="retainer-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec-act-two-uses" id="retainer-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec-act-two-uses" id="retainer-action-uses-3" value="5">
      5
    </label>
  </div>
<!--</div>-->
</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-6">
<label class="control-label">Level 7 Action</label>  
<div class="form-group">
<div  class="action-text-box"> 
<!--  <div class="col-md-12">-->
  <input id="retainer-action-name" name="spec-act-three-name" type="text" placeholder="Name" class="form-control input-md" required="">
    
<!--  </div>-->
</div> 
<div class="action-text-box">
 
<!--  <div class="col-md-12">                     -->
    <textarea class="form-control" id="spec-act-three-text" name="spec-act-three-text" placeholder="+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage."></textarea>
<!--  </div>-->
</div>
<!--<div class="form-group">-->
  
  <div class="action-text-box">
  <input id="retainer-action-type" name="spec-act-three-type" type="text" placeholder="Melee Weapon Attack" class="form-control input-md">
    
  </div>
<!--</div>-->

<!-- Text input-->
<!--<div class="form-group">-->
<label class="control-label" for="retainer-action-duration">Duration</label>  
<div class="action-text-box">
<input id="retainer-action-duration" name="spec-act-three-duration" type="text" placeholder="Action" class="form-control input-md" required="">
    
</div>
<!--</div>-->

<!-- Multiple Radios (inline) -->
<!--<div class="form-group">-->
  <label class="control-label" for="retainer-action-uses">Uses per day</label>
  <div class="" style="display:flex; justify-content: space-around"> 
    <label class="radio-inline" for="retainer-action-uses-0">
      <input type="radio" name="spec-act-three-uses" id="retainer-action-uses-0" value="null" checked="checked">
      At Will
    </label> 
    <label class="radio-inline" for="retainer-action-uses-1">
      <input type="radio" name="spec-act-three-uses" id="retainer-action-uses-1" value="1">
      1
    </label> 
    <label class="radio-inline" for="retainer-action-uses-2">
      <input type="radio" name="spec-act-three-uses" id="retainer-action-uses-2" value="3">
      3
    </label> 
    <label class="radio-inline" for="retainer-action-uses-3">
      <input type="radio" name="spec-act-three-uses" id="retainer-action-uses-3" value="5">
      5
    </label>
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
    <button id="createretainer" name="createretainer" class="btn form-button" style="width:100%;height:100%;font-size:20px;"><strong>Add Retainer</strong></button> 
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