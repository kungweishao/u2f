<?php
$link = mysqli_connect("localhost", "root", "memory850916");

$dbname = "phpmyadmin";

if(!mysqli_select_db($link, $dbname)){
  die("error");
} else {
  echo "successful";
}

mysqli_close($link);
?>


