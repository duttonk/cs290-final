<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
}

$user = $_SESSION['username'];
$pos = $_REQUEST['pos'];
$newFriend = $_REQUEST['friend'];

echo $newFriend;
echo $user;

/* Update Friend 1 */
if ($pos == 1) {
	if (empty($_REQUEST['friend'])) {
		if (!$spec = $mysqli->prepare("UPDATE friends SET friend1 = NULL WHERE username = ?")) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$spec->bind_param("s", $user);
			if (!$spec->execute()) {
				echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				echo 'updated';
			}			
		}
	} else {
		if (!$spec = $mysqli->prepare("UPDATE friends SET friend1 = ? WHERE username = ?")) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$spec->bind_param("ss", $newFriend, $user);
			if (!$spec->execute()) {
				echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				echo 'updated';
			}			
		}
	}
}

/* Update Friend 2 */
if ($pos == 2) {
	if (empty($_REQUEST['friend'])) {
		if (!$spec = $mysqli->prepare("UPDATE friends SET friend2 = NULL WHERE username = ?")) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$spec->bind_param("s", $user);
			if (!$spec->execute()) {
				echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				echo 'updated';
			}			
		}
	} else {
		if (!$spec = $mysqli->prepare("UPDATE friends SET friend2 = ? WHERE username = ?")) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$spec->bind_param("ss", $newFriend, $user);
			if (!$spec->execute()) {
				echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				echo 'updated';
			}			
		}
	}
}

/* Update Friend 3 */
if ($pos == 3) {
	if (empty($_REQUEST['friend'])) {
		if (!$spec = $mysqli->prepare("UPDATE friends SET friend3 = NULL WHERE username = ?")) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$spec->bind_param("s", $user);
			if (!$spec->execute()) {
				echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				echo 'updated';
			}			
		}
	} else {
		if (!$spec = $mysqli->prepare("UPDATE friends SET friend3 = ? WHERE username = ?")) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$spec->bind_param("ss", $newFriend, $user);
			if (!$spec->execute()) {
				echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				echo 'updated';
			}			
		}
	}
}

?>