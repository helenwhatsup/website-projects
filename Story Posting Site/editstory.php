<!DOCTYPE html>
<html>
<head><title>Edit Story</title></head>
<body>

<?php

require 'database.php';

session_start();
$current_user = $_SESSION['username'];
$s_username = $_GET['suser'];
$story_id =  $_GET['sid'];
//linkstring to editstory2.php with the same get query values
$linkstring =  "editstory2.php?sid=".$story_id."&suser=".$s_username;


//if the story's username differs from the login user, then it redirects to the mainpage automatically
//because one can only edit his/her own stories
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
                <label for="name">Retype your story here to update it:</label>
                <textarea rows="6" cols="150" placeholder="Please type story content here." name="content" id="content"></textarea>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />


        </p>
        <p>
                <input type="submit" value="Comment" />
        </p>
</form>

</body>

</html>

