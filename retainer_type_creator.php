<form method="post" action="/add_retainer_type.php" class="form-horizontal" enctype="multipart/form-data">
<fieldset>
<?php 
            include "db_connect.php";
            
    
        $stmt = $mysqli->prepare("SELECT RetainerName FROM retainer");
        $stmt->execute();
        $retainers = [];
        $userid = $_SESSION['user_id'];
    
        foreach ($stmt->get_result() as $row) {
            $retainers[] = $row['RetainerName'];
        }

            

        $stmt = $mysqli->prepare("SELECT `Character Name` FROM `characters` WHERE `User` LIKE $userid");
        $stmt->execute();
        $characters = [];
            
        foreach ($stmt->get_result() as $row1) {
            $characters[] = $row1['Character Name'];
        }       
            
    ?>
<!-- Form Name -->
<legend>Retainer</legend>

<!-- Text input-->
<!-- Form Name -->
<legend>The Basics</legend>
<div class="form-part">
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="retainername">Name</label>  
  <div class="col-md-4">
  <input id="retainername" name="retainername" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="RetainerBaseClass">Class</label>
  <div class="col-md-4">
    <select id="RetainerBaseClass" name="RetainerBaseClass" class="form-control">
      <option value="1">Option one</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="armor-type">Armor</label>
  <div class="col-md-4">
    <select id="armor-type" name="armor-type" class="form-control">
      <option value="1">Light</option>
      <option value="2">Medium</option>
      <option value="3">Heavy</option>
    </select>
  </div>
</div>

    </div>d
</fieldset>
</form>

