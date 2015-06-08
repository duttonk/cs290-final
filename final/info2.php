<?php

/* Sensitive info removed 
$host = ;
$user = ;
$pass = ;
$db = ;
*/ 

/* Source: http://php.net/manual/en/function.password-hash.php */
/* Randomizes the hash used to protect passwords - used in pass.php */
$timeTarget=0.05;
$cost = 8;

do {
	$cost++;
	$start = microtime(true);
	password_hash("test", PASSWORD_BCRYPT, ["cost"=>$cost]);
	$end = microtime(true);
} while (($end - $start) < $timeTarget);

$options = [
	'cost' => $cost,
	'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];

?>
