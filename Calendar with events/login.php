<?php



require 'database.php';
header("Content-Type: application/json");

$username = (String)$_POST['username'];
$password = (String)$_POST['pass'];
$stmt = $mysqli->prepare("select COUNT(*), username, password from users where username=?");

if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($cnt, $user, $hashedPass);
$stmt->fetch();
$stmt->close();

if(password_verify($password, $hashedPass) ){
        session_start();
        ini_set("session.cookie_httponly", 1);
        $_SESSION['username'] = $username;
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
        echo json_encode(array(
                "success" => true,
		"token" => $_SESSION['token']
        ));
        exit;
}
else{

        echo json_encode(array(
                "success" => false,
                "message" => "Password or username wrong"
        ));
        exit;
}
?>


