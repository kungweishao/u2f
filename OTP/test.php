<?php

$Link = mysqli_connect('localhost','root','memory850916');

if(!$Link){
	die('link error :'.mysqli_error());
}

echo 'Link successful';

mysqli_close($Link);
?>
