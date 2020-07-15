<!DOCTYPE html>
<html>
<head><title>Read More</title></head>
<body>

<link rel="stylesheet" href="css/main.css" />

<?php
 require 'database.php';
 session_start();
// session_start();
 $username1 = $_SESSION['username'];
 $title =  $_GET['title'];
 $author = $_GET['bauthor'];

echo "More info on ".$title." by ".$author;
echo "<br><br>";
//takes isbn and abstract from a specific book in the database and displays it
 $stmt = $mysqli->prepare("select isbn, abstract from book where username = ? AND title = ? AND author = ?");
 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->bind_param('sss', $username1, $title, $author);
 $stmt->execute();
 $stmt->bind_result($isbn, $abstract);
 echo "<br /><br />";
 while($stmt->fetch()){
    echo "ISBN:".$isbn;
    echo "<br /><br />";
    echo "Abstract:";
    echo $abstract;
    echo "<br /><br />";
}
$stmt->close();


?>

<form action = "index.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>

</body>
</html>


