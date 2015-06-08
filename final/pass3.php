<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
} 

/* Get user and password data from log in page */
$pwd = $_REQUEST['password'];
$user = $_REQUEST['username'];
$type = $_REQUEST['type'];

$existUser = array();
$name = NULL;
$exists = false;
$password = NULL;

/* Check that another user isn't already logged in */
if (isset($_SESSION['username'])) {
	if ($_SESSION['username'] === $user) {
		echo 'Already logged in.';
	} else {
		echo 'Wrong user.';
	}
} else {

/* New User - check that user name is available, if so, add to table */
if ($type === 'new') {
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
		/* If taken, alert user */
		foreach($existUser as $item) {
			if($item === $user) {
				$exists = true;
				$stmt->close();
				echo 'User name taken.';
			} 
		}

		if($exists === false) {
			/* Insert user into users table (name/pwd) */
			if (!$stmt = $mysqli->prepare("INSERT INTO users (username, pwd) VALUES(?,?);")) {
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$hpwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
				$stmt->bind_param("ss", $user, $hpwd);
				$stmt->execute();
				$_SESSION['username'] = $user;
				$stmt->close();

				/* Insert user into user_info table to track demographics */
				if(!$stmt = $mysqli->prepare("INSERT INTO user_info(username) VALUES(?);")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$stmt->bind_param("s", $user);
					$stmt->execute();
					$stmt->close();
				}

				/* Insert user into friends table to track friend privileges */
				if(!$stmt = $mysqli->prepare("INSERT INTO friends(username) VALUES(?);")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$stmt->bind_param("s", $user);
					$stmt->execute();
					$stmt->close();
				}

				/* Insert user into workouts table */
				if(!$stmt = $mysqli->prepare("INSERT INTO workout(username) VALUES(?);")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$stmt->bind_param("s", $user);
					$stmt->execute();
					$stmt->close();
				}

				echo 'match';
			}
		}
	}
}

/* If existing user, check that user name is correct and that password matches */
if ($type === 'existing') {
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
		/* Check that entered user is in database */
		foreach($existUser as $item) {
			if($item === $user) {
				$exists = true;
				$stmt->close();
			} 
		}

		/* Send error back to script.js if user does not match database */
		if ($exists === false) {
			echo 'User name incorrect.';
		} else {
			/* User exists, so check password */
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

				/* Check that user entered pwd matches password returned from query */
				if (password_verify($pwd, $password)) {
					echo 'match';
					$_SESSION['username'] = $user;
				} else {
					echo 'No match';
				}
				$stmt->close();
			}
		}
	}
}
}

?>