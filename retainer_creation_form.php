<form method="post" action="/add_retainer.php" class="form-horizontal" enctype="multipart/form-data">
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
<legend>Add New Retainer</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-5 control-label" for="name">Retainer Name</label>  
  <div class="col-md-6">
  <input id="name" name="name" type="text" placeholder="e.g. Phandalin Man" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="type">Retainer Type</label>
  <div class="col-md-5">
<select name="type" id="array" class="form-control">
    <?php
    
          
        sort($retainers, SORT_STRING);
        foreach ($retainers as $value)  {
            printf('<option>%s</option>option>',$value);
            
        }
    
    ?>      
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="level">Level</label>
  <div class="col-md-3">
    <select id="level" name="level" class="form-control">
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
<div class="form-group">
  <label class="col-md-4 control-label" for="assoc-character">Character</label>
  <div class="col-md-6">
<select name="assoc-character" id="array" class="form-control">
    <?php
    
          
        sort($retainers, SORT_STRING);
        foreach ($characters as $value)  {
            printf('<option>%s</option>option>',$value);
            
        }
            
    
    ?>      
    </select>
    <a style="font-style: italic;">Who does this retainer serve?</a>
  </div>
</div>
<div class="form-group">
<label class="col-md-4 control-label" for="image">Portrait</label>
<div class="col-md-6">
<input type="hidden" name="size" value="1000000">
<div>  
  <input type="file" id="image" name="image" class="input-file">
</div>    
</div>
</div>
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="createretainer"></label>
  <div class="col-md-4">
    <button id="createretainer" name="createretainer" class="btn btn-primary">Add Retainer</button> 
      
      <br>
  </div>
</div>

</fieldset>
</form>

