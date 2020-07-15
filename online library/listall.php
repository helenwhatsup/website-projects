<!DOCTYPE HTML>

<html lang="en">  
        <head>
                <title>E-library Website</title>
                <meta charset="utf-8" />
                
                <link rel="stylesheet" href="css/main.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script src="js2.js"></script>

        </head>
<body>

<div id = "displayoptions">
        <h3>Display Book by Category:</h3>
        <br>
<input type="radio" name="cat" value="Nonfiction Biography" id = "id1" required> Nonfiction Biography
<input type="radio" name="cat" value="Nonfiction Informative" id = "id2" required> Nonfiction Informative
<input type="radio" name="cat" value="Graphic Novel" id = "id3" required> Graphic Novel
<input type="radio" name="cat" value="Mystery" id = "id4" required> Mystery
<input type="radio" name="cat" value="Fantasy" id = "id5" required> Fantasy
<input type="radio" name="cat" value="Science Fiction" id = "id6" required> Science Fiction
<input type="radio" name="cat" value="Childrens" id = "id7" required> Childrens
<input type="radio" name="cat" value="Realistic/Historical Fiction" id = "id8" required> Realistic/Historical Fiction
<input type="radio" name="cat" value="Action/Thriller" id = "id9" required> Action/Thriller
<input type="radio" name="cat" value="Romance" id = "id10" required> Romance
<input type="radio" name="cat" value="Other" id = "id11" required> Other
<input type="radio" name="cat" value="All Books" id = "id12" required> All Books<br>
</div>



<form action = "index.php" method = "POST">
<input type= "submit" name = "view" value = "Go Back" />
<br>
</form>
<?php session_start(); ?>
<div id = "listbook">
<h1> List of All Books </h1>
<input type="hidden" id = "csrf_token" name="token" value="<?php echo $_SESSION['token'];?>" />
<div id = "list"> </div>

</div>

