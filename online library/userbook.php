<!DOCTYPE HTML>

<html>
	<head>
        <title> Book Management List</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css/main.css" />
      

        <p>You can enter book information here :<p>
        <form action = "enter.php" methods = "POST">

    <label>Please enter your Username(must be same as your login username!):</label>
    <input type="text" name="username" id="username" />
    <label></label>
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


    </head>
</html>
