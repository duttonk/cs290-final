<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
}

$user = $_SESSION['username'];
$dateObj = NULL;
$date = $_REQUEST['date'];
$exists = false;

/* Check if date already exists */
if (!$req = $mysqli->prepare("SELECT date FROM workout WHERE username=?;")) {
	echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
} else {
	$req->bind_param("s", $user);
	if (!$req->execute()) {
		echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
	} else {
		$req->bind_result($dateObj);

		while($req->fetch()) {
			if ($dateObj == $date) {
				echo 'exists';
				$exists = true;
			}
		}
		$req->close();
	}
}


/* Insert new workout using date*/
if ($exists == false) {
	if (!empty($_REQUEST['date'])) {
		$date = $_REQUEST['date'];

		if (!$req = $mysqli->prepare("INSERT INTO workout (username, date) VALUES(?, ?);")) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$req->bind_param("ss", $user, $date);
			if (!$req->execute()) {
				echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$req->close();
				echo 'newdate';
			}
		}
	}
}

		/* If set, update type */
		if (!empty($_REQUEST['type'])) {
			$type = $_REQUEST['type'];

			if (!$req = $mysqli->prepare("UPDATE workout SET type = ? WHERE username=? AND date = ?;")) {
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$req->bind_param("sss", $type, $user, $date);
				if (!$req->execute()) {
					echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$req->close();
					echo 'update';
				}
			}
		}	

		/* If set, update duration */
		if (!empty($_REQUEST['duration'])) {
			$duration = $_REQUEST['duration'];

			if (!$req = $mysqli->prepare("UPDATE workout SET duration = ? WHERE username=? AND date = ?;")) {
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$req->bind_param("sss", $duration, $user, $date);
				if (!$req->execute()) {
					echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$req->close();
					echo 'update';
				}
			}
		}	

		/* If set, update calories */
		if (!empty($_REQUEST['cal'])) {
			$cal = $_REQUEST['cal'];

			if (!$req = $mysqli->prepare("UPDATE workout SET calories = ? WHERE username=? AND date = ?;")) {
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$req->bind_param("sss", $cal, $user, $date);
				if (!$req->execute()) {
					echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$req->close();
					echo 'update';
				}
			}
		}

		/* If set, update notes */
		if (!empty($_REQUEST['notes'])) {
			$notes = $_REQUEST['notes'];

			if (!$req = $mysqli->prepare("UPDATE workout SET notes = ? WHERE username=? AND date=?;")) {
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$req->bind_param("sss", $notes, $user, $date);
				if (!$req->execute()) {
					echo "Execute 3 failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$req->close();
					echo 'update';
				}
			}	
		}

		/* If set, update weather */
		if (!empty($_REQUEST['weather'])) {
			$weather = $_REQUEST['weather'];

			if (!$req = $mysqli->prepare("UPDATE workout SET weather = ? WHERE username=? AND date=?;")) {
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$req->bind_param("sss", $weather, $user, $date);
				if (!$req->execute()) {
					echo "Execute 3 failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$req->close();
					echo 'update';
				}
			}	
		}	

?>

