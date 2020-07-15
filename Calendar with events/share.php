
  
<?php
require 'database.php';

header("Content-Type: application/json");
ini_set("session.cookie_httponly", 1);
session_start();
$username = $_SESSION['username'];
$newuser = $_POST['shared_user'];
$eventid = $_POST['original_id'];

$eventdate = substr($eventid, 6, 10);
//echo($eventdate);
$eventitle = substr($eventid, 17);
//echo($eventitle);

if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}


if ($username == $newuser){
echo json_encode(array(
        "success" => false,
        "message" => "you can't share this event with yourself!"
      ));
      exit;
}
else{
$stmt = $mysqli->prepare("select * from users where username =?"); //check to see if shared user exists
  if(!$stmt){
      echo json_encode(array(
        "success" => false,
        "message" => $mysqli->error,
      ));
      exit;
  }
  $stmt->bind_param('s', $newuser);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) { // indicates that user exists

$stmt2 = $mysqli->prepare("select time, category from events where title = ? AND date = ? AND user = ?");
if(!$stmt2){
      echo json_encode(array(
        "success" => false,
        "message" => $mysqli->error,
      ));
      exit;
  }

$stmt2->bind_param('sss', $eventitle, $eventdate, $username);
if (!$stmt2->execute()){
    echo json_encode(array(
      "success" => false,
      "message" => "Unable to add event! "
    ));
    exit;
}//finds the category and time of the event we want to share. If 1 and only 1 event exists, we know the event is valid and can be shared
  $result2 = $stmt2->get_result();
  if ($result2->num_rows == 1) {
    $events = array();

  while($row = $result2->fetch_assoc()){
     array_push($events, array(

       "time" => htmlentities($row['time']),

       "category" => htmlentities($row['category']),

     ));
//adds an asterisk to the end of the event title, indicating that it was shared
$eventitle2 = $eventitle." *";

$stmt3 = $mysqli->prepare("insert into events (title, date, time, user, category) values (?,?,?,?,?)");
if(!$stmt3){
        echo json_encode(array(
                "success" => false,
                "message" => "illegal!"
        ));
        exit;
}
$stmt3->bind_param('sssss', $eventitle2,$eventdate,$row['time'],$newuser,$row['category']) ;

if (!$stmt3->execute()){
    echo json_encode(array(
      "success" => false,
      "message" => "Unable to share event! ".$eventiid
    ));
}
else{
   echo json_encode(array("success" => true));
}
    $stmt3->close();
}

}

else{
echo json_encode(array("success" => false, "message" => $eventitle));
}

$stmt2->close();
}
  else {//user does not exist
    echo json_encode(array(
      "success" => false,
      "message" => "user not found"
    ));
  }
  $stmt->close();
exit;
}
?>