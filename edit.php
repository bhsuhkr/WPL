<?php

include "db.php";

$target_dir = "posterPic/";
$target_file_basename = basename($_FILES["files"]["name"][0]);
$poster_name = $_POST["title"];
$poster_desc = $_POST["description"];
$poster_loc = $_POST["location"];
$poster_id = $_POST["id"];

echo("<h1>title:".$poster_name."</h1>");
echo("<h1>description:".$poster_desc."</h1>");
echo("<h1>poster_loc:".$poster_loc."</h1>");
echo("<h1>target_file_basename:".$target_file_basename."</h1>");

if($target_file_basename == ""){
    $sql="  UPDATE poster 
            SET postername = '$poster_name', location = '$poster_loc', description = '$poster_desc' 
            where posterid = '$poster_id'";
    echo($sql);
    $result = mysqli_query($con,$sql);
}else{
    move_uploaded_file($_FILES["files"]["tmp_name"][0], $target_dir.$target_file_basename);
    $sql="  UPDATE poster 
            SET postername = '$poster_name', posterurl = '".$target_dir.$target_file_basename."', 
            location = '$poster_loc', description = '$poster_desc' where posterid = '$poster_id'";
    echo($sql);
    $result = mysqli_query($con,$sql);
}
header("Location: manage_photo.php"); /* Redirect browser */
exit();



?>