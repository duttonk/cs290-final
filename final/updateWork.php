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
  <head><title>Update</title></head>
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

        if (empty($_SESSION['username'])) {
          echo '<div id="message"><h3>Error. You must be logged in to see this page.</br></h3>';
          echo '<h4>Click <a href=signin.php>here</a> to log in.</h4></div>';
        } else {
          $user = $_SESSION['username'];

          echo '<div id="offset">';
          echo '<div id="directionsF"><h2>Directions:</h2>';
          echo '<p>To add a new workout, fill in the information. Every workout must have a date 
          and a duration.</p>';
          echo '<p>To update an existing workout, enter the date of the session you would like to 
          change along with any other new information. Just be sure you enter a duration.</p>';
          echo '<p>You may fill in the weather yourself, or use the box below to retrieve current
          local weather information for your US zip code.</p>';
          echo '</div></div>';

          echo '<table id="adds">';
          echo '<tr><td><div id="weather"><span>US Zip Code: </span><input id="newzip" type="text"></td>';
            echo '<td><input id="add" onclick="getWeather()" type="button" value="Get Current Weather"></td>';
            echo '<td><form action="addType.php"><input id="addSub" type="submit" value="Add Activity">';
          echo '</form></div></td></tr>';
          echo '</div>';
          echo '</table>';

          echo '<h2>Enter new information:</h2>';

          echo '<div id="update"><form id="updateAcct">';
            echo '<table><tr><td><span>Date of workout: YYYY-MM-DD</span></td>';
              echo '<td><input id="newWorkDate" type="date" autofocus></td></tr>';
            echo '<tr><td><span>Activity: </span></td>';
              echo '<td><select id="activity">';

            if (!$spec = $mysqli->prepare("SELECT DISTINCT type FROM type ORDER BY type;")) {
              echo "Prepare failed: (" . $mysqli.errno . ")" . $mysqli->error;
            }
            if (!$spec->execute()) {
              echo "Execute failed: (" . $mysqli.errno . ")" . $mysqli->error;
            }

            $listSpec = NULL;
            if(!$spec->bind_result($listSpec)) {
              echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
            }

            /* Add returned items to list in menu */
            while ($spec->fetch()) {
              echo '<option value="' . $listSpec . '">' . $listSpec . '</option>';
            }
       
            echo '</td></select></tr>';
            echo '<tr><td><span>Calories Burned: </span></td><td><input id="cal" type="number"></td></tr>';
            echo '<tr><td><span>Hours: </span></td><td><input id="hrs" type="number"></td></tr>';
            echo ' <tr><td><span>Minutes: </span></td><td><input id="min" type="number"></td></tr>';
          
            echo '<tr><td><span>Weather: </span></td>';
              echo '<td><div id="returnWeather"><input id="curWeather" type="text">';
              echo '<input id="hiding" type="hidden"></td></tr>';
            echo '<tr><td>Notes: </span></td><td><input id="notes" type="text"></td></tr>';
            echo '</table></form>';

            echo '</div>';

            echo '<div id="updateButton"><input onclick="workUpdate()" type="button" value="Add Workout"></div>';

            echo '</div>';
          }
      ?>
  </body>
</html>