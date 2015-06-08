<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
}
?>

<!DOCTYPE html>
<html>
  <head><title>Workouts</title></head>
  <link rel="stylesheet" type="text/css" href="nutrition.css">
  <script src="script.js"></script>
  <body>
  	<nav>
  		<ul>
  			<li><a href="account.php">Account Info</a></li>
  			<li><a href="friends.php">Inner Circle</a></li>
  			<li><a href="workout.php">Workouts</a></li>
  			<li><a href="signin.php?action=logout">Logout</a></li>
  		</ul>
  	</nav>  

  	<div id="headers">
  		<h1>Workout Tracker</h1>
  		<h4>Track your workouts. Socially.</h4>
  	</div>
  		
  	<div id="main">
  		
		<?php
			/* Force log in */
			if (empty($_SESSION['username'])) {
				echo '<div id="message"><h3>Error. You must be logged in to see this page.</br></h3>';
				echo '<h4>Click <a href=signin.php>here</a> to log in.</h4></div>';
			} else {

				$user = $_SESSION['username'];

				echo'<h2>Workout History</h2>';
				echo '<div id="display">';
				echo'<table><tr><th>Date</th><th>Activity</th><th>Duration</th><th>Calories Burned</th>
					<th>Weather</th><th>Notes</th></tr>';

				if(!$req = $mysqli->prepare("SELECT date, type, duration, calories, weather, 
					notes FROM workout WHERE username=? ORDER BY date DESC")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$req->bind_param("s", $user);
					if (!$req->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					$date = NULL;
					$type = NULL;
					$duration = NULL;
					$calories = NULL;
					$weather = NULL;
					$notes = NULL;
										
					if(!$req->bind_result($date, $type, $duration, $calories, $weather, $notes)) {
						echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
					}

					while ($req->fetch()) {
						if ($date != '0000-00-00') {
							echo '<tr><td>' . $date . '</td><td>' . $type . '</td><td>' . $duration .'</td>';
							echo '<td>' . $calories . '</td><td>' . $weather . '</td><td>' . $notes .'</td></tr>';
						}
					}
					echo '</table>';

					$req->close();
					$mysqli->close();
				}
			echo '</div>';

			echo '<form id="update" action="updateWork.php?key=workout" method="GET">
  			<input type="submit" value="Add/Update Workout"></form>';

  			echo '</div>';
		}

  		?>
  	
  </body>
</html>