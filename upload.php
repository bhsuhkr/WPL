<?php
session_start();
include "db.php";

$target_dir = "posterPic/";
$poster_name = $_POST["title"];
$poster_desc = $_POST["description"];
$poster_loc = $_POST["category"];

echo("<h1>title:".$poster_name."</h1>");
echo("<h1>description:".$poster_desc."</h1>");
echo("<h1>location:".$poster_loc."</h1>");
echo("<br>");

if(!empty(array_filter($_FILES['files']['name']))){
    foreach($_FILES['files']['name'] as $key=>$val){
        // File upload path
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetFilePath = $target_dir . $fileName;
        echo("file :".$targetFilePath);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFilePath,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["files"]["tmp_name"][$key]);
            if($check == false) {
                echo "File is not an image. ";
                header("Location: user2.php?notice=notimg"); 
                exit();
            }
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
            header("Location: user2.php?notice=misspic");
            exit();
        }

        // if everything is ok, try to upload file
        else {
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                echo "The file ". $fileName. " has been uploaded.";
                uploadPic_DB($fileName, $poster_name, $poster_loc, $poster_desc, $con);
                


            } else {
                echo "Sorry, there was an error uploading your file. ";
                header("Location: welcome.php"); 
                exit();
            }
        }
    }
}

header("Location: welcome.php");
exit();

function uploadPic_DB($fileName, $poster_name, $poster_loc, $poster_desc, $con) {

    echo($filename);
    $sql="INSERT INTO poster(PosterName,PosterURL,Location,Description) VALUES ('".$poster_name."','posterPic/".
    $fileName."','".$poster_loc."','".$poster_desc."')";
    
    echo($sql);

    $result = mysqli_query($con,$sql);
    
    $sql1 = "INSERT INTO user_poster 
            VALUES (".$_SESSION['userid'].", (SELECT posterid from poster where postername = '".$poster_name."'))";
    echo($sql1);
    $result1 = mysqli_query($con,$sql1);
}

?>