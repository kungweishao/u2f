<?php
$conn = mysqli_connect('localhost','phpmyadmin','32654189');
$dbname = "phpmyadmin";
mysqli_select_db($conn, $dbname);

if(!empty($_POST['account'])){
        $user = $_POST['account'];
        $pass = $_POST['password'];
        session_start();
        $_SESSION["user"] = $user;

        $sele = "SELECT * FROM test where username='$user'";
        $result = mysqli_query($conn,$sele);

        $row = mysqli_fetch_array($result);
        if(!$row){
                print("You need create a user");
        } else {
                if(!empty($_POST['password']) && $pass===$row['passwd']){
                        if($row["twover"]==1){
//                              session_start();
//                              $_SESSION["user"] = $user;
                                header("Location:twoverga.php");
                                exit;
                        } else if($row["twover"]==2){
				header("Location:u2fauth.php");
                                exit;
			} else {
                                header("Location:suc");
                                exit;
                        }
                } else {
                        print("password error");
                }
        }
} else {
        print("PLEASE input user");
        header("Refresh:2;login");
        exit;
}

mysqli_close($conn);
?>
