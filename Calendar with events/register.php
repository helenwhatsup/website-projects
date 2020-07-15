<?php


require 'database.php';
header("Content-Type: application/json");
ini_set("session.cookie_httponly", 1);

$userName = (String)$_POST['username'];
$password = (String)$_POST['pass'];
//hashes the password
$addPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
  // Check the username that was entered to make sure that it is not a duplicate, and that both the username and password are nonempty string

if (strlen($userName) > 0 && strlen($password)> 0){

    $stmt->bind_param('ss', $userName, $addPassword);

    if (!$stmt->execute()){

    echo json_encode(array(
      "success" => false,
      "message" => "Username already exists"
    ));

}
else{
   echo json_encode(array("success" => true));
}

    $stmt->close();
    exit;
}

else{
 echo json_encode(array(
      "success" => false,
      "message" => "Username/password invalid"
    ));
$stmt->close();
    exit;
}
?>

