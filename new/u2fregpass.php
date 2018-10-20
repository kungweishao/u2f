<?php
  session_start();

  $userid=$_SESSION["user"];
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>....</title>
  </head>
    <FORM id="form" name="form" METHOD=POST ACTION="https://192.168.43.177/u2fpass.php">
        username: <input type="text" name="username2" ID="username2" value='<?php echo $userid ?>'>

    </FORM>


	<script type="text/javascript">
	 setTimeout("form.submit()",1000);
	</script>
  </body>
</html>
