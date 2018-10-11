<?php
$link = mysqli_connect("localhost", "root", "memory850916");

$dbname = "phpmyadmin";

mysqli_select_db($link, $dbname);


if(!$link) {
  die("Connection faild");
} else {
   print("success");
}
$sql = "INSERT INTO test (username,passwd,twover) VALUES ('test','test123',0)";

//mysqli_query($link,$sql);
if($link->query($sql) === TRUE)
	print( "\nsuccessful");
else
	print( "fail");


?>
