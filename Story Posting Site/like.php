<?php
require 'database.php';
session_start();

$currentuser = $_SESSION['username'];
$story_id = $_GET['sid'];
$username = $_GET['suser'];
echo $story_id;


//inserts like into the like table, this ensures no duplicated likes
$stmt2 = $mysqli->prepare("insert into likestory(liker, s_username, story_id) values (?, ?, ?)");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('sss',$currentuser, $username, $story_id);
    if (!$stmt2->execute()){
        echo "Fail to like";
    }
//if the like was successful, increase the like count by 1 in the story table
    else{
        $stmt = $mysqli->prepare("update story set numlikes=numlikes+1 where story_id=? AND username = ? ");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            echo "reached";
            exit;
        }

$stmt->bind_param('ss', $story_id, $username);
$stmt->execute();

}
    $stmt2->close();
    header("Location: mainpage.php");
?>