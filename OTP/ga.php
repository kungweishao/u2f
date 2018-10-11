<?php
$conn = mysqli_connect("localhost", "root", "memory850916");

$dbname = "phpmyadmin";

mysqli_select_db($conn, $dbname);

session_start();
$user=$_SESSION["user"];

$sele = "select * from test where username='$user'";
$result = mysqli_query($conn,$sele);
$row = mysqli_fetch_array($result);
//print($row['twover']);


if($row['twover']== 0){

	require_once 'PHPGangsta/GoogleAuthenticator.php';

	$ga = new PHPGangsta_GoogleAuthenticator();
	$secret = $ga->createSecret();
	echo "PLEASE input Secret is: ".$secret."<br><br>";
	
	$qrCodeUrl = $ga->getQRCodeGoogleUrl('Blog', $secret);
//	echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."<br>";
	echo "<img src='$qrCodeUrl'.png><br><br>";

	$upd = "update test set twover=1,basecode='$secret' where username = '$user'"; 
	mysqli_query($conn,$upd);

} else {
	print("You already use it");
//	header("Refresh:5;url=/suc");
//	exit;
}

?>

<html>
  <head>
    <meta charset="utf-8">
    <title>綁定GoogleAuthenticator</title>
  </head>
  <body>
  <button type="button" onclick="location.href='login'">
  TURN BACK LOGIN
  </button>
  </body>
</html>


