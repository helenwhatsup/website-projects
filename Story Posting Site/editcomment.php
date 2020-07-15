<!DOCTYPE html>
<html>
<head><title>Edit Comment</title></head>
<body>

<?php

require 'database.php';

session_start();
$current_user = $_SESSION['username'];
$s_username = $_GET['suser'];
$story_id =  $_GET['sid'];
$comment_id = $_GET['comm'];
//linkstring to get to editcomment2.php with the same get values
$linkstring =  "editcomment2.php?sid=".$story_id."&suser=".$s_username."&comm=".$comment_id;

?>
<!-- this form allows you to edit a current comment -->
<form action="<?php echo $linkstring; ?>"  method="POST">
        <p>
                <label for="name">Retype your comment here to update it:</label>
                <textarea rows="6" cols="150" placeholder="Please type updated comment here." name="comment" id="comment"></textarea>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        </p>
        <p>
                <input type="submit" value="Comment" />
        </p>
</form>

</body>

</html>