<script>
//same as listall2.php but with additional buttons for users to add these books to their two lists. This is also why we put a token in this one.
const tok = document.getElementById("csrf_token").value;
function getBooks() {

                document.getElementById("list").remove();

                var redo_list = document.createElement("div");
                redo_list.setAttribute("id", "list");
                var v1 =  document.getElementById('id1');
                var v2 =  document.getElementById('id2');
                var v3 =  document.getElementById('id3');
                var v4 =  document.getElementById('id4');
                var v5 =  document.getElementById('id5');
                var v6 =  document.getElementById('id6');
                var v7 =  document.getElementById('id7');
                var v8 =  document.getElementById('id8');
                var v9 =  document.getElementById('id9');
                var v10 =  document.getElementById('id10');
                var v11 =  document.getElementById('id11');
                var v12 =  document.getElementById('id12');
                var category = document.getElementById('id12');
                
                if (v1.checked == true){
                        category = document.getElementById('id1');
                }
                if (v2.checked == true){
                        category = document.getElementById('id2');
                }
                if (v3.checked == true){
                        category = document.getElementById('id3');
                }
                if (v4.checked == true){
                        category = document.getElementById('id4');
                }
                if (v5.checked == true){
                        category = document.getElementById('id5');
                }
                if (v6.checked == true){
                        category = document.getElementById('id6');
                }
                if (v7.checked == true){
                        category = document.getElementById('id7');
                }
                                if (v8.checked == true){
                        category = document.getElementById('id8');
                }
                                if (v9.checked == true){
                        category = document.getElementById('id9');
                }
                                if (v10.checked == true){
                        category = document.getElementById('id10');
                }
                                if (v11.checked == true){
                        category = document.getElementById('id11');
                }
                               if (v12.checked == true){
                        category = document.getElementById('id12');
                }
                                var category_value = category.value;
                var dataString = "category=" + encodeURIComponent(category_value);
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open("POST", "displayall.php", true);
                xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
                xmlHttp.addEventListener("load", function (event) {
                        var jsonData = JSON.parse(event.target.responseText);
                        if (!jsonData.success) {
                                alert("failed to fetch events");
                        }
                        else {
                                  var button_IDs = []; //array of add to list buttons
                                var abutton_IDs = [];//array of add to buy buttons
                        //      var sbutton_IDs = []; //array of share buttons
                                if (jsonData.exists) {
                                        for (i = 0; i < jsonData.books.length; i++) {
                                                //creates the event text node with title, time and category
                                                button_IDs[i] = i;
                                                abutton_IDs[i] = i;
                                //                                                              sbutton_IDs[i] = i;
                                                var primarykeystring = jsonData.books[i].username + "---" + jsonData.books[i].title + "---" + jsonData.books[i].author;
                                                var bookdiv = document.createElement("div");
                                                var titletext = document.createElement("div");
                                                titletext.textContent = "Book Title: " + jsonData.books[i].title;
                                                titletext.setAttribute("id", primarykeystring + "1");
                                                bookdiv.appendChild(titletext);

                                                var authtext = document.createElement("div");
                                                authtext.textContent = "By " +  jsonData.books[i].author;
                                                authtext.setAttribute("id", primarykeystring + "2");
                                                bookdiv.appendChild(authtext);

                                                var usertext = document.createElement("div");
                                                usertext.textContent = "Owned By User: " + jsonData.books[i].username;
                                                usertext.setAttribute("id", primarykeystring + "3");
                                                bookdiv.appendChild(usertext);

                                                var yeartext = document.createElement("div");
                                                yeartext.textContent = "Year: " + jsonData.books[i].year;
                                                yeartext.setAttribute("id", primarykeystring + "4");
                                                bookdiv.appendChild(yeartext);

                                                var categoryt = document.createElement("div");
                                                categoryt.textContent = "Category: " + jsonData.books[i].category;
                                                categoryt.setAttribute("id", primarykeystring + "5");
                                                bookdiv.appendChild(categoryt);

                                                //creates dummy variables for the isbn and the abstract, will save these for the buttons
                                                var isbntext = document.createElement("div");
                                                isbntext.textContent = jsonData.books[i].isbn;
                                                isbntext.setAttribute("id", primarykeystring + "6");
                                                bookdiv.appendChild(isbntext);
                                                var abstext = document.createElement("div");
                                                abstext.textContent = jsonData.books[i].abs;
                                                abstext.setAttribute("id", primarykeystring + "7");
                                                bookdiv.appendChild(abstext);
                                                isbntext.style.visibility = "hidden";
                                                abstext.style.visibility = "hidden";
                                              //  bookdiv.appendChild(document.createTextNode("Author: " + jsonData.books[i].author + " "));
                                              //  bookdiv.appendChild(document.createTextNode("Username: " + jsonData.books[i].username + " "));
                                            //    bookdiv.appendChild(document.createTextNode("Category: " + jsonData.books[i].category+ " "));
                                              //  bookdiv.appendChild(document.createTextNode("Year: " + jsonData.books[i].year + " "));
                                                bookdiv.setAttribute("class", "books");
                                                bookdiv.setAttribute("id", jsonData.books[i].username + "---" + jsonData.books[i].title);
                                                //creates an add-to-owned-list button right below the book text with ID containing the book information
                                                const add = document.createElement("button");
                                                add.textContent = "Add to own list";
                                                add.setAttribute("class", "addbuttons");
                                               // var primarykeystring = jsonData.books[i].username + " " + jsonData.books[i].title;
                                                add.setAttribute("id", primarykeystring);
                                                bookdiv.appendChild(add);
                                                button_IDs[i] = primarykeystring;

                                                const add2 = document.createElement("button");
                                                add2.textContent = "Add to wishlist";
                                                add2.setAttribute("class", "addbuttons");
                                                add2.setAttribute("id", "-" + primarykeystring);
                                                bookdiv.appendChild(add2);
                                                abutton_IDs[i] = "-" + primarykeystring;        
                                //              bookdiv.appendChild(document.createTextNode("--------------------------------------------"));
                                                document.getElementById("list").appendChild(bookdiv);


                                        }
                                }
                                //adds event listeners to all the buttons with the correct information of each book attached to each one, similar to how we did events in calendar              
                                                                if (button_IDs.length > 0) {
                                
                                        for (j = 0; j < button_IDs.length; j++) {
                                              const primkeystring = button_IDs[j];
                                              console.log(button_IDs[j]);                                          
                                                document.getElementById(button_IDs[j]).addEventListener("click", function () {
                                                        console.log(primkeystring);
                                                var title = document.getElementById(primkeystring + "1").textContent;
                                                var author = (document.getElementById(primkeystring + "2").textContent).substring(3);
                                                var user = (document.getElementById(primkeystring + "3").textContent).substring(15);
                                                console.log(user);
                                                var yr = (document.getElementById(primkeystring + "4").textContent).substring(6);
                                                var cat = (document.getElementById(primkeystring + "5").textContent).substring(10);
                                                var isbn = document.getElementById(primkeystring + "6").textContent;
                                                var abs = document.getElementById(primkeystring + "7").textContent;
                                                var list = 1;
                                                var dataString2 = "title=" + encodeURIComponent(title) + "&author=" + encodeURIComponent(author) + "&user=" + encodeURIComponent(user) + "&year=" + encodeURIComponent(yr) + "&category=" + encodeURIComponent(cat) + "&isbn=" + encodeURIComponent(isbn) + "&abstract=" + encodeURIComponent(abs) + "&token=" + encodeURIComponent(tok)  +  "&list=" + encodeURIComponent(list);
                                                console.log(dataString2);
                                                var xmlHttp = new XMLHttpRequest();
                                                xmlHttp.open("POST", "addfrombig.php", true);
                                                xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
                                                xmlHttp.addEventListener("load", function (event) {
                                                  console.log("reached");
                                                  var jsonData = JSON.parse(event.target.responseText);
                                                  if (!jsonData.success) {
                                                        alert(jsonData.message);
                                                        }
                                                  else{alert("book added")}
                                              //          deleteEvent(idid);
                                                }, false);
                                                xmlHttp.send(dataString2);

                                              }, false);
                                        }
                                }

                                                                if (abutton_IDs.length > 0) {

                                        for (j = 0; j < abutton_IDs.length; j++) {
                                              var primkeystring = abutton_IDs[j].substring(1);
                                              console.log(abutton_IDs[j]);                                          
                                                document.getElementById(abutton_IDs[j]).addEventListener("click", function () {
                                                        console.log(primkeystring);
                                                var title = document.getElementById(primkeystring + "1").textContent;
                                                var author = (document.getElementById(primkeystring + "2").textContent).substring(3);
                                                var user = (document.getElementById(primkeystring + "3").textContent).substring(15);
                                                var yr = (document.getElementById(primkeystring + "4").textContent).substring(6);
                                                var cat = (document.getElementById(primkeystring + "5").textContent).substring(10);
                                                var isbn = document.getElementById(primkeystring + "6").textContent;
                                                var abs = document.getElementById(primkeystring + "7").textContent;
                                                var list = 2;
                                                var dataString2 = "title=" + encodeURIComponent(title) + "&author=" + encodeURIComponent(author) + "&user=" + encodeURIComponent(user) + "&year=" + encodeURIComponent(yr) + "&category=" + encodeURIComponent(cat) + "&isbn=" + encodeURIComponent(isbn) + "&abstract=" + encodeURIComponent(abs) + "&token=" + encodeURIComponent(tok) + "&list=" + encodeURIComponent(list);
                                                console.log(dataString2);
                                                var xmlHttp = new XMLHttpRequest();
                                                xmlHttp.open("POST", "addfrombig.php", true);
                                                xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
                                                xmlHttp.addEventListener("load", function (event) {
                                                  console.log("reached");
                                                  var jsonData = JSON.parse(event.target.responseText);
                                                  if (!jsonData.success) {
                                                        alert(jsonData.message);
                                                        }
                                                  else{alert("book added")}
                                              //          deleteEvent(idid);
                                                }, false);
                                                xmlHttp.send(dataString2);

                                              }, false);
                                        }
                                }
                        }
                }, false);
                xmlHttp.send(dataString);
       document.getElementById("listbook").appendChild(redo_list); 
}

document.addEventListener("DOMContentLoaded", getBooks, false);

document.getElementById("id1").addEventListener("click", getBooks, false);
document.getElementById("id2").addEventListener("click", getBooks, false);
document.getElementById("id3").addEventListener("click", getBooks, false);
document.getElementById("id4").addEventListener("click", getBooks, false);
document.getElementById("id5").addEventListener("click", getBooks, false);
document.getElementById("id6").addEventListener("click", getBooks, false);
document.getElementById("id7").addEventListener("click", getBooks, false);
document.getElementById("id8").addEventListener("click", getBooks, false);
document.getElementById("id9").addEventListener("click", getBooks, false);
document.getElementById("id10").addEventListener("click", getBooks, false);
document.getElementById("id11").addEventListener("click", getBooks, false);
document.getElementById("id12").addEventListener("click", getBooks, false);

</script>




</body>

</html>

