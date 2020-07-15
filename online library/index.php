<!DOCTYPE HTML>

<html lang = "en">
        <head>
                <title>E-library Website</title>
                <meta charset="utf-8" />
                
                <link rel="stylesheet" href="css/main.css" />
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <script type='text/javascript' src='config.js'></script>
                <script type="text/javascript" src="script.js"></script>


        </head>
        <body>

                <!-- Header -->
                        <header id="header">
                                <div class="inner">
                                        <a href="index.php" class="logo">E-Library Website</a>
                                        <nav id="nav">
                        <!--                    <a href="index.php" id = "home">Home</a> -->
                                                <a href="logout.php" id = "userlogout">Logout</a>
                                                <a href="listall.php" id = "listall">List of All Books</a>
                                                <a href="viewprofiles.php" id = "viewusers">View Profiles</a>
                                        </nav>
                                </div>
                        </header>
                        <a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
                <!-- Banner -->
                        <section id="banner">
                                <div class="inner">
                                        <h1>Welcome to E-Library: <span>Here you can browse books, list your books and find other readers!You could even look up the weather!<br />
                                </span></h1>
                                </div>
                        </section>

            <?php
 require 'database.php';
 session_start();
 $username1 = $_SESSION['username'];
 echo "<h1>Hi, our dear user  <i>".$username1."</i> !!!</h1><br />";
 echo "<h2> Let's begin your reading journey!</h2><br/>";
 echo "<br /><br />";

//below are various forms for the other options you can do on the main page, such as viewing your lists, uploading books to your lists, and searching for books on googlebooks 
 ?>
<h2> Search For Books </h2>
                         <div class="container">
                                        <div id="searchBox">
                                                <form id="form" class="form-inline">
                                                        <input type="text" id="searchText">
                                                        <input type="submit" value="Search">
                                                        <select id="type">
                                                                <option value="Title">Title</option>
                                                                <option value="Author">Author</option>
                                                        </select>
                                                        <select id="order">
                                                                <option value="Relevance">Relevance</option>
                                                                <option value="Publish Date">Publish Date</option>
                                                        </select>
                                                </form>
                                        </div>

                                        <h3> Search Results</h3>
                                <div id="resulttext"></div>
                                <div id="result"></div>
</div>

<hr>
<!-- upload books to your lists, below each form is a list of the current books in both lists -->
<h5>You can upload Books you own here:</h5>

<form action = "uploadbook.php" method = "GET">

<label>Username(must be same as your login username!):</label>
<input type="text" placeholder="username" name="username" id="username" />
<br>
<label>Book Name:</label>
<input type="text" placeholder="title" name="title" id="title" />
<br>
<label>Author:</label>
<input type="text" placeholder="Author" name="author" id="author" />
<br>
<label> Publish Year</label>
<input type="text" placeholder="year" name = "year" id = "year" />
<br>
<label> category</label>
                      <select id = "category" name = "category" >
                                <option value = "Nonfiction Biography">Nonfiction Biography</option>
                                <option value = "Nonfiction Informative">Nonfiction Informative</option>
                                <option value = "Graphic Novel">Graphic Novel</option>
                                <option value = "Mystery">Mystery</option>
                                <option value = "Fantasy">Fantasy</option>
                                <option value = "Science Fiction">Science Fiction</option>
                                <option value = "Childrens">Childrens</option>
                                <option value = "Realistic/Historical Fiction">Realistic/Historical Fiction</option>
                                <option value = "Action/Thriller">Action/Thriller</option>
                                <option value = "Romance">Romance</option>
                                <option value = "Other">Other</option>
                        </select>
<br>
<label> ISBN </label>
<input type="text" placeholder="isbn" name="isbn" id="isbn" />
<br>
<label> Abstract </label>
<textarea rows="6" cols="100" placeholder="Please type abstract content here." name="abstract" id="abstract"></textarea>
<br>
<input type="hidden" name="token" id = "token" value="<?php echo $_SESSION['token'];?>" />
<input type= "submit" name = "submit" value = "submit" />
<br><br>
<br><br>
</form>
                <!-- Two -->
                        <section id="two">
                                                        <header>
                                                                <h2>List of Books You Own</h2>
                                                        </header>
                                <div class="inner">
                                        <article>
                                                <div class="content">
                                                        <div class="image fit">
                                                                <img src="images/pic01.jpg" alt="" />
                                                        </div>
                                                </div>
                    </article>
                </div>
                </section>
                    
