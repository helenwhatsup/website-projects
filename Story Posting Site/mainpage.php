<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <meta charset="utf-8"/>
        <title>Main Story Web page</title>

        <form action = "logout.php" methods = "POST">
        <input type= "submit" name = "Log Out" value = "Log Out" />
        </form>

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
<?php
 require 'database.php';
 session_start();
 $username1 = $_SESSION['username'];
 //lists out all the stories on the front page first by fetching all of them from the story table
 $stmt = $mysqli->prepare("select username, story_title, story_content, link, story_id, numlikes from story");
 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->execute();

 $stmt->bind_result($username, $story_title, $story_content, $link, $story_id, $numlikes);
 echo"<h1>Story Sharing Site</h1><br /> ";
 echo "Hi, our dear user  <i>".$username1."</i> ! Welcome to the Story Sharing Site!!<br />";
 echo "You can see a list of stories and their comments below.<br />";
 echo "<br /><br />";
//above is the introduction message, below is code for printing out all the stories and various options for each of them.

 while($stmt->fetch()){
    printf("%s,%s,%s, %s <br />",
    htmlspecialchars("Story user:".$username),
    htmlspecialchars("Storytitle :".$story_title),
    htmlspecialchars("Story id: ".$story_id),
    htmlspecialchars("Number of likes: ".$numlikes));
//  htmlspecialchars($link);
    echo "Story Link:";
    echo "<a href='".$link."'>".htmlspecialchars($link)."</a> ";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=viewcontents.php?sid=$story_id&suser=$username>View content</a> ";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=comment.php?sid=$story_id&suser=$username>Comment on This Story</a>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=viewcomment.php?val=$story_id&suser=$username>View Story Comments</a>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=deleteboth.php?sid=$story_id&suser=$username>Delete Story with its comments</a>";//delete
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=editstory.php?sid=$story_id&suser=$username>Edit Story content</a>";//edit
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=editstorytitle.php?sid=$story_id&suser=$username>Edit Story title or link</a>";//edit
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=like.php?sid=$story_id&suser=$username>Like</a>";//Like
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a href=dislike.php?sid=$story_id&suser=$username>Dislike</a>";//Unlike
    echo "<br /><br />";

}
$stmt->close();
//below are various forms for the other options you can do on the main page, such as uploading a story, viewing your own comments, and viewing profiles.
 ?>

<p>You can upload stories here :<p>

        <form action = "poststory.php" methods = "POST">

    <label>Please enter your Username(must be same as your login username!):</label>
    <input type="text" name="username" id="username" />
    <label>New Story Title:</label>
    <input type="text" name="storytitle" id="storytitle" />
    <label>Stories content:</label>
    <textarea rows="6" cols="150" placeholder="Please type story content here." name="content" id="content"></textarea>
    <label> Story Link:</label>
    <input type="text" name = "link" id = "link" />
    <label> Story id:</label>
    <input type="integer" name = "story_id" id = "story_id" />

<input type= "submit" name = "submit" value = "submit" />

</form>

<form action = "viewusercomment.php" methods = "POST">
<label> Here you can view and edit all the comments you have made:</label>
<input type= "submit" name = "view" value = "View_Comments" />

</form>

<form action = "viewprofiles.php" methods = "POST">
<label> Here you can view profiles for all the users:</label>
<input type= "submit" name = "view" value = "View_Profiles" />

</form>



<h1>

<br /><br /><br /><br />





<h1>


</body>
 </html>
