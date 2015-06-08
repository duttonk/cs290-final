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
  <head><title>Account</title></head>
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

				echo '<h2>User Account Information</h2>';
				echo '<div id="display">';
				echo'<table><tr><th>Name</th><th>Image</th><th>Gender</th><th>Date of Birth</th>
					<th>Location</th><th>Inspiration</th></tr>';

				if(!$req = $mysqli->prepare("SELECT name, image, gender, dob, location, 
					inspiration FROM user_info WHERE username=?")) {
					echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
				} else {
					$req->bind_param("s", $user);
					if (!$req->execute()) {
						echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
					}
					$name = NULL;
					$image = NULL;
					$gender = NULL;
					$dob = NULL;
					$location = NULL;
					$inspiration = NULL;
					
					if(!$req->bind_result($name, $image, $gender, $dob, $location, $inspiration)) {
						echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
					}

					while ($req->fetch()) {
						/* Image sources: 
						https://www.daniweb.com/web-development/php/threads/162230/saving-mage-in-a-path-instead-of-storing-the-real-image-in-mysql
						http://stackoverflow.com/questions/17642539/shrink-image-size-to-fit-table-cell-which-works-in-all-browsers */
						echo '<tr><td>' . $name . '</td>';
						echo '<td><img class="autoResizeImage" src="' . $image . '"></td><td>' . $gender .'</td>';
						echo '<td>' . $dob . '</td><td>' . $location . '</td><td>' . $inspiration .'</td></tr>';
					}
					echo '</table>';

					$req->close();
					$mysqli->close();
				}
			echo '</div>';

			echo '<form id="update" action="update.php?key=account" method="GET">
  			<input type="submit" value="Update Account Info"></form>';

  			echo '</div>';
		}

  		?>

  		
  	
  </body>
</html>