<?php
require 'database.php';
$user_guess = $_POST['username'];
$pwd_guess = $_POST['password'];
//pretty much the same as previous modules 
$stmt = $mysqli->prepare("select COUNT(*), username, password from users where username=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $user_guess);
$stmt->execute();
$stmt->bind_result($cnt, $username, $hashedPass);
$stmt->fetch();
$stmt->close();

if(password_verify($pwd_guess, $hashedPass)){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
	header("Location: index.php");
	exit;
} else{
	 echo "login failed, passwords dont match!";
	exit;
}
?>
