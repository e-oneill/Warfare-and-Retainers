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
    <title>DM Tools - My Retainers</title>
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
<script src="https://kit.fontawesome.com/8252548e94.js" crossorigin="anonymous"></script>
    

<!--<link href="dmtools.css" rel="stylesheet" type="text/css">-->
    
    </head>
<body>
<?php include "page-header.php"; ?>
    
<!-- Modal -->

<div class="container-flex" style="padding-left: 10px;">
<div class="row">
<div class="col-12">
<h1>Retainer Types</h1>
</div>
</div>
<div class="row">
<div class="col-12">
<?php
$changes = array();
    
        include "changes.php";
        include "db_connect.php";
        if (!empty($_SESSION['user_id'])) { ?>
<!-- href="myretainers.php?add_retainer=yes"   -->
<a href="create_retainer_type.php" class="btn btn-primary btn-xs col-12"><b>+</b> Create New Retainer Type</a>
</div>
</div>
<div class="row">
    <div class="col-12">
<?php        
        $userid = $_SESSION['user_id'];
        $sql = "SELECT * FROM `retainer` WHERE `Creator_user` LIKE 1 OR `Creator_user` LIKE '.$userid.' ORDER BY `RetainerBaseClass`, `RetainerName`";
        $result = $mysqli->query($sql);
        $character = "";
        
        
        if ($result->num_rows > 0) { 
    

        
        $pdo = new PDO('mysql:host=localhost;dbname=dnd','monkehh','177300Milan!');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $q = $pdo->query('SELECT * FROM `classes`');
    
        $classes = $q->fetchAll();        

?>

<!--
</div>    
</div>
<div class="row">
-->
<div class="col-12 user-control-part" style="max-height: 60px;">
<div class="row">
<input type="text" class="col-4 col-md-3 col-lg-2 form-control input-md" id="typesearch" onkeyup='tablesearch("typesearch",0)' placeholder="Search: retainer" style="margin-left: 20px;padding-left: 10px;">
<select id="classesfilter" name="classes" class="col-4 col-md-3 col-lg-2 form-control" onchange='filterText(1)'>
            <option value="all">All</option>
        <?php
        foreach ($classes as $classrow) {
            $class = $classrow['name'];
            echo "<option>".$class."</option>";
        }
    
    ?>
    </select>
</div>
</div>
<div id="retainers-table" class="">

            
    <table id="retainertypestable" class="table table-hover col-12">
    <thead>
        <th class="sortableheader" onclick="sortTable(0)" clickable width="160px">Retainer<i id="caret0" class="fas fa-caret-square-down" style="padding-left:10px;"></i></th>
        <th class="sortableheader"  clickable width="140px">Class<i id="caret1" class="fas fa-caret-square-down" style="padding-left:10px;" onclick="sortTable(1)" clickable></i></th>
        <th class="sortableheader"  clickable >Source<i id="caret1" class="fas fa-caret-square-down" style="padding-left:10px;" onclick="sortTable(1)" clickable></i></th>
    </thead>
           
    <?php
            // output data of each row
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
            $sourceid = $row['Source'];
            
            if (!empty($sourceid)) {
            $sql = "SELECT * FROM `Sources` WHERE `id` LIKE $sourceid";
            $result2 = $mysqli->query($sql);
            if ($sourceid == 3) {
                $sourcename = "Strongholds & Followers";
            }
        }
            
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $save1";
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $save1 = $row2['AbilityScoName'];
            if (!empty($save2)) {
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $save2";
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $save2 = $row2['AbilityScoName'];    
            }
            
            if (!empty($secondaryabi)) {
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $primaryabi OR `AbiID` LIKE $secondaryabi";
            $abilities = $mysqli->query($sql);

//            echo "<pre>";
////            print_r($abilities);
//            echo "</pre>";      
            }
            else {
            $sql = "SELECT `AbilityScoName` FROM `abilityscores` WHERE `AbiID` LIKE $primaryabi";
            $abilities = $mysqli->query($sql);
            }
             
            $sql = "SELECT `skills`.`Skill Name` FROM `retainer-skills` INNER JOIN `skills` ON `retainer-skills`.`Skill` = `skills`.`Skill ID` WHERE `Retainer-Type` LIKE $id";
            $result2 = $mysqli->query($sql);
            $skills = $result2->fetch_all();
            
//            echo "<pre>";
//            print_r($skills);
//            echo "</pre>";
                
//            echo "<pre>";
//            print_r($row);
//            echo "</pre>";
//            $retainer_id = $row['User-Retainer-ID'];
//            $assoc_character = $row['Assoc-Character'];
            
            $sql = "SELECT * FROM `classes` WHERE `id` LIKE $baseclass";
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $baseclass = $row2['name'];
                
            $sql = "SELECT * FROM `retainer-armor-types` WHERE `Retainer-Armor-ID` LIKE $armor_id" ;
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $armorname = $row2['Retainer-Armor-Name'];
            $armorclass  = $row2['Retainer-Armor-Class'];
               
//            $sql = "Select * FROM `retainer` WHERE `RetainerID` LIKE $typeid";
//            $result1 = $mysqli->query($sql);
//            $row1 = $result1->fetch_assoc();
//            $type = $row1['RetainerName']; 
                
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
                    

        ?>
    
    <tr data-toggle="collapse" class="content" data-target=<?php echo '"#accordion-'.$id.'"';?> class="clickable">
            <td><?php echo $retainername; ?></td>
             <td><?php echo $baseclass; ?></td>
        <td>
            
            <?php echo $sourcename; ?>
        
        </td>
    </tr> 
    <tr class="content collapserow" style="padding: 0rem;">
            <td colspan="3" style="padding: 0rem;">
                <div id=<?php echo '"accordion-'.$id.'"';?> class="retainertyperow collapse" style="padding: 0.5rem;">
                    <div class="row">
                    <div class="col-12 col-md-10">
                    <strong>Armor:</strong> <?php echo $armorname . " (AC " . $armorclass .")"; ?> <br>
                    <strong>Primary Ability:</strong> 
                        <?php
                            $ability_counter = 0;
                            while($abilityrow = $abilities->fetch_assoc()) {
                            $ability = $abilityrow['AbilityScoName'];
                            
                            if ($ability_counter < 1) {
                            echo $ability;
                            $ability_counter = $ability_counter + 1;
                            } else {
                            echo ", " . $ability;    
                            }
                            }
                        ?>
                        <br>
                        <strong>Saves:</strong> 
                        <?php
                            echo $save1;
                            if (!empty($save2)){
                                echo ", ".$save2;
                            }
                        ?>
                        <br>
                        <strong>Skills:</strong>
                        <?php
                            $skill_counter = 0;
                            foreach ($skills as $key => $value){
                                if ($skill_counter < 1) {
                                echo $value[0];
                                $skill_counter++;
                                } else {
                                
                                echo ", ".$value[0];
                                }
                            } ?>
                        <br>
                        <strong class="spec-act-header">Special Actions</strong><br>
                        <b>Signature Attacks:</b><br>
                        <?php 
                        $row = $sig1row;
                        
                        echo
                        '<a style="font-weight: 550;">'.$row['Retainer-Action-Name'].'.</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Type']."</a>
                        <p>".$row['Retainer-Action-Text']."</p>";
                        
                        if (!empty($sig2)){
                        $row = $sig2row;
                        echo '<a style="font-weight: 550;">'.$row['Retainer-Action-Name'].'.</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Type']."</a>
                        <p>".$row['Retainer-Action-Text']."</p>";
                            
                            
                        }
                        //SPECIAL ACTIONS 
                        
                        
                        $row = $spec1row;
                        if ($row['Retainer-Action-Uses']=1){
                            $uses = 1;
                        } elseif ($row['Retainer-Action-Uses']=2) {
                            $uses = 3;
                        } elseif ($row['Retainer-Action-Uses']=3) {
                            $uses = 5;
                        } elseif ($row['Retainer-Action-Uses']=4) {
                            $uses = 7;
                        }
                
                        if (!empty($row['Retainer-Action-Duration']) and ($row['Retainer-Action-Duration'] !== "Action")){
                        $string = '<a style="font-weight: 550;">3rd Level ('.$uses.'/day, '.$row['Retainer-Action-Duration'].'):</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Name'].".</a>
                        <p>".$row['Retainer-Action-Text']."</p>";
                        } else {
                        $string = '<a style="font-weight: 550;">3rd Level ('.$uses.'/day):</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Name'].".</a>
                        <p>".$row['Retainer-Action-Text']."</p>"; 
                        }
                
                        $string = str_replace(array("\n", "\r"), " ", $string);
                        $string = stripslashes($string);
                         
                        echo $string;
                        
                        $row = $spec2row;
                        if ($row['Retainer-Action-Uses']=1){
                            $uses = 1;
                        } elseif ($row['Retainer-Action-Uses']=2) {
                            $uses = 3;
                        } elseif ($row['Retainer-Action-Uses']=3) {
                            $uses = 5;
                        } elseif ($row['Retainer-Action-Uses']=4) {
                            $uses = 7;
                        }
                         
                        if (!empty($row['Retainer-Action-Duration']) and ($row['Retainer-Action-Duration'] !== "Action")){
                        $string = '<a style="font-weight: 550;">3rd Level ('.$uses.'/day, '.$row['Retainer-Action-Duration'].'):</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Name'].".</a>
                        <p>".$row['Retainer-Action-Text']."</p>";
                        } else {
                        $string = '<a style="font-weight: 550;">3rd Level ('.$uses.'/day):</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Name'].".</a>
                        <p>".$row['Retainer-Action-Text']."</p>"; 
                        }
                
                        $string = str_replace(array("\n", "\r"), " ", $string);
                        $string = stripslashes($string);
                         
                        echo $string;
                        
                        $row = $spec3row;
                        if ($row['Retainer-Action-Uses']=1){
                            $uses = 1;
                        } elseif ($row['Retainer-Action-Uses']=2) {
                            $uses = 3;
                        } elseif ($row['Retainer-Action-Uses']=3) {
                            $uses = 5;
                        } elseif ($row['Retainer-Action-Uses']=4) {
                            $uses = 7;
                        }
                         
                        if (!empty($row['Retainer-Action-Duration']) and ($row['Retainer-Action-Duration'] !== "Action")){
                        $string = '<a style="font-weight: 550;">3rd Level ('.$uses.'/day, '.$row['Retainer-Action-Duration'].'):</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Name'].".</a>
                        <p>".$row['Retainer-Action-Text']."</p>";
                        } else {
                        $string = '<a style="font-weight: 550;">3rd Level ('.$uses.'/day):</a> 
                        <a style="font-style: italic;">'.$row['Retainer-Action-Name'].".</a>
                        <p>".$row['Retainer-Action-Text']."</p>"; 
                        }
                
                        $string = str_replace(array('\n', '\r', '\r\n\r\n'), ' ', $string);
                        $string = str_replace('\r\n\r\n', '<br><br>', $string);
                        $string = stripslashes($string);
                        
                         
                        echo $string;
               ?>         
                <a class="btn btn-info btn-xs cstbtn-retainer-table"
                <?php echo 'href="edit_retainer_type.php?id='.$id.'"';
                ?>
                    
                   
                    
                    ><span class="glyphicon glyphicon-remove "></span>Edit</a> 
                
                 <?php       
                        ?>
