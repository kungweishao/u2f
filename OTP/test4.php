<?php
$conn = mysqli_connect('localhost','root','memory850916');
$dbname = "phpmyadmin";
mysqli_select_db($conn, $dbname);

$sql = "SELECT * from test where username='test'";
$result = mysqli_query($conn,$sql);
print_r(mysqli_fetch_array($result));

mysqli_close($conn);
?>
