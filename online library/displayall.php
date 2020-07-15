<?php

  require 'database.php';
  header("Content-Type: application/json");
  // session cookie http only
  ini_set("session.cookie_httponly", 1);

  $category = $_POST['category'];

//if the all category was selected, then it will disregard category and display all books owned by everyone, otherwise it will only display books in 1 category
if ($category == "All Books"){
  $stmt = $mysqli->prepare("select * from book");
  if(!$stmt){
      echo json_encode(array(
        "success" => false,
        "message" => $mysqli->error,
      ));
      exit;
  }
 }

else{

  $stmt = $mysqli->prepare("select * from book where category = ?");
  if(!$stmt){
      echo json_encode(array(
        "success" => false,
        "message" => $mysqli->error,
      ));
      exit;
  }
  $stmt->bind_param('s', $category);


}
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $books = array();
  // Make an array of all the resulting books that will be included in the jsonData that is passed back
  while($row = $result->fetch_assoc()){
     array_push($books, array(
       "title" => htmlentities($row['title']),
       "author" => htmlentities($row['author']),
       "username" => htmlentities($row['username']),
       "category" => htmlentities($row['category']),
       "year" => htmlentities($row['year']),
        "isbn"=> htmlentities($row['isbn']),
        "abs" =>htmlentities($row['abstract'])
     ));
  }
  echo json_encode(array(
    "success" => true,
    "exists" => true,
    "books" => $books
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

