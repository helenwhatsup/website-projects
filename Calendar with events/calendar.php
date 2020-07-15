<!DOCTYPE html>
<html lang='en'>
    <head>
    <meta charset="utf-8" />
    <title>
        Calendar
    </title>
    <h1>
        Helen & Zach's Calendar
    </h1>


        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet">
        <!-- We need the style sheet linked above or the dialogs/other parts of jquery-ui won't display correctly!-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
        <!-- The main library. Note: must be listed before the jquery-ui library -->
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
        <!-- jquery-UI hosted on Google's Ajax CDN-->

        <script src="http://classes.engineering.wustl.edu/cse330/content/calendar.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
       <!-- <script src=calendar.js></script> -->
        <link rel="stylesheet" type="text/css" href="calendar.css">
<style>
#dialog{
    color:red;
    display: none
}
#sharedialog{
    color:red;
    display: none
}

#logout{
    display: none
}
#displayoptions{
        display: none
}
#add_event_trigger{
    display: none
}
head{
    text-align: center;
    }
body{
    background:url(bkgnd.jpg);
}
.calendar{
    text-align: center;
}

table{
    margin: auto;
}
th{
    border-left:8px solid rgb(117, 49, 106);
    border-right:8px groove rgb(170, 158, 236);
    border-bottom:8px groove rgb(170, 158, 236);
    border-top:8px groove rgb(117, 49, 106);
    width:180px;
    height:75px;
    font-size: 200%
}
td{
    width:180px;
    height:75px;
    font-size: 260%;

    border-left:8px solid rgb(66, 14, 73);;
    border-right:8px groove rgb(170, 158, 236);
    border-bottom:8px groove rgb(170, 158, 236);
    border-top:8px groove  rgb(66, 14, 73);

}
input
{
  color:red;
}

</style>
</head>
    <body>


<p id="welcomeMessage" class="welcomeMessage"></p>

<br><br>

    <button id="logout" >Log out</button>

    <button id="add_event_trigger" >Add Event</button>

        <div id="dialog">
                        <h1>Add/Edit Event</h1>
                <!--    Enter Event Title, Date, Time, and Description here -->
                        Title:<input type="text" name="title" id="title">

                        <input type="date" name="date" id="date" >
                        <input type="time" name="time" id="time">

                        <select id = "category" >
                                <option value = "School">School</option>
                                <option value = "Work">Work</option>
                                <option value = "Recreation">Recreation</option>
                                <option value = "Family">Family</option>
                                <option value = "Holiday">Holiday</option>
                                <option value = "Other">Other</option>
                        </select>
                        <input type="submit" name="Add Event" value="Add Event" id="add_event_btn">
                        <input type="submit" value="Save Changes" id="save_changes_btn">
                        <input type="hidden" id = "csrf_token" name="token" />

        </div>


<div id = "sharedialog">
        <h1> Share Event </h1>
        Share Event to this user:<input type="text" name="shared_user" id="shared_user">
        <input type="submit" name="Share" value="Share!" id="share_event_btn">
</div>

<div id = "displayoptions">
        <br> <br> <br>
        Display Events by Category:
        <br>
<input type="radio" name="cat" value="School" id = "id1" required> School<br>
<input type="radio" name="cat" value="Work" id = "id2" required> Work<br>
<input type="radio" name="cat" value="Recreation" id = "id3" required> Recreation<br>
<input type="radio" name="cat" value="Family" id = "id4" required> Family <br>
<input type="radio" name="cat" value="Holiday" id = "id5" required> Holiday<br>
<input type="radio" name="cat" value="Other" id = "id6" required> Other<br>
<input type="radio" name="cat" value="All" id = "id7" required> All Events<br>
</div>

    <div id="register">
        <b>Register New User:</b>
        <input id="r_username" type="text" name="r_username" placeholder="Username">
        <input id="r_password" type="password" name="r_password" placeholder="Password">
        <button id="register_btn">Register</button>
    </div>

        <br><br><br>

    <div id="login">
        <b>Login:</b>
        <input  type="text" id="username" placeholder="Username" />
        <input type="password"  id="password" placeholder="Password" />
        <button id="login_btn">Log In</button>
    </div>

             <h2 id="displaymonth"></h2>
         <button id="prev_month_btn">Previous Month &#10094;</button>
         <button id="next_month_btn">Next Month&#10095;</button>

<!-- quickmove -->
Move to:<input id='move' type="text" name="move" placeholder="mm/yyyy" /> After typing a string, if the calendar doesn't move, try hitting the return key!
<script type="text/javascript" src="updatecalendar.js"></script>
    <div id="table">
        <table id="calendar">
        </table>
    </div>

<script>
//global variable to check to see if the user has logged in
var logged_in = false;
 
function opendialog(event){
        $("#dialog").css("display", "inline");
        $("#save_changes_btn").css("display", "none");
        $("#delete_event_btn").css("display", "none");
        $("#date").css("display", "inline");
        $("#add_event_btn").css("display", "inline");
        //Note to graders: the prompt did not say we needed a pop-up dialog, but we tried one anyway and it failed. It just opens up some of the inputs in our HTML page.

}

document.getElementById("add_event_trigger").addEventListener("click", opendialog, false);
//add event
function addevent(event){
  const t = document.getElementById("title").value;
  const d = document.getElementById("date").value;        
  const tok = document.getElementById("csrf_token").value;  
  const time = document.getElementById("time").value;
  const notes = document.getElementById("category").value;
  const dataString = "title=" + encodeURIComponent(t) + "&date=" + encodeURIComponent(d)  + "&time=" + encodeURIComponent(time)  + "&notes=" + encodeURIComponent(notes) + "&token=" + encodeURIComponent(tok);
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "addevent.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
  xmlHttp.addEventListener("load", function(event){
    var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.success) {
      alert("Event Added!");
      updateCalendar();
      $("#dialog").css("display", "none");
    }
    else {
      alert("Could not add event. "+jsonData.message);
    }
  }, false);
  xmlHttp.send(dataString);
}
document.getElementById("add_event_btn").addEventListener("click", addevent, false);


