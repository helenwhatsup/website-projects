<?php

require 'database.php';

session_start();
$comm_id = $_GET['comm'];
$s_username = $_GET['suser'];
$story_id =  $_GET['sid'];

echo $c_username;
echo $s_username;
echo $story_id;
//delete a specific comment that a user made
$stmt2 = $mysqli->prepare("delete from comments where story_id = ? AND s_username = ? AND comment_id = ?");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt2->bind_param('isi', $story_id, $s_username, $comm_id);
    $stmt2->execute();
    $stmt2->close();
    header("Location: mainpage.php");




?>