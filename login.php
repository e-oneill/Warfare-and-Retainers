<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="dmtools.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include "page-header.php"; ?>
<!--
    <div class="col-md-4">
    <h2>Login</h2>
    </div>
    
    <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
  		    <input type="text" name="username" >
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
  	    </div>
        <div class="input-group">
            <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
-->
<div class="container">
<div class="row" style="justify-content: center;">
<div class="col-12 col-lg-6 login-container" >
    <form class="form-horizontal" method="post" action="login.php">
<fieldset>


<!--<div class="container login-container">    -->

<!-- Form Name -->
<div class="col-md-12">
<legend>Login</legend>
<hr>
</div>
<?php include('errors.php'); ?>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 login-label" for="username">Username</label>  
  <div class="col-md-6">
  <input id="username" name="username" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>
<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 login-label" for="password">Password</label>
  <div class="col col-md-6">
    <input id="password" name="password" type="password" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="login_user"></label>
  <div class="col-md-4">
    <button id="login_user" name="login_user" class="btn btn-primary" style="margin-bottom:1rem;">Login</button><br>
  </div>
    <div class="col-md-4">
    <p>
        <a>Not yet a member?</a> <a href="register.php">Sign up</a>
    </p>
    </div>
    </div>
<!--</div>-->


</fieldset>
</form>
</div>
</div>
</div>
</body>
    
</html>