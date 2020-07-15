<? php
require 'database.php';

header("Content-Type: application/json");

ini_set("session.cookie_httponly", 1);

session_start();
$username = $_SESSION['username'];

$title = $_POST['title'];
$date = $_POST['date'];
$time = $_POST['time'];
$notes = $_POST['notes'];


if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}


$stmt = $mysqli->prepare("insert into events (title, date, time, user, category) values (?, ?, ?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
  // Check that a title exists for the event. If date and time are blank, then the date will be '0000-00-00 00:00:00'
if (strlen($title)>0){
    $stmt->bind_param('sssss', $title, $date, $time, $username, $notes);

    if (!$stmt->execute()){
    echo json_encode(array(
      "success" => false,
      "message" => "Unable to add event!"
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
      "message" => "Event invalid"
    ));
$stmt->close();
    exit;
}
?>

