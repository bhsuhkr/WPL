<?
include "db.php";
$posterid = $_POST["id"];
$sql = "UPDATE poster set deleted = 0 WHERE posterid = '$posterid'";

echo($sql);
mysqli_query($con, $sql);
header("Location: welcome.php"); /* Redirect browser */
exit();
?>