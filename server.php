<?php
session_start();

//initializing variables

$username = "";
$email = "";
$errors = array();


//connect to the database
$db = mysqli_connect('localhost', 'XXXXX', 'XXXXXXX', 'registration');

if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }
    
//validate email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($errors, "Invalid email provided");
  }

//check password for complexity    
  
    if(strlen($password_1) < 8){
        array_push($errors, "Password too short");
    }
    
    if (!preg_match("#[0-9]+#", $password_1)) {
        array_push($errors, "Password must contain at least 1 number!");
    }
    
    if (!preg_match("#[a-zA-z]+#", $password_1)) {
        array_push($errors, "Password must include at least one letter!");
    }
    
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = password_hash($password_1, PASSWORD_BCRYPT);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (`username`, `email`, `password`) VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// ... 


// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

 if (empty($username)) {
 	array_push($errors, "Username is required");
 }
 if (empty($password)) {
 	array_push($errors, "Password is required");
 }

 if (count($errors) == 0) {
  	
  	$sql = "SELECT * FROM users WHERE username=?";
    if($stmt = mysqli_prepare($db,$sql)){
    mysqli_stmt_bind_param($stmt, "s", $username);
        if (mysqli_stmt_execute($stmt)){
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $hash = $row['password'];
            if (password_verify($password, $hash)) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                $_SESSION['user_id'] = $row['id']; 
                header('location: index.php');               
            }
            else {
                array_push($errors, "Invalid Username/Password");
            }
                
        }
        else {
            array_push($errors, "Invalid Username/Password");
        }
        
    }
        else {
            array_push($errors, "Wrong username/password combination");
        }
        

      }

        
  	  
  	}

    // Handle a request to change the password for a User
    if (isset($_POST['change-password'])) 
    {
      $username = mysqli_real_escape_string($db, $_SESSION['username']);
      $currentpassword = mysqli_real_escape_string($db, $_POST['current-pass']);
      $confirmpassword = mysqli_real_escape_string($db, $_POST['confirm-pass']);
      $newpassword = mysqli_real_escape_string($db, $_POST['new-pass']);

      if ($newpassword != $confirmpassword || empty($newpassword))
      {
        $_SESSION['user-acc-msg'] = $_SESSION['user-acc-msg'] . "\n Passwords do not match or are blank";
        array_push($errors, "Passwords do not match or are blank");
        header('location: user.php');
        exit;
      }

      $sql = "SELECT * FROM users WHERE username=?";
      if($stmt = mysqli_prepare($db,$sql)){
        mysqli_stmt_bind_param($stmt, "s", $username);
        if (mysqli_stmt_execute($stmt)){
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $hash = $row['password'];
            if (password_verify($currentpassword, $hash)) {
                // $_SESSION['username'] = $username;
                // $_SESSION['user_id'] = $row['id'];
                $password = password_hash($newpassword, PASSWORD_BCRYPT);//encrypt the password before saving in the database
                $update_sql = "UPDATE `users` SET `password`= ? WHERE `id` = ?";
                $_stmt = mysqli_prepare($db,$update_sql);
                mysqli_stmt_bind_param($_stmt, "si", $password, $row['id']); 
                $_stmt ->execute();
                $_SESSION['user-acc-msg'] = "Password Successfully Updated.";
                header('location: user.php');
                exit;              
            }
            else {
              $_SESSION['user-acc-msg'] = $_SESSION['user-acc-msg'] . "<br> Incorrect Password Provided.";
              header('location: user.php');
              exit;
            }
                
        }
        else {
            array_push($errors, "Invalid Username/Password");
            header('location: user.php');
            exit;
        }
      }

    }

    // Handle request to change email for a user account
    if (isset($_POST['change-email']))
    {
      $id = mysqli_real_escape_string($db, $_SESSION['user_id']);
      $currentpassword = mysqli_real_escape_string($db, $_POST['current-pass']);
      $confirmemail = mysqli_real_escape_string($db, $_POST['confirm-email']);
      $newemail = mysqli_real_escape_string($db, $_POST['new-email']);



      $sql = $sql = "SELECT * FROM users WHERE id = ?";
      if($stmt = mysqli_prepare($db,$sql))
      {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)){
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $hash = $row['password'];
            if (password_verify($currentpassword, $hash)) {
              //check that two emails match
              if ($newemail != $confirmemail)
              {
                $_SESSION['user-acc-msg'] = "Email addresses do not match.";
                header('location: user.php');
                exit;
              }
              //validate email address
              if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['user-acc-msg'] = "*Invalid Email Provided.";
                header('location: user.php');
                exit;
              }
              //check that email is not already registered
                // first check the database to make sure 
              // a user does not already exist with the same username and/or email
              $user_check_query = "SELECT * FROM users WHERE email='$newemail' LIMIT 1";
              $result = mysqli_query($db, $user_check_query);
              $user = mysqli_fetch_assoc($result);

              if ($user['email'] === $newemail) 
              {
                $_SESSION['user-acc-msg'] = "Email already in use.";
                header('location: user.php');
                exit;
              }


              

              //Update Email Address for Session User
              $update_sql = "UPDATE `users` SET `email`= ? WHERE `id` = ?";
              $_stmt = mysqli_prepare($db,$update_sql);
              mysqli_stmt_bind_param($_stmt, "si", $newemail, $_SESSION['user_id']); 
              $_stmt ->execute();

                $_SESSION['user-acc-msg'] = "Email Successfully Updated";
                header('location: user.php');
                exit;
              }
              else 
              {
                $_SESSION['user-acc-msg'] = "Incorrect Password Provided.";
                header('location: user.php');
                exit;
              }
        }
      }
    }

    //Handle request to delete portrait files a user has uploaded
    if (isset($_POST['delete-marked-files']))
    {
      $imgcount = 0;

      //pull array of image paths from form post
      $imgs = $_POST['img'];
      foreach ($imgs as $img) {
        //unlink each file in imgs array
        unlink ($img);
        $imgcount = $imgcount + 1;
      }
      $_SESSION['user-acc-msg'] = $imgcount . " file(s) successfully deleted.";
      header('location: user.php');
      // print_r($imgs);
    }
?>
