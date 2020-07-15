<!DOCTYPE html>
<html>
<head><title>Comment on Story</title></head>
<body>



<?php

require 'database.php';

    session_start();
    $c_username = $_SESSION['username'];
    $s_username = $_GET['suser'];
    $story_id =  $_GET['sid'];

    //link to comment2 with stored get queries 
    $linkstring =  "comment2.php?sid=".$story_id."&suser=".$s_username;

?>

<form action = "mainpage.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>

<!-- this form is for typing a comment and comment id -->
<form action="<?php echo $linkstring; ?>"  method="POST">
        <p>
                <label for="name">Comment:</label>
                <input type="text" name="name" id="name" />
                <label for="name">CommentID (an ID to store your comment in case of duplicates):</label>
                <input type="number" name="ID" id="ID" />
        </p>
        <p>
                <input type="submit" value="Comment" />
        </p>
</form>



</body>
</html>
