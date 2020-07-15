<?php

require 'database.php';
include 'comment.php';
$comment = $_POST['name'];
$commID = $_POST['ID'];


//inserting our comment from comment.php into the sql table of comments
 $stmt = $mysqli->prepare("insert into comments(c_username, s_username, comment,story_id, comment_id) values (?,?, ?, ?,?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sssss', $c_username, $s_username, $comment, $story_id, $commID);
    if (!$stmt->execute()){
        echo "Fail to post";
    }
    else{
        echo "comment posted!";
        }

    $stmt->close();


?>