function loggedin(username) {
            logged_in = true;
            $("#displayoptions").css("display", "inline");
            $("#login").css("display", "none");
            $("#register").css("display", "none");
            document.getElementById("welcomeMessage").textContent = "Hello our dear user, " + username + "! Welcome to the calendar!";
            $("#welcomeMessage").css("display", "inline");
            $("#logout").css("display", "inline");
            $("#add_event_trigger").css("display", "inline");
            updateCalendar();
        }
function loginAjax(event) {
    const username = document.getElementById("username").value; // Get the username from the form
    const password = document.getElementById("password").value; // Get the password from the form
    const dataString = "username=" + encodeURIComponent(username) + "&pass=" + encodeURIComponent(password);
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "login.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
  xmlHttp.addEventListener("load", function(event){
  var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.success) {
      alert("Login success");
      document.getElementById("csrf_token").value=jsonData.token;
      loggedin(username); 
    }
    else {
      alert("You were not logged in "+jsonData.message);
    }
  }, false);
  xmlHttp.send(dataString);
}
document.getElementById("login_btn").addEventListener("click", loginAjax, false);


function registerAjax(event) {
  const newuser = document.getElementById('r_username').value;
  const newpass = document.getElementById('r_password').value;
  const dataString = "username=" + encodeURIComponent(newuser) + "&pass=" + encodeURIComponent(newpass);

  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "register.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
  xmlHttp.addEventListener("load", function(event){
    var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.success) {
      alert("Registration success");
    }
    else {
      alert("Registration Failed. "+jsonData.message);
    }
  }, false);
  xmlHttp.send(dataString);
}
document.getElementById('register_btn').addEventListener('click', registerAjax, false);

function logoutAjax(event) {
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "logout.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
  xmlHttp.addEventListener("load", function(event){
    var jsonData = JSON.parse(event.target.responseText);
    if (jsonData.success) {
      alert("Logged out!");
            $("#login").css("display", "inline");
            $("#register").css("display", "inline");
            $("#welcomeMessage").css("display", "none");
            $("#dialog").css("display", "none");
            $("#logout").css("display", "none");
             $("#add_event_trigger").css("display", "none");
            $("#displayoptions").css("display", "none");
        logged_in = false;
    }
    else {
      alert("Could not log out. "+jsonData.message);
    }
  }, false);
  xmlHttp.send(null);

  updateCalendar();
}
document.getElementById('logout').addEventListener('click', logoutAjax, false);


//checks to see if a user is logged in when the page is refreshed
function checkforlogin(event) {

  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "checklogin.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
  xmlHttp.addEventListener("load", function(event){
    var jsonData = JSON.parse(event.target.responseText);
  

        if (jsonData.success){
                document.getElementById("csrf_token").value=jsonData.token;
                loggedin(jsonData.username);
        }
        else{
            $("#login").css("display", "inline");
            $("#register").css("display", "inline");
            $("#welcomeMessage").css("display", "none");
            $("#dialog").css("display", "none");
            $("#logout").css("display", "none");
            $("#add_event_trigger").css("display", "none");
}

  }, false);
  xmlHttp.send(null);
}
document.addEventListener("DOMContentLoaded", checkforlogin, false);


// For our purposes, we can keep the current month in a variable in the global scope
var currentMonth = new Month(2020, 2); // March 2020
updateCalendar();//loads the calendar immediately 
// Change the month when the "next" button is pressed
document.getElementById("next_month_btn").addEventListener("click", function(event){
        currentMonth = currentMonth.nextMonth(); // Previous month would be currentMonth.prevMonth()
        updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
}, false);


document.getElementById("prev_month_btn").addEventListener("click", function(event){
        currentMonth = currentMonth.prevMonth(); // Previous month would be currentMonth.prevMonth()
        updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML

}, false);




  document.getElementById('move').addEventListener("keyup", Move, false);
//Change the current month to any month we want
function Move() {

    if (/^\d{2}\/\d{4}$/.test($("#move").val()) && Number($("#move").val().substr(0, 2)) < 13 && Number($("#move").val().substr(0, 2)) > 0 && Number($("#move").val().substr(3, 4)) >= 1500 && Number($("#move").val().substr(3, 4)) <= 2500) {
        let count = Number($("#move").val().substr(3, 4)) - currentMonth.year;
        count = count* 12;
        count = count + (Number($("#move").val().substr(0, 2)) - currentMonth.month) - 1;
        if (count < 0) {
            for (; count < 0; count++)
                currentMonth = currentMonth.prevMonth();
        } else {
            for (; count > 0; count--)
                currentMonth = currentMonth.nextMonth();
        }
    }
    updateCalendar();

}


document.getElementById("id1").addEventListener("click", updateCalendar, false);
document.getElementById("id2").addEventListener("click", updateCalendar, false);
document.getElementById("id3").addEventListener("click", updateCalendar, false);
document.getElementById("id4").addEventListener("click", updateCalendar, false);
document.getElementById("id5").addEventListener("click", updateCalendar, false);
document.getElementById("id6").addEventListener("click", updateCalendar, false);
document.getElementById("id7").addEventListener("click", updateCalendar, false);

</script>


    </body>
    </html>

