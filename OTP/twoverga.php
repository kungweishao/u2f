<?php
$conn = mysqli_connect('localhost','root','memory850916');
$dbname = "phpmyadmin";
mysqli_select_db($conn, $dbname);

require_once 'PHPGangsta/GoogleAuthenticator.php';
$ga = new PHPGangsta_GoogleAuthenticator();
session_start();
$user = $_SESSION["user"];


$sele = "SELECT * FROM test where username='$user'";
$result = mysqli_query($conn,$sele);
$row = mysqli_fetch_array($result);
$secret = $row['basecode'];
//print($secret);
$i=0;
$j=1;
$num[10]=[''];
while($i<10){
	$oneCode = $ga->getCode($secret,$i);
	$num[$i]=$oneCode;
//	print("i = $i &nbsp&nbsp&nbsp&nbsp");
//	echo "$oneCode <br>";
	$i = $i + $j;
}
?>

<html>
 <form METHOD="POST" ACTION="tt.php">
  verification code:<input type="text" name="cood"/><p>
  <input type="submit" name='verification' values = 'verification'onclick="location.href='tt.php'">
 </form>
</html>
