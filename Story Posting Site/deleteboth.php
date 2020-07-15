<?php

require 'database.php';

session_start();
$c_username = $_SESSION['username'];
$s_username = $_GET['suser'];
$story_id =  $_GET['sid'];

echo $c_username;
echo $s_username;
echo $story_id;

//selects list of users
$stmt = $mysqli->prepare("select username from story where story_id=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('i', $story_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();



//checks current logged in user and username of story, if they are different then it automatically redirects 
//back to the mainpage because you can only delete stories you yourself created.
if ($s_username!=$c_username){
    echo "You can only delete stories you created";
    header("Location: mainpage.php");
    exit;
}
else {
//first, it deletes the likes to the story
$stmt3 = $mysqli->prepare("delete from likestory where story_id = ? AND s_username = ?");
    if(!$stmt3){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt3->bind_param('is', $story_id, $s_username);
    $stmt3->execute();
    $stmt3->close();

//then it deletes all comments to the story
$stmt2 = $mysqli->prepare("delete from comments where story_id = ? AND s_username = ?");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt2->bind_param('is', $story_id, $s_username);
    $stmt2->execute();
    $stmt2->close();

//then it deletes the story itself
    $stmt1 = $mysqli->prepare("delete from story where story_id = ? AND username = ?");
    if(!$stmt1){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt1->bind_param('is', $story_id, $c_username);
    $stmt1->execute();
    $stmt1->close();
   header("Location: mainpage.php");
}

?>
