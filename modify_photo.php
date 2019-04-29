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
  <link href="css/upload.css" rel="stylesheet" type="text/css" />
  <link href="posterPic/shortcutLogo.jpg" type="image/gif" rel="shortcut icon" /> 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <script src="js/jquery.smartuploader.js"></script>
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
            echo "<li><a href='manage_photo.php'>Manage Photo</a></li>
            <li><a href='upload_photo.php'>Upload Photo</a></li>
            <li><a href='trashcan.php'>Deleted Item</a></li>";
          }
          ?>
        </ul>
      </div>

      <div class="col-md-10 col-sm-10 col-xs-10" id = "MidCol" >
        <div class="row">
          <form  action="edit.php" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <input type="text" id="category" name="location" class="form-control" placeholder="Category *" value='<?echo($row["location"]);?>' >
                  </div>

                  <div class="form-group">
                      <input type="text" id="title" name="title" class="form-control" placeholder="Title *" value='<?echo($row["PosterName"]);?>' >
                  </div>
                        
                  <div class="form-group">
                      <textarea id="description" name="description" class="form-control" style="width: 100%; height: 150px;"><?echo($row["description"]);?></textarea>
                  </div>

                  <div class="form-group">
                      <img id="uploadedPoster" src = '<?echo($row["PosterUrl"]);?>' style="width: 150px" />
                  </div>

                  <div id="drop_zone" class="drop-zone">
                    <p class="title">Drop file here</p>
                    
                    <div class="preview-container"></div>
                  </div>

                  <input id="file_input" accept="image/*" type="file" name="files[]" multiple>
                  

                  <script>

                    var url = "https://smartuploader.s3.amazonaws.com/";
                    var fileNamePrefix = "uploads/" + Date.now() + "_";

                    var result = $("#file_input").withDropZone("#drop_zone", {
                      url: url,   // common page for every 
                      uploadBegin: function(filename, fileIndex, blob) {
                        console.log("begin: " + filename)
                      },
                      uploadEnd: function(filename, fileIndex, blob) {
                        console.log("end: " + filename)
                      },
                      done: function(filenames){
                        console.log("done: " + filenames);
                        var result = $("#result_images");
                        var html = [`<b>Your image${filenames.length === 1 ? '' : 's:'}</b>`];
                        for (var i = 0; i < filenames.length; i++) {
                          var href = url + fileNamePrefix + filenames[i];
                          html.push(`<a href="${href}">${url + fileNamePrefix}<b>${filenames[i]}</b></a>`)
                        }
                        result.html(html.join("<br/>"));
                      },
                      action: function(fileIndex){
                        // you can change your file
                        // for example:
                        var convertTo;
                        var extension;
                        if (this.files[fileIndex].type === "image/png") {
                          convertTo = {
                            mimeType: "image/jpeg",
                            maxWidth: 150,
                            maxHeight: 150,
                          };
                          extension = ".jpg";
                        }
                        else {
                          convertTo = null;
                          extension = null;
                        }

                        return {
                          name: "image",
                          rename: function(filenameWithoutExt, ext, fileIndex) {
                            return filenameWithoutExt + (extension || ext)
                          },
                          params: {
                            preview: true,
                            convertTo: convertTo,
                          }
                        }
                      },
                      ifWrongFile: "show",
                      wrapperForInvalidFile: function(fileIndex) {
                        return `<div style="margin: 20px 0; color: red;">File: "${this.files[fileIndex].name}" doesn't support</div>`
                      },

                      multiUploading: true,
                      formData: function(fileIndex, blob, filename) {
                        var formData = new FormData;
                        formData.set("key", fileNamePrefix + filename);  // key will be file name in S3
                        formData.set("file", blob, filename);
                        return formData
                      },
        
                      ajaxSettings: function(settings, index, filename, blob){
                        // settings.url = "/some_specific_page"
                        // settings.data.set("key", "AKIAJ26HYP7ZBX3UNBLA")  // extra parameters
                        settings.error = function(e) {
                          return alert(`${e.status}: ${e.statusText}`);
                        }
                      }
                    });

                    $("#upload_images").click(result.upload);

                  </script>

                  <div class="form-group">
                      <input type="hidden" name = "id" value="<?echo($posterid)?>"/>
                      <input type="submit" name="btnSubmit" class="btnContact" value="Submit" />
                  </div>

                  
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
