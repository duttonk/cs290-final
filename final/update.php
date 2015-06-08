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

        /* Force log in */
        if (empty($_SESSION['username'])) {
          echo '<div id="message"><h3>Error. You must be logged in to see this page.</br></h3>
            <h4>Click <a href=signin.php>here</a> to log in.</h4></div>';
        } else {
          $user = $_SESSION['username'];

          echo '<h2>Enter updated information:</h2>';

          /* Source: http://www.w3schools.com/php/php_file_upload.asp */
          echo '<form id="photo" method="post" enctype="multipart/form-data" action="upload.php">
            <table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
            <tr>
              <td>
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                <input name="fileToUpload" type="file" id="fileToUpload">
              </td>
              <td>
                <input name="submit" type="submit" class="box" id="upload" value=" Upload Image">
              </td>
            </tr>
            </table>
            </form>



          <div id="update"><form id="updateAcct" action="updateAcct.php" method="POST">
            <table><tr><td><span>Name: </span></td><td><input id="newName" type="text" name="name" autofocus>
            </td></tr>
            <tr><td><span>Gender: </span></td><td><select id="gender" name="gender">
              <option value=""></option>
              <option value="M">Male</option>
              <option value="F">Female</option></select></td></tr>
            <tr><td><span>Date of Birth: YYYY-MM-DD</span></td>
              <td><input id="newDOB" type="date" name="dob"></td></tr>
            <tr><td><span>Location: </span></td><td><input id="newLoc" type="text" name="loc"></td></tr>
            <tr><td><span>Inspirational Quote: </span></td>
              <td><input id="newQuote" type="text" name="inspiration"></td></tr>
            </table></form></div>

          <div id="updateButton"><input onclick="acctUpdate()" type="button" value="Update Account Info"></div>
         <div id="updateButton"><input onclick="backtoaccount()" type="button" value="Back to Account"></div>';
        }

      ?>

    </div>
  </body>
</html>