<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="dmtools.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include "page-header.php"; ?>

  
    
    <form class="form-horizontal" method="post" action="register.php">
<fieldset>

<!-- Form Name -->
<legend>New User Registration</legend>
<?php include('errors.php'); ?>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="username">Username</label>  
  <div class="col-md-6">
  <input id="username" name="username" type="text" value="<?php echo $username; ?>" class="form-control input-md" required="">
  <span class="help-block">Enter a unique username.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email Address</label>  
  <div class="col-md-6">
  <input id="email" name="email" type="text" value="<?php echo $email; ?>" class="form-control input-md" required="">
  <span class="help-block">Enter a valid email address</span>  
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password_1">Password</label>
  <div class="col-md-6">
    <input id="password_1" name="password_1" type="password" placeholder="" class="form-control input-md" required="">
    <span class="help-block">Enter a password. It must contain at least 8 characters, 1 letter and 1 number.</span>
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password_2"></label>
  <div class="col-md-6">
    <input id="password_2" name="password_2" type="password" placeholder="" class="form-control input-md" required="">
    <span class="help-block">Confirm your password.</span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="reg_user"></label>
  <div class="col-md-4">
    <button id="reg_user" name="reg_user" class="btn btn-primary">Register</button>
  </div>
</div>

</fieldset>
</form>
</div>
</body>
</html>