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
      <h2>Update Inner Circle</h2>
      <div id="displayUI">

        <?php
          /* Force log in */
          if (empty($_SESSION['username'])) {
            echo '<div id="message"><h3>Error. You must be logged in to see this page.</br></h3>';
            echo '<h4>Click <a href=signin.php>here</a> to log in.</h4></div>';
          } else {
            $user = $_SESSION['username'];
          }
        ?>

        <table>
          <tr>
            <td><span><strong>Friend 1</strong></span></td>
            <td><span>

              <?php

                if (!$spec = $mysqli->prepare("SELECT name FROM user_info WHERE 
                  username = (SELECT friend.username FROM friends f INNER JOIN 
                  users user ON f.username=user.username INNER JOIN users friend 
                  ON f.friend1=friend.username WHERE user.username = ?);")) {
                    echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
                } else {
                  $spec->bind_param("s", $user);
                  $spec->execute();

                  $friend = NULL;
                  if(!$spec->bind_result($friend)) {
                    echo "Binding parameters failed!";
                  }
                  while ($spec->fetch()) {
                    $friend;
                  }
                  echo $friend;
                  $spec->close();
                }
                
              ?>
            </span></td>
            <td><select id="replace1">
              <?php
                $name = NULL;
                $username = NULL;
                $location = NULL;

                if (!$spec = $mysqli->prepare("SELECT username, name, location FROM user_info;")) {
                  echo "Prepare failed: (" . $mysqli.errno . ")" . $mysqli->error;
                }
                if (!$spec->execute()) {
                  echo "Execute failed: (" . $mysqli.errno . ")" . $mysqli->error;
                }

                if(!$spec->bind_result($username, $name, $location)) {
                  echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
                }

                /* Add returned items to list in menu */
                while ($spec->fetch()) {
                  echo '<option value="' . $username . '">' . $name . ', ' . $location . '</option>';
                }
                echo '<option value="NULL">Delete</option>';
        ?>

            </select></td>
            <td><div id="updateButtonF"><input onclick="updateFriend1()" type="button" value="Update"></div>
            </td></tr>
          
          <tr>
            <td><span><strong>Friend 2</strong></span></td>
            <td><span>

              <?php

                if (!$spec = $mysqli->prepare("SELECT name FROM user_info WHERE 
                  username = (SELECT friend.username FROM friends f INNER JOIN 
                  users user ON f.username=user.username INNER JOIN users friend 
                  ON f.friend2=friend.username WHERE user.username = ?);")) {
                    echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
                } else {
                  $spec->bind_param("s", $user);
                  $spec->execute();

                  $friend = NULL;
                  if(!$spec->bind_result($friend)) {
                    echo "Binding parameters failed!";
                  }
                  while ($spec->fetch()) {
                    $friend;
                  }
                  echo $friend;
                  $spec->close();
                }
                
              ?>
            </span></td>
            <td><select id="replace2">
              <?php
                $name = NULL;
                $username = NULL;
                $location = NULL;

                if (!$spec = $mysqli->prepare("SELECT username, name, location FROM user_info;")) {
                  echo "Prepare failed: (" . $mysqli.errno . ")" . $mysqli->error;
                }
                if (!$spec->execute()) {
                  echo "Execute failed: (" . $mysqli.errno . ")" . $mysqli->error;
                }

                if(!$spec->bind_result($username, $name, $location)) {
                  echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
                }

                /* Add returned items to list in menu */
                while ($spec->fetch()) {
                  echo '<option value="' . $username . '">' . $name . ', ' . $location . '</option>';
                }
                echo '<option value="NULL">Delete</option>';
        ?>

            </select></td>
            <td><div id="updateButtonF"><input onclick="updateFriend2()" type="button" value="Update"></div>
            </td>
          </tr>

          <tr>
            <td><span><strong>Friend 3</strong></span></td>
            <td><span>

              <?php

                if (!$spec = $mysqli->prepare("SELECT name FROM user_info WHERE 
                  username = (SELECT friend.username FROM friends f INNER JOIN 
                  users user ON f.username=user.username INNER JOIN users friend 
                  ON f.friend3=friend.username WHERE user.username = ?);")) {
                    echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
                } else {
                  $spec->bind_param("s", $user);
                  $spec->execute();

                  $friend = NULL;
                  if(!$spec->bind_result($friend)) {
                    echo "Binding parameters failed!";
                  }
                  while ($spec->fetch()) {
                    $friend;
                  }
                  echo $friend;
                  $spec->close();
                }
                
              ?>
            </span></td>
            <td><select id="replace3">
              <?php
                $name = NULL;
                $username = NULL;
                $location = NULL;

                if (!$spec = $mysqli->prepare("SELECT username, name, location FROM user_info;")) {
                  echo "Prepare failed: (" . $mysqli.errno . ")" . $mysqli->error;
                }
                if (!$spec->execute()) {
                  echo "Execute failed: (" . $mysqli.errno . ")" . $mysqli->error;
                }

                if(!$spec->bind_result($username, $name, $location)) {
                  echo "Binding output parameters failed: (" . $all->errno . ")" . $all->error;
                }

                /* Add returned items to list in menu */
                while ($spec->fetch()) {
                  echo '<option value="' . $username . '">' . $name . ', ' . $location . '</option>';
                }
                echo '<option value="NULL">Delete</option>';
        ?>

            </select></td>
            <td><div id="updateButtonF"><input onclick="updateFriend3()" type="button" value="Update"></div>
            </td>
          </tr>

        </table>

      </div><form id="update" action="friends.php" method="GET">
          <input type="submit" value="Back to Inner Circle"></form></div>

    </div>

  </body>
</html>