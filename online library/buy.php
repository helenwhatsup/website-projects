<?php
    require 'database.php';
    session_start();

//all the information we need to add a book to our buy list
    $username = $_GET['username'];
    $title =  $_GET['title'];
    $author = $_GET['author'];
    $year = $_GET['year'];
    $category = $_GET['category'];

    $user = $_SESSION['username'];
//    echo $user;

  //inserts stuff from textboxes on main page (all the book info) into our buy list sql table for stories 
if ($username == $user){
    $stmt = $mysqli->prepare("insert into buy(username, title, author,year, category) values (?,?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sssss', $username, $title, $author, $year,$category);
    if (!$stmt->execute()){
        echo "Fail to post";
    }

    $stmt->close();
}
    header("Location: index.php");
    ?>

