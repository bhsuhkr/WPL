


<?php
session_start();
session_destroy();

include "db.php";


$login = False;
if(empty($_SESSION["username"])||empty($_SESSION["pw"])){
  header("location:login.php?login=False");
  exit();
} else{
  $login = True;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Welcome to Double B</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/welcome.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link href="css/welcome.css" rel="stylesheet" type="text/css" />
  <link href="posterPic/shortcutLogo.jpg" type="image/gif" rel="shortcut icon" /> 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
</head>
<body>

<div class="container-responsive">
<nav id = "topNav" class="navbar navbar-default">

<div class="navbar-header">
      <a href="welcome.php"><img src="posterPic/logo_min.jpg" class="logo img-responsive" alt="logo"></a>
</div>
    <?if (!$login) {
      echo '<p class="navbar-text navbar-right">Don&#39;t have an account? <a href="#" class="navbar-link">Sign up</a> Now</p>';
    }else{
      echo '<h2 class="navbar-text navbar-right">Welcome '.$_SESSION['username'].'!</h2>';    }
    ?>

</nav>
</div>

<div class="container-fluid" style="padding: 10pt">
  <div class="row row-eq-height">
      <div class="col-md-2 col-sm-2 col-xs-2" id = "LeftCol">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="welcome.php">Main Page</a></li>

          <?
          if($_SESSION["type"] == "0"){
            echo "<li><a href='user.php'>Favorite</a></li>";
          }
          else{
            echo "<li><a href='search_poster.php'>Manage Photo</a></li>
            <li><a href='PosterUpload.php'>Upload Photo</a></li>
            <li><a href='trashcan.php'>Deleted Item</a></li>";
          }
          ?>
        </ul>
      </div>

      <div class="col-md-10 col-sm-10 col-xs-10" id = "MidCol" >
        <div class="row">
        	<?echo "<h1>Logged Out Sucessfully.</h1>";
			echo "<a href = 'login.php'><h1>Back to Login Page</h1></>";?>

        </div>
      </div>

   </div>
</div>

<footer class="container-fluid text-center">
    <p>Event Photography</p>
  </footer>

</body>
</html>
