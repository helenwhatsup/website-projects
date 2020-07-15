<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <meta charset="utf-8"/>
        <title>Main Story Web page</title>
    </head>

    <style>
    body{font-size:100%; background-color:#eaf0bb;
    font-weight: lighter;
    font-family: Arial;
    font-size: 30px;
     text-align: center
      };
    form{ display:inline-block};

</style>
<body>
<form action="logout.php" method="POST">
<input type="submit" name="Back to Login Page" value="Back to Login Page" />
</form>

<?php
 require 'database.php';
 session_start();
//as a nonregistered user, only stories and comments can be viewed. ON this page one can view stories, and we can click on each
//specific story to view all the comments
 $stmt = $mysqli->prepare("select username, story_title, story_content, link, story_id from story");

 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->execute();
 $stmt->bind_result($username, $story_title, $story_content, $link, $story_id);
 echo"<h1>Welcome to Story Sharing Site!</h1><br /> ";

 echo("You can view story and comments below as an unregistered user. <br /><br />");
                while($stmt->fetch()){
            echo "Username: ".$username."<br />";
           // echo "Link: ".$link."<br />";
            echo "Title: ".$story_title."<br />";
            echo "ID: ".$story_id."<br /><br />";
            echo "View content:";
            echo "<a href=viewcontents.php?sid=$story_id&suser=$username>view content</a> ";
            echo "<br />";
            echo "Link:";
            echo "<a href='".$link."'>".htmlspecialchars($link)."</a> ";
            echo "<br />";
            echo "<a href=viewcomment.php?val=$story_id&suser=$username>View Story Comments</a>";
            echo "<br />";
        }
        $stmt->close();

?>

</body>
 </html>
