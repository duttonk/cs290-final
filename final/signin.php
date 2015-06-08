<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout') {
	session_unset();
	session_destroy();
	header("location: signin.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
  <head><title>Sign In</title></head>
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

  	<div id="buffer"></div>
  	<div id="backdrop">
  	<div id="loginform">
  		
  		<form action='#' method="POST" id="logform" name="logform">
  			<table>
  				<th colspan="2">User Log In</th>
  				<tr><td colspan="2"><input type="radio" name="type" value="new" checked><span>New User</span>
 				  <input type="radio" name="type" value="existing"><span>Existing User</span></td></tr>
  				<td><span>User name: </span></td>
  				<td><input id="user" type="text" name="user"></td></tr>

  				<td><span>Password: </span></td>
  				<td><input id="password1" type="password" name="pwd"></td></tr>
 	 			<tr><td></td><td><input onclick="checkForm()" type="button" value="Submit"></td></tr>
 	 		</table>
 	 	</form>
  	</div>
  	</div>
  	<div id="buffer"></div></br>

  	<div id="logout"><input onclick="logout()" type="button" value="Log Out">
	  </div>
		
  </body>
</html>
