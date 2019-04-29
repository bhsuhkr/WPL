<?php
session_start();
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
      <div class="navbar-header" >
        <a href="welcome.php"><img src="posterPic/logo_min.jpg" class="logo img-responsive" alt="logo"></a>
      </div>
      <div class="search-container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <form class="form-inline mr-auto" method="get" action = "welcome.php">
            <input class="form-control" name = "title" type="text" placeholder="Search Photo" aria-label="Search" style="margin: 5pt;padding: 5pt">
            <a href="logout.php"><button class="btn btn-outline-danger" type="button">logout</button></a>
            <button class="btn btn-default" type="submit">Search</button>
          </form>
        </div>
      </div>
      <?if (!$login) {
        echo '<h2 class="navbar-text navbar-right">Don&#39;t have an account? <a href="#" class="navbar-link">Sign up</a> Now</h2>';
      }else{
        echo '<h2 class="navbar-text navbar-right">Welcome '.$_SESSION['username'].'!</h2>';
      }
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
            echo "<li><a href='#myfavorite'>Favorite</a></li>";
          }
          else {
            echo "<li><a href='manage_photo.php'>Manage Photo</a></li>
            <li><a href='trashcan.php'>Deleted Item</a></li>";
          }
          ?>
          </ul>
      </div>

      <div class="col-md-10 col-sm-10 col-xs-10" id = "MidCol" >    

        <div class="row">
          <div class="page-header">
            <h1 id = "myfavorite" >My Favorite Photo</h1>
          </div>
        </div>


        <?php

            $sql="SELECT PosterUrl, PosterName, description, location
                  FROM poster, user, user_favorite 
                  where poster.PosterId = user_favorite.PosterID and user_favorite.userID = user.UserId 
                  and user.username = '".$_SESSION["username"]."'";
            $result = mysqli_query($con,$sql);

            echo' <div class="row">';
            while($row = mysqli_fetch_array($result)) {
              echo("<div class='col-lg-3 col-md-4 col-xs-6 thumb'>");
              echo("<a class='thumbnail' href='#' data-image-id='' data-toggle='modal' data-title='".$row[1]."' data-image='".$row[0]."' data-target='#image-gallery'>");
              echo("<img class='img-thumbnail' src='".$row[0]."' alt='".$row[1]."'>");
              echo("</a>");
              echo("</div>");    
            }
            
            echo' </div>';  
        ?>
      </div>
   </div>
</div>

<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="image-gallery-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive col-md-12" src="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                </button>

                <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
  <p>Event Photography</p>
</footer>






</body>
</html>