<!--
                        <pre>
                        <?php
                        echo print_r($spec1row); ?>
                        </pre>    
-->
                        
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                                        </div>
                </div>
                
            </td>
    </tr>

    <?php
    } 
        ?>

    </table>
</div>

    <?php
        }
         }
        else {

    
    echo "<h5>You must be logged in to view your saved retainers.</h5>";
    }
        
   
?>

        <p> 
            
        </p> 

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this retainer type? \n This cannot be undone!')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
    // JavaScript Program to illustrate 
    // Table sort on a button click 
    
function sortTable(sortBy) { 
var table, i, x, y; 
table = document.getElementById("retainertypestable"); 
var switching = true; 

// Run loop until no switching is needed 
while (switching) { 
    switching = false; 
    var rows = table.rows; 

    // Loop to go through all rows 
    for (i = 1; i < (rows.length - 2); i+=2) { 
        var Switch = false; 

        // Fetch 2 elements that need to be compared 
        x = rows[i].getElementsByTagName("TD")[sortBy]; 
        y = rows[i + 2].getElementsByTagName("TD")[sortBy]; 

        // Check if 2 rows need to be switched 
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) 
            { 

            // If yes, mark Switch as needed and break loop 
            Switch = true; 
            break; 
        } 
    } 
    if (Switch) { 
        // Function to switch rows and mark switch as completed 

        rows[i].parentNode.insertBefore(rows[i + 2], rows[i]); 
        rows[i].parentNode.insertBefore(rows[i + 3], rows[i+1]); 
        switching = true; 
    } 
    } 
} 

