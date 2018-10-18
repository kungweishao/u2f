<?php
$conn = mysqli_connect("localhost", "phpmyadmin", "32654189");

$dbname = "phpmyadmin";

mysqli_select_db($conn, $dbname);

if(!empty($_POST['user'])){
        $user = $_POST['user'];

        $sele = "SELECT username FROM test where username='$user'";
        $result = mysqli_query($conn,$sele);
        if(mysqli_num_rows($result)>0)
        {
		 header("location: /otp/userfail");
		 exit;
//                print("USERNAME already exists!");
        } else  {
                if(!empty($_POST['pass1']) && ($_POST[pass1]===$_POST[pass2])){
                        $pass = $_POST['pass1'];
                        $inse = "INSERT INTO test(username,passwd,twover) VALUES ('$user','$pass',0)";
                        if($result = mysqli_query($conn,$inse))
                        {
                                mysqli_close($conn);
                                header("location: usersuc");
                                exit;
                        } else {
                                print("register error");
                        }
                } else {
                        print("ENPTY PASS or NOT the SAME");
                }
        }
} else {
        print("user fail");
	header("Refresh:2;sign");
        exit;
}
mysqli_close($conn);
?>

