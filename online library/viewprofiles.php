<!DOCTYPE html>
<html>
<head><title>ViewFiles</title></head>
<body>
<link rel="stylesheet" href="css/main.css" />
<h1> View User's Profile </h1>
<?php
 require 'database.php';
 session_start();
 $user = $_SESSION['username'];
//will show a list of all registered users that we get from the SQL
 $stmt = $mysqli->prepare("select username from users");

 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->execute();
 $stmt->bind_result( $username) ;

 while($stmt->fetch()){
//attaches an href that leads to a link for the specific profile with the user's 2 lists
    echo $username;
    echo "<a href=viewspecprof.php?user=$username><h4>View this user</h4></a>";
    echo "<br /><br />";

}
$stmt->close();

?>
<form action = "index.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>

</body>
</html>
