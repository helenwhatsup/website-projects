<?php

  require 'database.php';
  header("Content-Type: application/json");
  // session cookie http only
  ini_set("session.cookie_httponly", 1);
  session_start();
  $username = $_SESSION['username'];
  $date = $_POST['date'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $category = $_POST['category'];



  $date2 = strval($year)."-".strval($month)."-".strval($date);

  $cdate = date('Y-m-d', strtotime($date2));

//if the all category was selected, then it will disregard category and display all events, otherwise it will only display events in 1 category
if ($category == "All"){
  $stmt = $mysqli->prepare("select * from events where user =? and date=?");
  if(!$stmt){
      echo json_encode(array(
        "success" => false,
        "message" => $mysqli->error,
      ));
      exit;
  }
  $stmt->bind_param('ss', $username, $cdate);
 }

else{

  $stmt = $mysqli->prepare("select * from events where user =? and date=? and category = ?");
  if(!$stmt){
      echo json_encode(array(
        "success" => false,
        "message" => $mysqli->error,
      ));
      exit;
  }
  $stmt->bind_param('sss', $username, $cdate, $category);


}
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $events = array();
  // Make an array of all the resulting events that will be included in the jsonData that is passed back
  while($row = $result->fetch_assoc()){
     array_push($events, array(
       "title" => htmlentities($row['title']),
       "time" => htmlentities($row['time']),
       "user" => htmlentities($row['user']),
       "category" => htmlentities($row['category']),
       "date" => htmlentities($row['date'])
     ));
  }
  echo json_encode(array(
    "success" => true,
    "exists" => true,
    "events" => $events
  ));
  exit;
  }
  else {
    echo json_encode(array(
      "success" => true,
      "exists" => false
    ));
  }
  $stmt->close();

?>

