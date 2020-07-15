<?php

require 'database.php';
include 'editstory.php';
$update = $_POST['content'];

    echo $s_username;
    echo "<br>";
    echo $story_id;
    echo "<br>";
    echo $update;

if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Error editing. Tokens differ");
}

else{

//takes in posted story content and sends it to the sql story table
$stmt = $mysqli->prepare("update story set story_content = ? where story_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('si', $update, $story_id);
if (!$stmt->execute()){
    echo "Fail to update :( ";
}


$stmt->fetch();
$stmt->close();


header("Location: mainpage.php");


}
?>