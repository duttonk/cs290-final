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
  <head><title>Inner Circle</title></head>
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

  				echo '<div id="directionsF">';
  					echo '<p>Keep track of up to three friends\' most recent workouts!</p>';
  					echo '<p>Add, delete, or rearrange friends by clicking "Update" below.</p>';
  				echo '</div>';

  				echo '<div id="displayS">';
				echo '<h2>My Inner Circle</h2>';
				echo '<table><tr><th>Name</th><th>Image</th><th>Location</th></tr>';


				$friend1 = NULL;
				$friend2 = NULL;
				$friend3 = NULL;

				/* Get friend 1 */
				if (!$res = $mysqli->prepare("SELECT friend.username FROM friends f INNER JOIN 
					users user ON f.username=user.username INNER JOIN users friend ON 
					f.friend1=friend.username WHERE user.username=?;")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$res->bind_param("s", $user);
					if (!$res->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					if (!$res->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					if(!$res->bind_result($friend1)) {
						echo "Binding output parameters failed: (" . $res->errno . ")" . $res->error;
					}
					while ($res->fetch()) {
						$friend1;
					}

					$res->close();
				}

				/* Get friend 2 */
				if (!$res = $mysqli->prepare("SELECT friend.username FROM friends f INNER JOIN 
					users user ON f.username=user.username INNER JOIN users friend ON 
					f.friend2=friend.username WHERE user.username=?;")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$res->bind_param("s", $user);
					if (!$res->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					if (!$res->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					if(!$res->bind_result($friend2)) {
						echo "Binding output parameters failed: (" . $res->errno . ")" . $res->error;
					}
					while ($res->fetch()) {
						$friend1;
					}

					$res->close();
				}

				/* Get friend 3 */
				if (!$res = $mysqli->prepare("SELECT friend.username FROM friends f INNER JOIN 
					users user ON f.username=user.username INNER JOIN users friend ON 
					f.friend3=friend.username WHERE user.username=?;")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$res->bind_param("s", $user);
					if (!$res->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					if (!$res->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					if(!$res->bind_result($friend3)) {
						echo "Binding output parameters failed: (" . $res->errno . ")" . $res->error;
					}
					while ($res->fetch()) {
						$friend1;
					}

					$res->close();
				}

				/* Insert friends into table */
				$name = NULL;
				$image = NULL;
				$location = NULL;

				if ($friend1 != NULL) {
					echo '<tr>';
					if (!$res = $mysqli->prepare("SELECT name, image, location FROM user_info WHERE username=?")) {
						echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
					} else {
						$res->bind_param("s", $friend1);
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if(!$res->bind_result($name, $image, $location)) {
							echo "Binding output parameters failed: (" . $res->errno . ")" . $res->error;
						}
						while ($res->fetch()) {
							echo '<td>'.$name.'</td><td><img class="autoResizeImage" src="' . $image . '">
							</td><td>'.$location.'</td>';
						}
						echo '</tr>';

						$res->close();
					}
				}

				$name = NULL;
				$image = NULL;
				$location = NULL;

				if ($friend2 != NULL) {
					echo '<tr>';
					if (!$res = $mysqli->prepare("SELECT name, image, location FROM user_info WHERE username=?")) {
						echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
					} else {
						$res->bind_param("s", $friend2);
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if(!$res->bind_result($name, $image, $location)) {
							echo "Binding output parameters failed: (" . $res->errno . ")" . $res->error;
						}
						while ($res->fetch()) {
							echo '<td>'.$name.'</td><td><img class="autoResizeImage" src="' . $image . '">
							</td><td>'.$location.'</td>';
						}
						echo '</tr>';

						$res->close();
					}
				}

				$name = NULL;
				$image = NULL;
				$location = NULL;

				if ($friend3 != NULL) {
					echo '<tr>';
					if (!$res = $mysqli->prepare("SELECT name, image, location FROM user_info WHERE username=?")) {
						echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
					} else {
						$res->bind_param("s", $friend3);
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if(!$res->bind_result($name, $image, $location)) {
							echo "Binding output parameters failed: (" . $res->errno . ")" . $res->error;
						}
						while ($res->fetch()) {
							echo '<td>'.$name.'</td><td><img class="autoResizeImage" src="' . $image . '">
							</td><td>'.$location.'</td>';
						}
						echo '</tr>';

						$res->close();
					}
				}

				echo '</table></div>';
			

				/* Display most recent workout from each listed friend */
				echo '<div id="display"><h2>Most Recent Workouts</h2>';
				echo'<table><tr><th>Name</th><th>Date</th><th>Type</th>
					<th>Duration</th><th>Calories</th><th>Weather</th></tr>';

				$name = NULL;

				if ($friend1 != NULL) {
					echo '<tr>';
					if (!$res = $mysqli->prepare("SELECT name FROM user_info WHERE username=?")) {
						echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
					} else {
						$res->bind_param("s", $friend1);
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if(!$res->bind_result($name)) {
							echo "Binding output parameters failed: (" . $res->errno . ")" . $res->error;
						}
						while ($res->fetch()) {
							echo '<td>'.$name.'</td>';
						}
						
						$res->close();
					}				

					if(!$req = $mysqli->prepare("SELECT date, type, duration, calories, 
						weather FROM workout WHERE id IN (SELECT max(id) FROM workout WHERE username =
						(SELECT friend.username FROM friends f INNER JOIN users user ON f.username = 
						user.username INNER JOIN users friend ON f.friend1 = friend.username WHERE
						user.username=?));")) {
						echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
					} else {
						$req->bind_param("s", $user);
						if (!$req->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						
						$date = NULL;
						$type = NULL;
						$duration = NULL;
						$cal = NULL;
						$weather = NULL;
					
						if(!$req->bind_result($date, $type, $duration, $cal, $weather)) {
							echo "Binding output parameters failed: (" . $req->errno . ")" . $req->error;
						}

						while ($req->fetch()) {
							echo '<td>' . $date . '</td><td>' . $type .'</td><td>' . $duration . '</td>';
							echo '<td>' . $cal . '</td><td>' . $weather . '</td></tr>';
						}
						$req->close();

					}
				}


				$name = NULL;

				if ($friend2 != NULL) {
					echo '<tr>';
					if (!$res = $mysqli->prepare("SELECT name FROM user_info WHERE username=?")) {
						echo "Prepare failed: (" . $mysqli.errno . ")" . $mysqli->error;
					} else {
						$res->bind_param("s", $friend2);
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli.errno . ")" . $mysqli->error;
						}
						if(!$res->bind_result($name)) {
							echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
						}
						while ($res->fetch()) {
							echo '<td>'.$name.'</td>';
						}
						
						$res->close();
					}
					if(!$req = $mysqli->prepare("SELECT date, type, duration, calories, 
						weather FROM workout WHERE id IN (SELECT max(id) FROM workout WHERE username =
						(SELECT friend.username FROM friends f INNER JOIN users user ON f.username = 
						user.username INNER JOIN users friend ON f.friend2 = friend.username WHERE
						user.username=?));")) {
							echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
					} else {
						$req->bind_param("s", $user);
						if (!$req->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						
						$date = NULL;
						$type = NULL;
						$duration = NULL;
						$cal = NULL;
						$weather = NULL;
					
						if(!$req->bind_result($date, $type, $duration, $cal, $weather)) {
							echo "Binding output parameters failed: (" . $req->errno . ")" . $req->error;
						}

						while ($req->fetch()) {
							echo '<td>' . $date . '</td><td>' . $type .'</td><td>' . $duration . '</td>';
							echo '<td>' . $cal . '</td><td>' . $weather . '</td></tr>';
						}
						$req->close();
					}
				}


				$name = NULL;

				if ($friend3 != NULL) {
					echo '<tr>';
					if (!$res = $mysqli->prepare("SELECT name FROM user_info WHERE username=?")) {
						echo "Prepare failed: (" . $mysqli.errno . ")" . $mysqli->error;
					} else {
						$res->bind_param("s", $friend3);
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						if (!$res->execute()) {
							echo "Execute failed: (" . $mysqli.errno . ")" . $mysqli->error;
						}
						if(!$res->bind_result($name)) {
							echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
						}
						while ($res->fetch()) {
							echo '<td>'.$name.'</td>';
						}
						
						$res->close();
					}
					if(!$req = $mysqli->prepare("SELECT date, type, duration, calories, 
						weather FROM workout WHERE id IN (SELECT max(id) FROM workout WHERE username =
						(SELECT friend.username FROM friends f INNER JOIN users user ON f.username = 
						user.username INNER JOIN users friend ON f.friend3 = friend.username WHERE
						user.username=?));")) {
							echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
					} else {
						$req->bind_param("s", $user);
						if (!$req->execute()) {
							echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
						}
						
						$date = NULL;
						$type = NULL;
						$duration = NULL;
						$cal = NULL;
						$weather = NULL;
						
						if(!$req->bind_result($date, $type, $duration, $cal, $weather)) {
							echo "Binding output parameters failed: (" . $req->errno . ")" . $req->error;
						}

						while ($req->fetch()) {
							echo '<td>' . $date . '</td><td>' . $type .'</td><td>' . $duration . '</td>';
							echo '<td>' . $cal . '</td><td>' . $weather . '</td></tr>';
						}
						$req->close();
					}
				}

				echo '</table>';
					
				$mysqli->close();

				echo '</div><form id="update" action="updateFriends.php?key=friends" method="GET">';
  				echo '<input type="submit" value="Update Inner Circle"></form>';
			}

		?>
		
  	</div>
  </body>
</html>