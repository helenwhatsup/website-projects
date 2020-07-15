<!DOCTYPE html>
<html>
<head><title>Edit Link or Title</title></head>
<body>

<?php

require 'database.php';

session_start();
$current_user = $_SESSION['username'];
$s_username = $_GET['suser'];
$story_id =  $_GET['sid'];
//link to editstory2.php with same get query values
$linkstring =  "editstorytitle2.php?sid=".$story_id."&suser=".$s_username;

//if usernames differ, we redirect back to mainpage because you cannot edit a different user's story
if ($s_username!=$current_user){
    echo "You can only edit the story you created!!!";
    header("Location: mainpage.php");
}
?>
<form action = "mainpage.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>
<form action="<?php echo $linkstring; ?>"  method="POST">
        <p>
                <label for="name">Retype your title or link here to update it:</label>
                <input type="text" name="storytitle" id="storytitle" />
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        </p>
                 <br>
                 <input type="radio" name="operation" value="Title" required> Title<br>
                 <input type="radio" name="operation" value="Link" required> Link<br>

        <p>
                <input type="submit" value="Update" />
        </p>
</form>

</body>

</html>
