<?php
require 'database.php';
session_start();

$currentuser = $_SESSION['username'];
$story_id = $_GET['sid'];
$username = $_GET['suser'];
echo $story_id;


//first finds a count to see if a user has liked a post
$stmt1 = $mysqli->prepare("select count(*) from likestory where liker = ? AND s_username = ? AND story_id = ?");
if(!$stmt1){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
$stmt1->bind_param('ssi', $currentuser, $username, $story_id);
$stmt1->execute();
$stmt1->bind_result($totallikesize);
while($stmt1->fetch()){
    printf("%s<br />",
    htmlspecialchars("Total Likes Size:".$totallikesize));
}

//proceeds to delete any record where the user has liked the post

$stmt2 = $mysqli->prepare("delete from likestory where liker = ? AND s_username = ? AND story_id = ?");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('sss',$currentuser, $username, $story_id);
    if (!$stmt2->execute()){
        echo "Fail to dislike";
    }

    else{
//find the new count to see if a user has liked a post, if the count went down, then a record was successfully deleted and we can decrease numlikes by 1
$stmt3 = $mysqli->prepare("select count(*) from likestory where liker = ? AND s_username = ? AND story_id = ?");
if(!$stmt3){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
$stmt3->bind_param('ssi', $currentuser, $username, $story_id);
$stmt3->execute();
$stmt3->bind_result($totallikesize2);
while($stmt3->fetch()){
    printf("%s<br />",
    htmlspecialchars("New Total Likes Size:".$totallikesize2));
}



if ($totallikesize2 < $totallikesize){

        $stmt = $mysqli->prepare("update story set numlikes=numlikes-1 where story_id=? AND username = ? ");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    echo "reached";
    exit;
}

$stmt->bind_param('ss', $story_id, $username);
$stmt->execute();
}


}

    $stmt2->close();
    header("Location: mainpage.php");
?>
