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
/*$pwd = $_REQUEST['pwd'];
$user = $_REQUEST['user'];
$type = $_REQUEST['type']; */

$value = $_REQUEST['query'];
$formfield = $_REQUEST['field'];

/* Check if user name exists */
if ($formfield == "user") {
	$existUser = array();
	$name = NULL;
	$exists = false;

	/* Check user name */
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
				echo "Existing User";
				echo '<span>Existing User</span>';
				$stmt->close();
			} else {
				echo "New User";
				echo '<span>New User</span>';
			}
		}
	}

} else {
/* If new user, check username is unique and add to table */	

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