<?php

require 'database.php';

header("Content-Type: application/json"); // We are sending a JSON response

ini_set("session.cookie_httponly", 1);
session_start();

$username = $_SESSION['username'];


//similar to how we used javascript to modify sql lists in module 5, I am doing it here
//Variables can be accessed as such and is equivalent to what I previously did with $_POST['username'] and $_POST['password']
$title = $_POST['title'];
$author = $_POST['author'];
$user = $_POST['user'];
$category = $_POST['category'];
$year = $_POST['year'];
$list = $_POST['list'];
$isbn = $_POST['isbn'];
$abstract = $_POST['abstract'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}

//if list value is 1, we add to books owned list
if ($list == 1){
$stmt = $mysqli->prepare("insert into book(username, title, author,year, category, isbn, abstract) values (?,?, ?, ?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sssssss', $username, $title, $author, $year,$category, $isbn, $abstract);
    if (!$stmt->execute()){
//        echo "Fail to post";
    echo json_encode(array(
      "success" => false,
      "message" => "Unable to add book!".$isbn
    ));
$stmt->close();
    }
else{
    $stmt->close();
echo json_encode(array(
      "success" => true));
}
}
//if list value is 2, we add to books that a user wants to buy
else if ($list == 2){
$stmt = $mysqli->prepare("insert into buy(username, title, author,year, category) values (?,?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sssss', $username, $title, $author, $year,$category);
    if (!$stmt->execute()){
//        echo "Fail to post";
    echo json_encode(array(
      "success" => false,
      "message" => "Unable to add book!"
    ));
$stmt->close();
    }
else{
    $stmt->close();
echo json_encode(array(
      "success" => true));
}

}

exit;

?>

