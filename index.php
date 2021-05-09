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
    <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">
     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="dmtools.css" rel="stylesheet" type="text/css">
    </head>
<body>
<?php include "page-header.php"; ?>
    
<!--
<div class="jumbotron">
  <h1 class="display-4">Tools for Dungeon Masters!</h1>
  <hr class="my-4">
<p class="lead">Helping you run the game.</p>
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
  </p>
</div>
-->
<?php if (isset($_SESSION['success'])) {
    ?>
<div class="col-12" style="justify-content:center;display: flex;">
 <div class="col-lg-6 alert alert-success">
    <h4><?php echo $_SESSION['success'];?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></h4>
    <?php
    unset($_SESSION['success']); 
        ?>

 </div>       
</div>   
<?php    
}
    ?>
<section class="details-card">
<!--    <div class="container">-->
        <div class="row">
        <div class="col-md-4 card-col" id="card1">
                <div class="card-content">
<!--
                    <div class="card-img">
                          <a href="quickretainercreator.php"><img src="images/retainercardesigner.png" alt="retainer card designer"></a>
                    </div>
-->
                    <div class="card-desc">
                        <a href="mycampaigns.php"><h3>Campaigns</h3></a>
                        <p>Tools for tracking and organising your campaign and the items within them!</p>
<!--                            <a href="#" class="btn-card">Read</a>   -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-col" id="card2">
                <div class="card-content">
<!--
                    <div class="card-img">
                          <a href="quickretainercreator.php"><img src="images/retainercardesigner.png" alt="retainer card designer"></a>
                    </div>
-->
                    <div class="card-desc">
                        <a href="mycharacters.php"><h3>Characters</h3></a>
                        <p>An adventure can't happen without adventurers!</p>
<!--                            <a href="#" class="btn-card">Read</a>   -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-col" id="card3">
                <div class="card-content">
<!--
                    <div class="card-img">
                          <a href="quickretainercreator.php"><img src="images/retainercardesigner.png" alt="retainer card designer"></a>
                    </div>
-->
                    <div class="card-desc">
                        <a href="myretainers.php"><h3>Retainers</h3></a>
                        <p>It's dangerous out there, so don't go it alone. Here, you'll find tools for the people who tag along.</p>

                        <a href="quickretainercreator.php" class="btn btn-success"><span class="glyphicon glyphicon-exclamation-sign"></span> Try it Out!</a>
<!--                            <a href="#" class="btn-card">Read</a>   -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-col" id="card3">
                <div class="card-content">
<!--
                    <div class="card-img">
                          <a href="quickretainercreator.php"><img src="images/retainercardesigner.png" alt="retainer card designer"></a>
                    </div>
-->
                    <div class="card-desc">
                        <a href="myretainers.php"><h3>Armies</h3></a>
                        <p>Track and manage the soldiers who flock to your banner.</p>
<!--                            <a href="#" class="btn-card">Read</a>   -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
<!--
                <div class="card-content">
                    <div class="card-img">
                        <img src="https://placeimg.com/380/230/animals" alt="">
                    </div>
                    <div class="card-desc">
                        <h3>Campaign Setting</h3>
                        <p>Explore the world of my custom 5e campaign setting!</p>
                    </div>
                </div>
-->
            </div>
            <div class="col-md-4">
                <!--<div class="card-content">
                    <div class="card-img">
                        <img src="https://placeimg.com/380/230/tech" alt="">
                    </div>
                    <div class="card-desc">
                        <h3>Captain Setting</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laboriosam, voluptatum! Dolor quo, perspiciatis
                            voluptas totam</p>
                            <a href="#" class="btn-card">Read</a>   
                    </div>
                </div>-->
            </div>
        </div>
<!--    </div>-->
</section> 
    </body>
</html>