<?php
 require 'database.php';
// fetching all books owned by the current logged in user, along with hrefs to look at more info, edit, and delete options
 $username1 = $_SESSION['username'];
 $stmt = $mysqli->prepare("select title, author,year, category from book where username = ?");
 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->bind_param('s', $username1);

 $stmt->execute();

 $stmt->bind_result($title, $author, $year, $category);
 echo "<br /><br />";
 while($stmt->fetch()){

    printf("%s,<br />%s,<br /> %s,<br />%s, <br /><br /><br />",
    htmlspecialchars("Book title :".$title),
    htmlspecialchars("Author: ".$author),
    htmlspecialchars("Year ".$year),
    htmlspecialchars("Category ".$category));
    $title1 = str_replace(' ', '%20', $title);
    $author1 = str_replace(' ', '%20', $author);
 
    echo "<a href=readmore.php?title=$title1&buser=$username1&bauthor=$author1&list=1>MORE INFO</a> ";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "<a href=edit.php?title=$title1&buser=$username1&bauthor=$author1&list=1>EDIT INFO</a> ";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "<a href=delete.php?title=$title1&buser=$username1&bauthor=$author1&list=1>DELETE BOOK</a> ";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo"<br>";
    echo"----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
     echo"<br>";

}
$stmt->close();

?>

<hr>

<h5>You can upload Books you want to buy here:</h5>
<form action = "buy.php" method = "GET">
<label>Username(must be same as your login username!):</label>
<input type="text" placeholder="username" name="username" id="username1" />
<br>
<label>Book Name:</label>
<input type="text" placeholder="title" name="title" id="title1" />
<br>
<label>Author:</label>
<input type="text" placeholder="Author" name="author" id="author1" />
<br>
<label> Publish Year</label>
<input type="text" placeholder="year" name = "year" id = "year1" />
<br>
<label> category</label>

                      <select id = "category1" name = "category" >
                                <option value = "Nonfiction Biography">Nonfiction Biography</option>
                                <option value = "Nonfiction Informative">Nonfiction Informative</option>
                                <option value = "Graphic Novel">Graphic Novel</option>
                                <option value = "Mystery">Mystery</option>
                                <option value = "Fantasy">Fantasy</option>
                                <option value = "Science Fiction">Science Fiction</option>
                                <option value = "Childrens">Childrens</option>
                                <option value = "Realistic/Historical Fiction">Realistic/Historical Fiction</option>
                                <option value = "Action/Thriller">Action/Thriller</option>
                                <option value = "Romance">Romance</option>
                                <option value = "Other">Other</option>
                        </select>

<br>
<input type="hidden" name="token" id = "token1"  value="<?php echo $_SESSION['token'];?>" />
<input type= "submit" name = "submit" value = "submit" />
<br><br>
<br><br>
</form>
                <!-- Three -->
                        <section id="three">
			<header>
                                        <h2>Books you want to buy</h2>
                        </header>
                                <div class="inner">
                                        <article>
                                                <div class="content">
                                                        <div class="image fit">
                                                                <img src="images/pic01.jpg" alt="" />
                                                        </div>
                                                </div>
                    </article>
                </div>
                </section>

<?php
 require 'database.php';
// session_start();
 $username1 = $_SESSION['username'];
 $stmt = $mysqli->prepare("select username, title, author,year, category from buy where username = ?");
 if(!$stmt)
 {
     printf("Query Prep Failed: %s\n", $mysqli->error);
     exit;
 }
 $stmt->bind_param('s', $username1);

 $stmt->execute();

 $stmt->bind_result($username, $title, $author, $year, $category);
 echo "<br /><br />";

 while($stmt->fetch()){
        printf("%s,<br />%s,<br /> %s,<br />%s, <br /><br /><br />",
    htmlspecialchars("Book title :".$title),
    htmlspecialchars("Author: ".$author),
    htmlspecialchars("Year ".$year),
    htmlspecialchars("Category ".$category));
$title1 = str_replace(' ', '%20', $title);
 $author1 = str_replace(' ', '%20', $author);
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
  //      echo "<a href=edit.php>EDIT INFO</a> ";
  //  echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "<a href=delete.php?title=$title1&buser=$username1&bauthor=$author1&list=2>DELETE BOOK</a> ";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
  echo"<br>";
  echo"-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
  echo"<br>";
}
$stmt->close();

?>


        </body>
</html>

