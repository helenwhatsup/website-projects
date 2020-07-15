<?php
    require 'database.php';
    session_start();
    $username = $_GET['username'];
    $story_id =  $_GET['story_id'];
    $story_title = $_GET['storytitle'];
    $story_content = $_GET['content'];
    $link = $_GET['link'];

    $user = $_SESSION['username'];
//    echo $user;

  //inserts stuff from textboxes on main page (all the story info) into our sql table for stories 
if ($username == $user){
    $stmt = $mysqli->prepare("insert into story(username, story_id, story_title,story_content, link) values (?,?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sssss', $username, $story_id, $story_title, $story_content,$link);
    if (!$stmt->execute()){
        echo "Fail to post";
    }

    $stmt->close();

}
    header("Location: mainpage.php");
    ?>