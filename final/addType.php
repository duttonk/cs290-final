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
  <head><title>Add Type</title></head>
  <link rel="stylesheet" type="text/css" href="nutrition.css">
  <script src="script.js"></script>
  <body>
  	<nav>
  		<ul>
  			<li><a href="account.php">Account Info</a></li>
  			<li><a href="friends.php">Friends</a></li>
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
  		    echo '<h2>Add New Activity</h2>';
          echo '<div id="update"><form id="updateAcct">';
          echo '<span>Activity: </span><input id="activity" type="text" required autofocus>';
          echo '<div id="updateButton"><input onclick="addActivity()" type="button" value="Add"></div>';
          echo '</form>';
          echo '</div>';
        }
      ?>

    </div>
  </body>
</html>