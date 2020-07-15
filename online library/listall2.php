<!DOCTYPE HTML>

<html lang = "en">  
        <head>
                <title>E-library Website</title>
                <meta charset="utf-8" />
                
                <link rel="stylesheet" href="css/main.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script src="js2.js"></script>

        </head>
<body>
<!-- sorting options here -->
<div id = "displayoptions">
        <br> <br> <br>
        Display Book by Category:
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



<form action = "index.html" method = "POST">
<input type= "submit" name = "view" value = "Go Back" />
</form>

<div id = "listbook">
<h1> List of All Books </h1>
<div id = "list"> </div>

</div>

<script>
function getBooks() {

                document.getElementById("list").remove();
		//checks each button to see which one is checked off so that javascript can make ajax calls and get the correct set of books
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
                                 
                                if (jsonData.exists) {
                                        for (i = 0; i < jsonData.books.length; i++) {
                                                //creates text properties for all the main properties of a book
                                                var primarykeystring = jsonData.books[i].username + "---" + jsonData.books[i].title + "---" + jsonData.books[i].author;
                                                var bookdiv = document.createElement("div");
                                                var titletext = document.createElement("div");
                                                titletext.textContent = jsonData.books[i].title;
                                                titletext.setAttribute("id", primarykeystring + "1");
                                                bookdiv.appendChild(titletext);

                                                var authtext = document.createElement("div");
                                                authtext.textContent = "By " +  jsonData.books[i].author;
                                                authtext.setAttribute("id", primarykeystring + "2");
                                                bookdiv.appendChild(authtext);

                                                var usertext = document.createElement("div");
                                                usertext.textContent = "Username: " + jsonData.books[i].username;
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

                                              //  bookdiv.appendChild(document.createTextNode("Author: " + jsonData.books[i].author + " "));
                                              //  bookdiv.appendChild(document.createTextNode("Username: " + jsonData.books[i].username + " "));
                                             //   bookdiv.appendChild(document.createTextNode("Category: " + jsonData.books[i].category+ " "));
                                                bookdiv.appendChild(document.createTextNode("---------------------------------------------------- "));
                                                bookdiv.setAttribute("class", "books");
                                                bookdiv.setAttribute("id", jsonData.books[i].username + "---" + jsonData.books[i].title);
                                                
                                                document.getElementById("list").appendChild(bookdiv);
                                        }
                              }
                        }
                }, false);
                xmlHttp.send(dataString);
       document.getElementById("listbook").appendChild(redo_list); 
}
//adds event listeners for whenever the page is refreshed and whever a radio button is clicked
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

