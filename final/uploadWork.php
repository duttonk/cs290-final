<?php
ini_set('display_errors', 'On');
include 'info2.php';
session_start();

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
}

var_dump($_FILES);
var_dump($_REQUEST);
/* Source: http://www.w3schools.com/php/php_file_upload.asp */
/* Set file path */
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

/* Check if image file is a actual image or fake image */
if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}
}

/* Check if file already exists - link with message*/
if (file_exists($target_file)) {
	echo '<div id="message"><p>File already exists.</p>
	 	<p>The existing version will be linked to your profile.</p>
	 	<p>If it is not your photo, change the file name of your 
			image and try again.</p></div>';
		$uploadOk = 2;
}

/* Check file size */
if ($_FILES["fileToUpload"]["size"] > 500000) {
	$uploadOk = 0;
}

/* Allow certain file formats */
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	$uploadOk = 0;
}

/* Check if $uploadOk is set to 0 by an error */
if ($uploadOk == 0) {
	echo '<div id="message"><p>File not uploaded. Possible problems:</p>
	<p>  - File too large </p>    				
	<p>  - File is not a JPG, JPEG, PNG or GIF image</p></div>';

/* if everything is ok, try to upload file */
} else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		if ($uploadOk == 1) {
			echo '<div id="message"><span>The file '. basename( $_FILES["fileToUpload"]["name"]). 
     			  ' has been uploaded.</span></div>';
		}

		/* Save path in table */
		if (!$stmt = $mysqli->prepare("UPDATE user_info SET image = ? WHERE username = ?;")) { 
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		} else {
			$stmt->bind_param("ss", $target_file, $user);
			$stmt->execute();
			$stmt->close();
			$mysqli->close();
		}

	} else {
   		echo '<div id="message"><span>Sorry, there was an error uploading your file.</span></div>';
	}
}


?>