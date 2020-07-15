<!DOCTYPE html>
<html>
<head><title>View Specific Profile</title></head>
<body>

<link rel="stylesheet" href="css/main.css" />

<h1> View Specific User Profile </h1>

<?php
 require 'database.php';
 session_start();
 $user = $_SESSION['username'];
 $viewinguser = $_GET['user'];

echo " Currently Viewing User ".$viewinguser;
echo "<br>";
//first displays all the book user //OWN 
 $stmt = $mysqli->prepare("select title, author, year,category from book where username = ?");

 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->bind_param('s',$viewinguser);
 $stmt->execute();
 $stmt->bind_result( $title, $author, $year, $category) ;



echo("<h3>List of book user have owned </h3>");
 while($stmt->fetch()){
    echo"_____________________________________________________________________________________________________________________________";
    echo "<br />";
    echo " Title: ".$title;
    echo "<br />";
    echo " Author: ".$author;
    echo "<br />";
    echo "Year: ".$year;
    echo "<br />";
    echo "category: ".$category;
    echo "<br />";
echo"__________________________________________________________________________________________________________________________________________________";

   // echo "<a href=readmore.php?user=$viewinguser>READ MORE</a>";

}
$stmt->close();



//next displays all the book user //want to buy
 $stmt2 = $mysqli->prepare("select title, author, year,category from buy where username = ?");
 if(!$stmt2)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt2->bind_param('s',$viewinguser);
 $stmt2->execute();
 $stmt2->bind_result( $title, $author, $year, $category) ;

echo "<br /><br />";
echo("<h3>List of book user want to buy</h3> ");
while($stmt2->fetch()){
    echo"_____________________________________________________________________________________________________________________________________________";
    echo "<br />";
    echo " Title: ".$title;
    echo "<br />";
    echo " Author: ".$author;
    echo "<br />";
    echo "Year: ".$year;
    echo "<br />";
    echo "category: ".$category;
    echo "<br />";
    echo"_________________________________________________________________________________________________________________________________________________________";
   // echo "<a href=readmore.php?user=$viewinguser>READ MORE</a>";
}

$stmt2->close();


?>

<form action = "viewprofiles.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>

</body>
</html>

