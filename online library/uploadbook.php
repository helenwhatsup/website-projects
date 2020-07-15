<?php
    require 'database.php';
    session_start();
    $username = $_GET['username'];
    $title =  $_GET['title'];
    $author = $_GET['author'];
    $year = $_GET['year'];
    $category = $_GET['category'];
    $isbn=$_GET['isbn'];
    $abstract=$_GET['abstract'];

    $user = $_SESSION['username'];
//    echo $user;

if(!hash_equals($_SESSION['token'], $_GET['token'])){
        die("Request forgery detected");
}

  //inserts stuff from textboxes on main page (all the story info) into our sql table for stories 
if ($username == $user){
    $stmt = $mysqli->prepare("insert into book(username, title, author,year, category,isbn,abstract) values (?,?, ?, ?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sssssss', $username, $title, $author, $year,$category,$isbn,$abstract);
    if (!$stmt->execute()){
        echo "Fail to post";
    }

    $stmt->close();
}
else{
        echo "usernames don't match!";
}

    header("Location: index.php");
    ?>
