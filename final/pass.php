<?php
ini_set('display_errors', 'On');
include 'info2.php';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
} else {
	echo "Connection Good.\n";
}
var_dump($_REQUEST);

/* Get user and password data from log in page */
$pwd = $_REQUEST['pwd'];
$user = $_REQUEST['user'];

$existUser = array();
$name = NULL;
$exists = false;

/* Check to see if user exists */
if (!$stmt = $mysqli->prepare("SELECT username FROM users WHERE username=?")){
	echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
}else {
	$stmt->bind_param("s", $user);
	$stmt->execute();
	if(!$stmt->bind_result($name)) {
		echo "Binding output parameters failed!";
	} 
	while ($stmt->fetch()) {
		array_push($existUser, $name);
	}

	foreach($existUser as $item) {
		if($item === $user) {
		//	echo '<br>user esists';
			$exists = true;
			$stmt->close();

			$password = NULL;

			/* If username exists in database*/
			if (!$stmt = $mysqli->prepare("SELECT pwd FROM users WHERE username=?")){
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			}else {
				$stmt->bind_param("s", $user);
				$stmt->execute();
				if(!$stmt->bind_result($password)) {
					echo "Binding output parameters failed!";
				} 
				while ($stmt->fetch()) {
					$password;
				}


				if (password_verify($pwd, $password)) {
					echo 'SUCCESS';
				} else {
					echo 'Uh oh!';
				}
				$stmt->close();
			}
		}
	}
}

if($exists === false) {
	if (!$stmt = $mysqli->prepare("INSERT INTO users (username, pwd) VALUES(?,?);")) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$hpwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
		$stmt->bind_param("ss", $user, $hpwd);
		$stmt->execute();
		echo '<h3>Patient successfully added!</h3>';
	}
	$stmt->close();
}




?>