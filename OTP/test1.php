<?php
$link = mysqli_connect("localhost", "root", "memory850916");

$dbname = "phpmyadmin";

mysqli_select_db($link, $dbname);
$data = "select username from test where username='test'";
$result = mysqli_query($link, $data);
$row = mysqli_fetch_array($result);
$user= $row['username'];
printf("%s",$user);
mysqli_close($link);
?>
