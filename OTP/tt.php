<?php

require_once 'twoverga.php';

$k=0;
$j=1;

if(!empty($_POST["cood"])){

	$cod = $_POST["cood"];


	while($k < 10){
                if($num[$k] == $Cod){
                        header("Location:tt");
			exit;
		} else {
			if($k==9){
                        	print("verificate error \n");
			}
		}
                $k = $k + $j;
        }
} else {
	print("Please input verification");
}
?>
