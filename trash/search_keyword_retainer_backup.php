<!doctype html>
<html>
    
<head>
    
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
    
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 

<link href="dmtools.css" rel="stylesheet" type="text/css">
    </head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">DM Tools</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Retainer Card Creator</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
    
      <input type="checkbox">
  <span class="checkmark"></span>
<hr>
<div class="card-back">
            <div class="container-fluid">

        <?php
        include "db_connect.php";
        $keyword = $_GET["keyword"];

        //Search database for keyword
        //echo "<h2>Lookup $keyword</h2>";
        $sql = "SELECT RetainerID, RetainerName, RetainerBaseClass FROM retainer WHERE RetainerName LIKE '%" . $keyword . "%'";
        $result = $mysqli->query($sql);
        ?>
        <?php    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

        ?>
        <div class="row" style="height:197px;     background-image: url(images/albertkorwin.jpg); border-radius: 9px 9px 0px 0px; background-size: cover;">
            <div class="npc-top-block">
                <div class="npc-name">
                Rolo
                </div>
                <div class="npc-type">
                    <?php
                        echo $row["RetainerName"] . "<br> Level 2 <br> AC15";
                    }
                    } else {
                    echo "0 results";
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="container npc-abilities-container">
        <div class="row npc-abilities-background">
<!--            <div class="npc-abilities-background">-->
                <div class="row" style="padding-left:18px;">
                <div class="npc-ability-mod-cont">
                    <div class="row npc-ability-row">
                    <div class="col-2">
                        +4
                    </div>
                    <div class="col-2">
                        +3
                    </div>
                    <div class="col-8">
                        Disadvantage
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-2">
                        <a>DEX</a>
                    </div>
                    <div class="col-2">
                        <a>WIS</a>
                    </div>
                    <div class="col-8">
                        <a>STR</a>
                    </div>
                    </div>
                </div>
                <div class="npc-skill-cont">
                    <a style="font-family: Montserrat;">Skills</a><br>
                    <a style="font-weight: 500; font-size: 8px;">Acrobatics +6, Stealth +6, Deception +3</a>
                </div>
                </div>
</div>
<!--            </div>-->
        </div>
        <div class="row npc-health-speed-cont">
            <div class="npc-abilities-background">
            <div class="npc-health-speed" style="margin-right: 1px;">
                <a>Health:</a>
            </div>
            <div class="npc-health-speed" style="margin-left: 0px; border-radius: 30px 60px 60px 30px;">
                <input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>
                <input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>
            </div>
            </div>
            <div class="npc-abilities-background">
            <div class="npc-health-speed" style="margin-right: 1px;">
                <a>Speed:</a>
            </div>
            <div class="npc-health-speed" style="margin-left: 0px; border-radius: 30px 60px 60px 30px;">
                <a>30 ft.</a>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a>Signature Attacks</a>
            </div>
        </div>
        <div class="row signature-attack">
            <div class="row">
                <div class="col-9">
                    <a class="signature-attack-header">Shortswords.</a> <a class="action-type">Melee Weapon</a>
                </div>
                <div class="col-3">
                <a class="action-type">Action</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <a class="action-text">+6 to hit, reach 5ft, one target. Hit: 9 (2d6+2) slashing damage.</a>
                </div>
            </div>
        </div>
        <div class="row signature-attack">
            <div class="row" style="height:24px;">
                <div class="col-9">
                <a class="signature-attack-header">Flintlock Pistol.</a> <a class="action-type">Ranged Weapon.</a>
                </div>
                <div class="col-3">
                <a class="action-type">Action</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <a class="action-text">+6 to hit, range 40/80 ft., one target. Hit: 7 (1d8+2) piercing damage, Misfire 8.</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a>Special Actions</a>
            </div>
        </div>
        <div class="row signature-attack">
            <div class="row" style="height:24px;">
                <div class="col-9">
                <a class="signature-attack-header">Low Blow.</a>
                <input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>
                <input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>                
                <input type="checkbox" class="retainer-circle">
                <span class="checkmark"></span>
                </div>
                <div class="col-3">
                <a class="action-type">Action</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <a class="action-text">The target of a signature attack is knocked prone and must succeed on a Constitution saving throw or suffer disadvantage on all attacks until the end of its next turn.</a>
                </div>
            </div>
        </div>
        <div class="row signature-attack">
            <div class="row" style="height:24px;">
                <div class="col-9">
                <a class="signature-attack-header">Flintlock Pistol.</a> <a class="action-type">Ranged Weapon.</a>
                </div>
                <div class="col-3">
                <a class="action-type">Action</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <a class="action-text">+6 to hit, range 40/80 ft., one target. Hit: 7 (1d8+2) piercing damage, Misfire 8.</a>
                </div>
            </div>
        </div>
        <div class="row signature-attack">
            <div class="row" style="height:24px;">
                <div class="col-9">
                <a class="signature-attack-header">Flintlock Pistol.</a> <a class="action-type">Ranged Weapon.</a>
                </div>
                <div class="col-3">
                <a class="action-type">Action</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <a class="action-text">+6 to hit, range 40/80 ft., one target. Hit: 7 (1d8+2) piercing damage, Misfire 8.</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="col-md-10">
    <div class="card-back">
        <div class="character-portrait">
        <div class="npc-top-block">
            <div class="npc-name">
            </div>
            <div class="npc-type">
            Test Type
            </div>
            <div class="npc-level">
            Test Level
            </div>
        </div> 
        </div>
    </div>
</div>-->
    </body>
    
</html>