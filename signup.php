<?php 
include_once("db.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="js/register.js"></script>
<title>Registration</title>
</head>
<body class="">
   <div class="container">   
      <div class="register_container">
         <form class="form-signin" method="post" id="register-form">
            <h2 class="form-signin-heading" style="font-family: cursive;">Registration</h2><hr>
            <div id="error" class="error">
            </div>
            <div class="form-group">
               <input type="text"  placeholder="Username" name="user_name" id="user_name" />
            </div>
            <div class="form-group">
               <input type="email"  placeholder="Email address" name="user_email" id="user_email" />
               <span id="check-e"></span>
            </div>
            <div class="form-group">
               <input type="password" placeholder="Password" name="password" id="password" />
            </div>
            <div class="form-group">
               <input type="password" placeholder="Retype Password" name="cpassword" id="cpassword" />
            </div>
            <hr/>       
            <button type="submit" name="btn-save" id="btn-submit">Create Account</button>      
         </form>
         <div class="form-group">
               
               <button onclick="goBack()">Cancel</button>
                  <script>
                  function goBack() {
                    window.history.back();
                  }
                  </script>
               
            </div>  
      </div>

   </div>
   
</body></html>

