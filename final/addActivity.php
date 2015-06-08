<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
}

$user = $_SESSION['username'];
$activity = $_REQUEST['activity'];
$type = NULL;
$exists = false;

/* Check if added type already exists */
if (!$req = $mysqli->prepare("SELECT type FROM type WHERE type=?;")) {
	echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
} else {
	$req->bind_param("s", $activity);
	if (!$req->execute()) {
		echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$req->bind_result($type);
		while($req->fetch()) {
			$type;
		}

		if ($type == $activity) {
			echo 'exists';
			$exists = true;
		}
		$req->close();
	}
}

if ($exists == false) {
	if (!$stmt = $mysqli->prepare("INSERT INTO type (type) VALUES(?);")) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$stmt->bind_param("s", $activity);
		$stmt->execute();
		$stmt->close();
		echo 'added';
	}
}