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

$posterid = $_POST["id"];

$sql = "SELECT PosterUrl, PosterName, description, location FROM poster where posterid = '$posterid'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result)



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
          <form class="form-inline mr-auto" method="get" action = "search_poster.php">
            <input class="form-control" name = "title" type="text" placeholder="Search Poster" aria-label="Search" style="margin: 5pt;padding: 5pt">
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
          <!--
          <form action="upload.php" method="post" enctype="multipart/form-data">Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
          </form>
          -->
          <form class="form-horizontal" action="edit.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              
              <label class="control-label col-sm-2" for="image">Select Image to Upload:</label>
              <div class="col-sm-3">
                <input  type="file" class="filestyle" name="fileToUpload" id="fileToUpload" onchange="loadFile(event)">
                <img id="uploadedPoster" src = '<?echo($row["PosterUrl"]);?>' style="margin: 10px" />
                <script>
                  var loadFile = function(event) {
                    var output = document.getElementById('uploadedPoster');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    var output1 = document.getElementById('uploadedPoster1');
                    output1.value = URL.createObjectURL(event.target.files[0]);
                  };
                </script>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="title">Title:</label>
              <div class="col-sm-10">
                <input type="title" class="form-control" id="title" placeholder="Enter Poster Title" name="title" 
                value='<?echo($row["PosterName"]);?>'>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="description">Description:</label>
              <div class="col-sm-10">
                <textarea id="description" placeholder="Enter Poster Description" name="description" type="description" class="form-control" id="exampleFormControlTextarea1" rows="3"><?echo($row["description"]);?></textarea>
                
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="location">Location:</label>
              <div class="col-sm-10">
                <select class="form-control" name = "location">
                  <option value="">Please Select Location</option>
                  <option <?php if($row["location"] == 'ECSS'){echo("selected");}?> value="ECSS">ECSS</option>
                  <option <?php if($row["location"] == 'ECSW'){echo("selected");}?> value="ECSW">ECSW</option>
                  <option <?php if($row["location"] == 'JSOM'){echo("selected");}?> value="JSOM">JSOM</option>
                  <option <?php if($row["location"] == 'GR'){echo("selected");}?> value="GR">GR</option>
                </select>
              </div>
            </div>
            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name = "id" value="<?echo($posterid)?>"/>
                <button type="submit" value="Upload Poster" class="btn btn-default">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
   </div>
</div>

<footer class="container-fluid text-center">
    <p>Event Photography</p>
  </footer>

</body>
</html>
