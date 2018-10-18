<?php

require_once('U2F.php');

$pdo = new PDO('mysql:host=localhost;dbname=phpmyadmin','phpmyadmin','32654189');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$pdo->exec("create table if not exists users (id integer primary key auto_increment, name varchar(255))");
$pdo->exec("create table if not exists registrations (id integer primary key auto_increment, user_id integer, keyHandle varchar(255), publicKey varchar(255), certificate text, counter integer)");

$scheme = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$u2f = new u2flib_server\U2F($scheme . $_SERVER['HTTP_HOST']);

session_start();

function createAndGetUser($name) {
    global $pdo;
    $sel = $pdo->prepare("select * from users where name = ?");
    $sel->execute(array($name));
    $user = $sel->fetch();
    if(!$user) {
	echo "alert('A');";
        $ins = $pdo->prepare("insert into users (name) values(?)");
        $ins->execute(array($name));
        $sel->execute(array($name));
        $user = $sel->fetch();
    }
    else
	 echo "alert('B');";
    return $user;
}

function getRegs($user_id) {
    global $pdo;
    $sel = $pdo->prepare("select * from registrations where user_id = ?");
    $sel->execute(array($user_id));
    return $sel->fetchAll();
}

function addReg($user_id, $reg) {
    global $pdo;
    $ins = $pdo->prepare("insert into registrations (user_id, keyHandle, publicKey, certificate, counter) values (?, ?, ?, ?, ?)");
    $ins->execute(array($user_id, $reg->keyHandle, $reg->publicKey, $reg->certificate, $reg->counter));
}

function updateReg($reg) {
    global $pdo;
    $upd = $pdo->prepare("update registrations set counter = ? where id = ?");
    $upd->execute(array($reg->counter, $reg->id));
}

?>

<html>
<head>
    <title>PHP U2F example</title>

    <script src="u2f-api.js"></script>

    <script>
	<?php

	if(!$_POST['username']) {
		echo "alert('no username provided!');";
          } 
	else if(!isset($_POST['action']) && !isset($_POST['register2']) && !isset($_POST['authenticate2'])) {
		echo "alert('no action provided!');";
	  } 
	else {

		$user = createAndGetUser($_POST['username']);

		if(isset($_POST['action'])) {
              switch($_POST['action']):
		 case 'authenticate':
                  try {
		   // $rs = $u2f->getAuthenticateData(getRegs($user->id));
		   // $reqs = json_encode($rs);
			 echo "alert('C');";
                    $reqs = json_encode($u2f->getAuthenticateData(getRegs($user->id)));
		   // $reqs = $u2f->getAuthenticateData(getRegs($user->id));
                    $_SESSION['authReq'] = $reqs;
                    echo "var req = $reqs;";
                    echo "var username = '" . $user->name . "';";
        ?>
        setTimeout(function() {
            console.log("sign: ", req);
            u2f.sign(req, function(data) {
                var form = document.getElementById('form');
                var auth = document.getElementById('authenticate2');
                var user = document.getElementById('username');
                console.log("Authenticate callback", data);

                auth.value=JSON.stringify(data);
                user.value = username;
                form.submit();
            });
        }, 1000);
        <?php
                  } catch( Exception $e ) {
                    echo "alert('error: " . $e->getMessage() . "');";
                  }

                  break;

              endswitch;
	  } else if($_POST['authenticate2']) {
              try {
		 echo "alert('D');";
                $reg = $u2f->doAuthenticate(json_decode($_SESSION['authReq']), getRegs($user->id), json_decode($_POST['authenticate2']));
                updateReg($reg);
                echo "alert('success: " . $reg->counter . "');";
              } catch( Exception $e ) {
                echo "alert('error: " . $e->getMessage() . "');";
              } finally {
                $_SESSION['authReq'] = null;
              }
	}
	}




        ?>

    </script>

</head>
<body>

<meta charset="utf-8">

<form method="POST" id="form">

    username: <input name="username" id="username"/><br/>

    register: <input value="register" name="action" type="radio"/><br/>

    authenticate: <input value="authenticate" name="action" type="radio"/><br/>

    <input type="hidden" name="register2" id="register2"/>
    <input type="hidden" name="authenticate2" id="authenticate2"/>

    <button type="submit">Submit!</button>

</form>

</body>
</html>
