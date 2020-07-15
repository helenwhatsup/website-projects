<?php
require 'database.php';

header("Content-Type: application/json");
ini_set("session.cookie_httponly", 1);

session_start();
$username = $_SESSION['username'];

$title = $_POST['title'];
$time = $_POST['time'];
$notes = $_POST['notes'];
$eventid = $_POST['original_id'];

$eventdate = substr($eventid, 5, 15);

$eventitle = substr($eventid, 16);



if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}

$stmt = $mysqli->prepare("update events set title = ?, time = ?, category = ? WHERE title = ? AND date = ? AND user = ?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
  // edits time, title, and category for an event
if (strlen($title)>0){
    $stmt->bind_param('ssssss', $title, $time, $notes, $eventitle, $eventdate, $username);

    if (!$stmt->execute()){
    echo json_encode(array(
      "success" => false,
      "message" => "Unable to edit event!"
    ));

}
else{
   echo json_encode(array("success" => true));
}

    $stmt->close();
    exit;
}

else{
 echo json_encode(array(
      "success" => false,
      "message" => "Event edit invalid"
    ));
$stmt->close();
    exit;
}
?>
