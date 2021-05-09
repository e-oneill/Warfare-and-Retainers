<?php 
    session_start();
    if (isset($errors) == 0)
    {
    $errors = array();
    }

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
<div style="padding:2rem;">
<div class="row">
<!-- Contents will be inserted into this section based on data set in the handling script. -->
<?php if (isset($_SESSION['user-acc-msg'])) {
    ?>
<div class="col-12" style="justify-content:center;display: flex;">
 <div class="col-lg-6 alert alert-danger">
    <h4>
    <?php echo $_SESSION['user-acc-msg']; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></h4>
    <?php
    unset($_SESSION['user-acc-msg']); 
        ?>

 </div>       
</div>   
<?php    
}
    ?>
<div class="col-md-12">
<legend>User Account Administration: <?php echo $_SESSION['username']; ?></legend> 
</div>
<div class="col-md-12">
</div>
<div class="col-md-6 col-lg-3"> 
<div class="user-control-part">

<Strong>Password Administration</Strong>
<form method="post" action="server.php">
    <fieldset>
        <div class="form-group">
            <label for="current-pass">Current Password</label>
            <div class="user-form-control">
                <input type="password" class="form-control input-md" name="current-pass"> 
            </div>
            <label for="current-pass">New Password</label>
            <div class="user-form-control">
                <input type="password" class="form-control input-md" name="new-pass"> 
            </div>
            <label for="current-pass">Confirm New Password</label>
            <div class="user-form-control">
                <input type="password" class="form-control input-md" name="confirm-pass"> 
            </div> 
        </div>
        <div class="form-group">
                <button id="change-password" name="change-password" class="btn btn btn-user-acc" onclick='return confirm("Are you sure you want to update your password?")'>Change Password</button> 
        </div>
    </fieldset>
</form>
</div>
</div>
<div class="col-md-6 col-lg-3">
<div class="user-control-part">
<Strong>Email Administration</Strong>
<form method="post" action="server.php">
    <fieldset>
        <div class="form-group">
            <label for="current-pass">Current Password</label>
            <div class="user-form-control">
                <input type="password" class="form-control input-md" name="current-pass"> 
            </div>
            <label for="current-pass">New Email</label>
            <div class="user-form-control">
                <input type="text" class="form-control input-md" name="new-email"> 
            </div>
            <label for="current-pass">Confirm New Email</label>
            <div class="user-form-control">
                <input type="text" class="form-control input-md" name="confirm-email"> 
            </div>
        </div>
        <div class="form-group" >
                <button id="change-email" name="change-email" class="btn btn-user-acc" onclick='return confirm("Are you sure you want to update the email address associated with this account?")'>Change Email</button> 
        </div>
    </fieldset>
</form>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-lg-6">
<div class="user-control-part">
<Strong>My Saved Files</Strong>
<form method="post" action="server.php">
    <fieldset>
        <div class=row>
    <?php 
        $filesize_tracker = 0;
        $dirname = 'images' . '/' . $_SESSION['user_id'] . '-' . $_SESSION['username'] . '/';
        $images = glob($dirname."*.{png,jpg,gif}", GLOB_BRACE);
        foreach($images as $image) {
            ?>

                <?php
            ?>
            <div class="col-12 col-md-4 col-lg-3 user-acc-img">
            <div class="col-12" style="background-size: cover; height: 150px; background-image: url(<?php echo $image ?>);" width="100%">
                </div>
                <input type="checkbox" name="img[]"value="<?php echo $image; ?>"/> Delete 
                <?php 
                $filesize = round((filesize($image)/1024));
                $filesize_tracker = $filesize_tracker + $filesize;
                echo '(' . ($filesize) . ' KB)';
                ?>
                </div>
    <?php
        }
            $filesize_tracker = Round(($filesize_tracker/1024));
            $filesize_max = 20;
            $filesize_usage = round(($filesize_tracker / $filesize_max) * 100)
    ?>
        </div>
        <div class="form-group" >
                File space used : <?php echo $filesize_tracker .  " out of " . $filesize_max . " MB available" ?>
                <progress class="user-acc-filesize" style="-webkit-appearance: none;" max="20" value =<?php echo '"' . $filesize_tracker . '"' ?>>
                <div pseudo="-webkit-progress-inner-element">
                <div pseudo="-webkit-progress-bar">
                <div pseudo="-webkit-progress-value" style="width: <?php echo $filesize_usage ?>%;">
                </div>
                </div>
                </div>
                </progress>
            
            
                <button id="delete-marked-files" name="delete-marked-files" class="btn btn-user-acc" onclick='return confirm("Are you sure you want to delete the selected file(s)?")'>Delete Selected Files</button> 
        </div>
    </fieldset>
</form>
</div>
</div>
</div>
</div>

    </body>
</html>