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

<link href="dmtools.css" rel="stylesheet" type="text/css">
    
    </head>
<body>
<?php include "page-header.php"; ?> 
<div class="container-flex" style="padding-left: 1rem;">
<div class="row">
<div class="col-md-12">
<h1>My Characters</h1>
</div>
</div>
<div class="row">
<div class="col-md-12">
<?php
$changes = array();
    
        include "changes.php";
        include "db_connect.php";
        if (!empty($_SESSION['user_id'])) { ?>
    

<?php        
        $userid = $_SESSION['user_id'];
        $sql = "SELECT * FROM `characters` WHERE `User` LIKE $userid";
        $result = $mysqli->query($sql);
        $character = "";
        
        
        if ($result->num_rows > 0) { 
    
?>
</div>    
</div>
<div class="row">
<div id="characters-table" class="col-md-6 col-xs-12">


            
    <table class="table table-striped custab">
    <thead>

        <tr>
            <th style="width: 25%;">Name</th>
            <th style="width: 10%;">Level</th>
            <th style="width: 15%">Race</th>
            <th style="width: 25%">Class/Subclass</th>
            <th style="width: 20%;">Campaign</th>
<!--            <th class="width:40%;">Action</th>-->
        </tr>
            </thead>
           
    <?php
            // output data of each row
            while($row = $result->fetch_assoc()) {
            unset($charactersubclass);
                
            $charactername = $row['Character Name']; 
            $characterrace = $row['Character Race'];
            $characterclass = $row['Character Class'];
            $characterid = $row['character_id'];
            $campaign = $row['campaign'];
            $level = $row['Character Level'];
            $charactersubrace = $row['Character Subrace'];
            $charactersubclass = $row['Character Subclass'];
            $sql = "SELECT `name` FROM `classes` WHERE `id`LIKE $characterclass";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $classname = $row1['name'];
                
            $sql = "SELECT `name` FROM `races` WHERE `race-id`LIKE $characterrace";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $racename = $row1['name'];
            
            $sql = "SELECT `campaign_name` FROM `campaigns` WHERE `campaign_id`LIKE $campaign";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $campaignname = $row1['campaign_name'];
            
            if (!empty($charactersubrace)): {
            $sql = "SELECT `name` FROM `subraces` WHERE `id`LIKE $charactersubrace";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $racename = $row1['name'];
            unset($charactersubrace);
            } endif;
            
            if (!empty($charactersubclass)): {
            $sql = "SELECT `name` FROM `subclasses` WHERE `id`LIKE $charactersubclass";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $subclassname = $row1['name'];
            unset($charactersubclass);
            } endif;
        
        ?>
    
    <tr>
                <td> <a 
                                   <?php echo 'href=character.php?id='.$characterid;
                ?> 
                        ?>
                    <?php echo $charactername; ?>
        
                    </a>
        </td>
                <td><?php echo $level;?></td>
                <td><?php echo $racename; ?></td>
                <td>
                    
                    <?php echo $classname; 
                if (!empty($subclassname)) :{
                    echo "/" . $subclassname;
                    unset($subclassname);
                }   
                endif;
                    
        ?>
        </td>
                <td><?php echo $campaignname; ?></td>
<!--
                <td class="text-center">
                <a class="btn btn-success btn-xs"><span class="glyphicon glyphicon-edit"></span>View</a> 
                    
                    <a class="btn btn-info btn-xs"><span class="glyphicon glyphicon-remove"></span>Edit</a>
        <a class="btn btn-danger btn-xs" href=""><span class="glyphicon glyphicon-remove"></span>Delete</a>
        </td>
-->
    </tr> 
    
<!--
             echo 
                 '<a href="myretainers.php?id='.$retainer_id.'&name=' .
                 $row['Retainer-Name'] . "&type=" . $type . "&retainerlevel=" . $row['Retainer-Level'] . '">' . $row['Retainer-Name'] . "</a></br>";   
-->
            
    
    <?php
    } 
        ?>

    </table>
</div>
    <?php
        }
        }
    else {
        ?>
    
    <h5>You must be logged in to view your saved retainers.</h5>
    <?php
    }
        
    
?>
    
 

    <div class="col-md-8 col-xs-12" style="padding-top: 10px;">
        
        <?php 
        if (isset($_GET["type"])) : {
            
            include "retainercardgenerator.php";
            }
        elseif (isset($_GET['add_retainer'])): {
           include "retainer_creation_form.php";
            
            }

?>
  


<!--
<div class="col-md-10">
    <div class="container">
        <div class="row">
<div class="col-md-2"></div>
        <div class="npc-top-block">
            <div class="npc-name">
            Test 1
            </div>
            <div class="npc-type">
            Test Type
            </div>
            <div class="npc-level">
            Test Level
            </div>
        </div> 
        </div>
        <div class="row">
        <div class ="npc-ability-block">
        Test
        </div>
        </div>
    </div>
</div>
-->
        
        <?php
        
        
        elseif (isset($_GET['edit_retainer'])): {
//            echo "<h1>Add New Retainer</h1>";
            include "edit_retainer_form.php";
            
        }
        
        endif;
            ?>
    
    
   </div>
    </div>
    </div>
    </body>
    
</html>