<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
}

$user = $_SESSION['username'];

/* Update session user entry with any non-empty fields */
if (!empty($_REQUEST['name'])) {
	$name = $_REQUEST['name'];

	if (!$req = $mysqli->prepare("UPDATE user_info SET name = ? WHERE username = 
		(SELECT username FROM users WHERE username = ?);")) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$req->bind_param("ss", $name, $user);
		if (!$req->execute()) {
			echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$req->close();
			echo 'updated';	
		}
	}
}

if(!empty($_REQUEST['gender'])) {
	$gender = $_REQUEST['gender'];
	if (!$req = $mysqli->prepare("UPDATE user_info SET gender = ? WHERE username = 
		(SELECT username FROM users WHERE username = ?);")) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$req->bind_param("ss", $gender, $user);
		if (!$req->execute()) {
			echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$req->close();				
		}

	}
	echo "updated";
}

if(!empty($_REQUEST['dob'])) {
	$dob = $_REQUEST['dob'];
	if (!$req = $mysqli->prepare("UPDATE user_info SET dob = ? WHERE username = 
		(SELECT username FROM users WHERE username = ?);")) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$req->bind_param("ss", $dob, $user);
		if (!$req->execute()) {
			echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$req->close();
			echo 'updated';	
		}
	}
}

if(!empty($_REQUEST['location'])) {
	$location = $_REQUEST['location'];
	if (!$req = $mysqli->prepare("UPDATE user_info SET location = ? WHERE username = 
		(SELECT username FROM users WHERE username = ?);")) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$req->bind_param("ss", $location, $user);
		if (!$req->execute()) {
			echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$req->close();
			echo 'updated';	
		}
	}
}

if(!empty($_REQUEST['inspiration'])) {
	$inspiration = $_REQUEST['inspiration'];
	if (!$req = $mysqli->prepare("UPDATE user_info SET inspiration = ? WHERE 
		username = (SELECT username FROM users WHERE username = ?);")) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$req->bind_param("ss", $inspiration, $user);
		if (!$req->execute()) {
			echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$req->close();
			echo 'updated';	
		}
	}
}
    	
?>

