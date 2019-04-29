<?
include "db.php";
$posterid = $_POST["id"];
$sql = "UPDATE poster set deleted = 1 WHERE posterid = '$posterid'";

echo($sql);
mysqli_query($con, $sql);
//header("Location: manage_photo.php?notice=deleteSuccess"); /* Redirect browser */
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>