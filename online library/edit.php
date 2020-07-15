<!DOCTYPE html>
<html>
<head><title>Edit Link or Title</title></head>
<link rel="stylesheet" href="css/main.css" />

<body>

<?php

require 'database.php';

session_start();
$current_user = $_SESSION['username'];
$b_username = $_GET['buser'];
$b_author = $_GET['bauthor'];
$title =  $_GET['title'];
$list = $_GET['list'];

echo "Currently Editing ".$title;

//link to editstory2.php with same get query values
$linkstring =  "edit2.php?buser=".$b_username."&title=".$title."&bauthor=".$b_author."&list=".$list;

//if usernames differ, we redirect back to mainpage because you cannot edit a different user's story
if ($b_username!=$current_user){
    echo "You can only edit the story you created!!!";
    header("Location: index.php");
}
?>
<form action = "index.php" methods = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>
<form action="<?php echo $linkstring; ?>"  method="POST">
        <p>
                <label for="name">Retype information here:</label>
        <br>
        <label>Book Name:</label>
        <input type="text" placeholder="title" name="btitle" id="btitle" />
        <br>
        <label>Author:</label>
        <input type="text" placeholder="author" name="bauthor" id="bauthor" />
        <br>
        <label> Publish Year</label>
        <input type="text" placeholder="year" name = "byear" id = "byear" />
        <br>
        <label> category</label>

                      <select id = "bcategory" name = "bcategory" >
                                <option value = "Nonfiction Biography">Nonfiction Biography</option>
                                <option value = "Nonfiction Informative">Nonfiction Informative</option>
                                <option value = "Graphic Novel">Graphic Novel</option>
                                <option value = "Mystery">Mystery</option>
                                <option value = "Fantasy">Fantasy</option>
                                <option value = "Science Fiction">Science Fiction</option>
                                <option value = "Children’s">Children’s</option>
                                <option value = "Realistic/Historical Fiction">Realistic/Historical Fiction</option>
                                <option value = "Action/Thriller">Action/Thriller</option>
                                <option value = "Romance">Romance</option>
                                <option value = "Other">Other</option>
                        </select>
                <input type="hidden" name="token" id = "token"  value="<?php echo $_SESSION['token'];?>" />
        </p>
        <p>
                <input type="submit" value="Update" />
        </p>
</form>

</body>

</html>
