<!DOCTYPE html>
<html>
<head><title>View a story</title></head>
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
 $storyid = $_GET['sid'];
 $suser = $_GET['suser'];

//gets the title and the content of the story that the link redirected us to
 $stmt = $mysqli->prepare("select story_title, story_content from story where story_id = ?  AND username = ?");

 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }

 $stmt->bind_param('ss',$storyid,$suser);
 $stmt->execute();
 $stmt->bind_result( $title, $content) ;


echo "<br /><br />";
 while($stmt->fetch()){
    echo "Title:".$title;
    echo "<br /><br />";
    echo "Story Content:";
    echo $content;
}
$stmt->close();



?>
</body>
</html>