function tablesearch(inputfield, searchfield) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById(inputfield);
  filter = input.value.toUpperCase();
  table = document.getElementById("retainertypestable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 1; i < (tr.length-1); i+=2) {
    td = tr[i].getElementsByTagName("td")[searchfield];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        if (tr[i].classList.contains("DropdownFiltered")){
        tr[i].classList.remove("SearchFiltered");
        } else {
        tr[i].style.display = "";
        tr[i].classList.remove("SearchFiltered");
        tr[i+1].style.display = "";
        }
      } else {
        tr[i].style.display = "none";
        tr[i].classList.add("SearchFiltered");
        tr[i+1].style.display = "none";
      }
    }
  }
}

function filterText(searchfield)
	{  
//        alert(contentPanelId);
        var table = table = document.getElementById("retainertypestable");
        var tr = table.getElementsByTagName("tr");
        var rex = new RegExp($('#classesfilter').val());
		if(rex =="/all/"){clearFilter()}else{
            for (i = 1; i < (tr.length-1); i+=2) {
        var td = tr[i].getElementsByTagName("td")[searchfield];
        if (td){
            txtValue = td.textContent || td.innerText;
            if (rex.test(txtValue)) {
            if (tr[i].classList.contains("SearchFiltered")){
            } else {
                tr[i].style.display = "";
                tr[i].classList.remove("DropdownFiltered");
                tr[i+1].style.display = "";
            }
            }
            else {
                tr[i].style.display = "none";
                tr[i].classList.add("DropdownFiltered");
                tr[i+1].style.display = "none"; 
                    }
                }
            } 
        }
	}
	
function clearFilter()
	{
		$('.classesfilter').val('');
		$('.content').show();
	}
    
    
    
    
</script>    
    
   
    
    </div>
    </div>
    </div>

    </body>
</html>