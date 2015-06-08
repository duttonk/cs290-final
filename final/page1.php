<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

echo "HELLO " . $_SESSION['username'];

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

  	<?php

  	?>
  </body>
</html>