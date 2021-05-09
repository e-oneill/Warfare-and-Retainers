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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
<script>
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
    
<!-- Modal -->

<div class="container-flex">
<div class="row">
<div class="col-12">
<h1>My Retainers</h1>
</div>
</div>
<div class="row">
<div class="col-12" style="margin:1rem;">
    <?php
$changes = array();
    
        include "changes.php";
        include "db_connect.php";
        if (!empty($_SESSION['user_id'])) { ?>
<!-- href="myretainers.php?add_retainer=yes"   -->
<a href="create_retainer.php" class="btn btn-primary btn-xs col-12 col-md-6" style="margin:1rem;"><b>+</b> Add new retainer</a>

<?php        
        $userid = $_SESSION['user_id'];
        $sql = "SELECT * FROM `user-retainers` WHERE `User` LIKE $userid";
        $result = $mysqli->query($sql);
        $character = "";
        
        
        if ($result->num_rows > 0) { 
    
?>
<!--
</div>    
</div>
<div class="row">
-->
<div id="retainers-table" >

<!--table table-striped custab col-lg-10 col-md-11 col-xs-12-->
            
    <table id="myretainertable" class="display">
    <thead>

        <tr>
            <th style="width: 10%;">Name</th>
            <th style="width: 10%;">Type</th>
            <th style="width: 10%;">PC</th>
            <th style="width: 20%;"></th>
        </tr>
            </thead>
           
    <?php
            // output data of each row
            while($row = $result->fetch_assoc()) {
        
                
            $retainername = $row['Retainer-Name'];    
            $typeid = $row['Retainer-Type'];
            $retainer_id = $row['User-Retainer-ID'];
            if (!empty($row['Assoc-Character'])){ 
            $assoc_character = $row['Assoc-Character'];
            
            
            $sql = "SELECT * FROM `characters` WHERE `character_id` LIKE $assoc_character";
            $result2 = $mysqli->query($sql);
            $row2 = $result2->fetch_assoc();
            $assoc_character = $row2['Character Name'];} else {
            $assoc_character = "Unassigned";    
            }
               
            $sql = "Select * FROM `retainer` WHERE `RetainerID` LIKE $typeid";
            $result1 = $mysqli->query($sql);
            $row1 = $result1->fetch_assoc();
            $type = $row1['RetainerName']; ?>
    
    <tr>
                <td><?php echo $retainername; ?></td>
                <td><?php echo $type; ?></td>
                <td><?php echo $assoc_character; ?></td>
                <td class="text-center">
                <a class="btn btn-success btn-xs cstbtn-retainer-table"
                    <?php 
                
                echo 'href="retainer.php?id='.$retainer_id.'"'; 
                    
                    
                    ?>                                         
                                           
                                           ><span class="glyphicon glyphicon-edit"></span>View</a> 
                    
                    <a class="btn btn-info btn-xs cstbtn-retainer-table"
                <?php echo 'href="edit_retainer_form.php?id='.$retainer_id.'"';
                ?>
                    
                   
                    
                    ><span class="glyphicon glyphicon-remove "></span>Edit</a>  
        <a class="confirmation btn btn-danger btn-xs cstbtn-retainer-table" href="delete.php?id=<?php echo $retainer_id . '"'; ?>><span class="glyphicon glyphicon-remove"></span>Delete</a>
        </td>
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
         ?>

    
 

    
        
        <?php 
        if (isset($_GET["id"]) And !isset($_GET['edit_retainer'])) : {
            
        ?>
        <div class="col-md-4 col-xs-12" style="padding-top: 10px;">
            <?php
            $id = $_GET["id"];
            
            ?>
            
            
            <?php
            
            $popoutlink = "";
            echo $popoutlink;
            include "retainercardgenerator.php";
        
        ?>
    <script>
    function createpopout {
    var cardheight = $("#retainer-front").height();
        
    newwindow = window.open(`'retainer_pop_out.php?id=41', 'mywindow', 'width=460', 'height=${cardheight}'`);
        
    return newwindow;
    }
    </script>
  <button class="btn btn-primary btn-xs pull-right" onclick="window.open(createpopout())" >Popout</button>              
        </div>
        <?php
            }
        endif;
        if (isset($_GET['add_retainer'])): {
            ?>

    <div class="col-md-4 col-xs-12" style="padding-top: 10px;">        
    <?php
        
           include "retainer_creation_form.php";
     ?>
    </div>
    <?php
            }

?>
 



        <?php
        
        
    
        endif;
            ?>
        
    <?php
         }
        else {

    
    echo "<h5>You must be logged in to view your saved retainers.</h5>";
    }
        
   
?>
<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this retainer? \n This cannot be undone!')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
    
$(document).ready(function() {
    $('#myretainertable').DataTable();
} );
</script>    
    
   
    
    </div>
    </div>
    </div>

    </body>
</html>