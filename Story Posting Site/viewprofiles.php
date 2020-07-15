<!DOCTYPE html>
<html>
<head><title>ViewFiles</title></head>
<body>
<style>
    body{font-size:100%; background-color:#eaf0bb;
    font-weight: lighter;
    font-family: Arial;
    font-size: 30px;
     text-align: center
      };

    form{ display:inline-block};

</style>


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

echo("View Users<br />");
echo "<br /><br />";
 while($stmt->fetch()){
    echo "<br /><br />";
    echo $username;
    echo "<a href=viewspecprof.php?user=$username>View this user</a>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";

}
$stmt->close();



?>

<form action = "mainpage.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>

</body>
</html>
