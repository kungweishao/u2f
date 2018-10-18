<?php
$conn = mysqli_connect("localhost", "phpmyadmin", "32654189");

$dbname = "phpmyadmin";

mysqli_select_db($conn, $dbname);

session_start();
$user=$_SESSION["user"];

$sele = "select * from test where username='$user'";
$result = mysqli_query($conn,$sele);
$row = mysqli_fetch_array($result);
//print($row['twover']);

if($row['twover']== 0){
	header("location: u2freg.php");
	//header("location: u2f2.php");
	//$upd = "update test set twover=2,basecode='NULL' where username = '$user'";
	//mysqli_query($conn,$upd);


} else {
        print("You already use it");
//      header("Refresh:5;url=/suc");
//      exit;
}

?>


<html>
  <head>
    <meta charset="utf-8">
    <title>綁定U2F</title>
  </head>
  <body>
  <p>

  <button type="button" onclick="location.href='suc'">
  TURN BACK 

  </button>
  </body>
</html>

