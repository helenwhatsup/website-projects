<?php

require 'database.php';
include 'editcomment.php';

$current_user = $_SESSION['username'];
$s_username = $_GET['suser'];
$story_id =  $_GET['sid'];
$comment_id = $_GET['comm'];



if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Error editing");
}

else{
        //takes comment posted in comment.php
        $update_comment = $_POST['comment'];
        echo $update_comment;
        //updates a comment in the sql comments table
        $stmt = $mysqli->prepare("update comments set comment  = ? where story_id = ? AND c_username = ? AND s_username = ? AND comment_id = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('sisss', $update_comment, $story_id, $current_user, $s_username, $comment_id);
        if (!$stmt->execute()){
            echo "Fail to update :( ";
        }
        else{
            echo "comment updated!";
        }


        $stmt->fetch();
        $stmt->close();
}
        header("Location: mainpage.php");
?>