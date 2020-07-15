<!DOCTYPE html>
<html>
<head><title>View Your Comments</title></head>
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
 //gets all the comments made by a user (returns the story and the comment)
 $stmt = $mysqli->prepare("select s_username,comment,story_id,comment_id from comments where c_username = ?");

 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->bind_param('s',$user);
 $stmt->execute();
 $stmt->bind_result( $s_username,$comment, $story_id, $comment_id) ;

echo("View Comments<br />");
echo "<br /><br />";
 while($stmt->fetch()){
    echo "<br /><br />";
    echo "*Story User ".$s_username." <br /><br /> ";
    echo "comment: ".$comment."  ";
    echo "<br /><br />";
    echo "story id:".$story_id;
    echo "<a href=editcomment.php?sid=$story_id&suser=$s_username&comm=$comment_id>Edit Comment</a>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=deleteusercomment.php?sid=$story_id&suser=$s_username&comm=$comment_id>Delete Comment</a>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
}
$stmt->close();

?>

<form action = "mainpage.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>

</body>
</html>
