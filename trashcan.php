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

$poster_name = $_GET["title"];
$poster_loc = $_GET["location"];
$page = $_GET["page"];
$notice = $_GET['notice'];
if($page=="" || $page=="1"){
    $page1=0;
}else{
    $page1=($page*3)-3;
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
      
      <?if (!$login) {
        echo '<h2 class="navbar-text navbar-right">Don&#39;t have an account? <a href="#" class="navbar-link">Sign up</a> Now</h2>';
      }else{
        echo '<h2 class="navbar-text navbar-right">Welcome '.$_SESSION['username'].'!!!</h2>';
      }
      ?>
    </nav>
</div>

<div class="container-fluid" style="padding: 10pt">
  <div class="row row-eq-height">
      <div class="col-md-2 col-sm-2 col-xs-2" id = "LeftCol">
          <ul class="nav nav-pills nav-stacked">
            <li><a href="welcome.php">Back to Main Page</a></li>
            
            <li><a href="PosterUpload.php">Upload Photo</a></li>
          </ul>
      </div>

      <div class="col-md-10 col-sm-10 col-xs-10" id = "MidCol" >    

      <div class="row">
        <div class="page-header">
          <h1 id = "search_result">Deleted Item</h1>
        </div>
      </div>
      <?php

          $sql="SELECT PosterUrl, PosterName, description, posterid, location
                FROM poster
                where PosterName like '%".$poster_name."%' and Location like '%".$poster_loc."%' and deleted = '1'";

          $result = mysqli_query($con,$sql);

          $cou=mysqli_num_rows($result);
          $totalPageNum=$cou/10;
          $totalPageNum=ceil($totalPageNum);

          $sql = $sql."limit ".$page1.",10";
          $result = mysqli_query($con,$sql);

          echo'
          <div class="container mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col"> </th>
                                    <th scope="col">Catogory</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>                     
                                    <th width="40"> </th>
                                    <th width="40"> </th>
                                </tr>
                            </thead>
                            <tbody>';
         
          while($row = mysqli_fetch_array($result)) {
                                echo'
                                <tr>
                                  <td><img src="'.$row[0].'" alt="'.$row[1].'" class="img-responsive" height="42" width="42"</td>
                                  <td>'.$row[4].'</td>
                                  <td>'.$row[1].'</td>
                                  <td><input class="form-control" type="textarea" value="'.$row[2].'" /></td>



                                  <form method="post" action = "recover_poster.php">
                                    <input type="hidden" name = "id" value="'.$row[3].'"/>
                                    <td><button type="submit" class="btn btn-success">Recover </button></td>
                                  </form>

                                </tr>';
          }
          echo'                      
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
          ';
        ?>


                
        <div class="row">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <a class="page-link" href="trashcan.php?page=<?if($page == 1){echo '1';}
                                                                else{echo($page-1);}
                                                        ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <?
              for($b=1;$b<=$totalPageNum;$b++){
                ?>
                <li class="page-item"><a class="page-link" 
                    href="trashcan.php?page=<?echo($b);?>">
                    <?echo($b);?></a></li><?


                  
              }
              ?>

              <li class="page-item">
                <a class="page-link" href="trashcan.php?page=<?if($page == $totalPageNum){echo($totalPageNum);}
                                                                else{echo($page+1);}
                                                        ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

      


   </div>
</div>

<footer class="container-fluid text-center">
  <p>Event Photography</p>
</footer>






</body>
</html>
