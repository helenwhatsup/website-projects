$( document ).ready(function() {
    //citation: https://codingshiksha.com/google-books-api-pagination-example-in-javascript
    
	//Variables
	var _searchText; //variable to store the text the user inserted in the text box
	var _apiKey = '&key=' + config.MY_KEY; //variable containing the last parameter of the GET request and the API key
	var _apiURL = "https://www.googleapis.com/books/v1/volumes?q="; //variable containing the URL for the GET request
	var _searchType=""; //variable to define the type of search: author name or title
	var _orderType =""; //Variable that controls the results order - Relevance or Publish Date
	
	
//function that handles the event after clicking "Search" or pressing ENTER key
$( "#form" ).submit(function( event ) {
	clearv();
	_searchText = $("#form input:text").val(); //get the text value to be used as a search paramenter
	switch ($("#type").val()){
		case "Author":
			_searchType = "+inauthor";
			break;
		case "Title":
			_searchType ="";
			break;
		default:
			_searchType ="";
	}
	switch ($("#order").val()){
		case "Relevance":
			_orderType = "";
			break;
		case "Publish Date":
			_orderType = "&orderBy=newest";
			break;
		default:
			_orderType = "";
	}
	//tests if the text box is empty
	if (_searchText ==""){
		//first clean all the things!
		cleanTotalResults();
		clear();
		clearv();
		//tell the user no text was found
		$("#result").append("No Book was found!");
	}else{//text box is not empty, procceed with search
	requestBooks(_searchText,_searchType,_orderType);}
  event.preventDefault();
}); //Submit event

function requestBooks(_searchText,_searchType,_orderType){
	//----Sending the GET request----
	var _xhr = new XMLHttpRequest(); //initializing the XMLHttpRequest object
	//defining the request: type GET, URL made up from the variables defined earlier, true means asychronous
	var _url = _apiURL+_searchText+_searchType+_apiKey+_orderType; //defining the URL to send
	_xhr.open('GET', _url, true);
	_xhr.send(); //sends the request
	//creating an event listener tied to the "readystatechange" that launches the "processRequest" function
 	_xhr.addEventListener("readystatechange", processRequest, false); 
	function processRequest(e) {
		//readystate = 4 means Data is ready to be proccessed
		if (_xhr.readyState == 4 && _xhr.status == 200) {
			var _response = JSON.parse(_xhr.responseText); //transform the response text into a JSON object
			displayResults(_response);
		}
	}
	
} 


function displayResults(_response){
	clear();
	console.log(_response)
	for (i=0;i<_response.items.length;i++){
				
				$("#result").append('<h3 class="center-align white-text"> Book Title: ');//inserts the text "Title" into the DOM
				$("#result").append("<div class ='bookTitle'>"+_response.items[i].volumeInfo.title+"</div>");//fetches the title from the GET request and inserts in the DOM
				$("#result").append('<h3 class="center-align white-text"> Author: ');//inserts the text "Author" into the DOM
				$("#result").append("<div class ='bookAuthor'>"+_response.items[i].volumeInfo.authors+"</div>");//fetches the Author from the GET request and inserts in the DOM
				$("#result").append('<h3 class="center-align white-text"> Publish Date:  ');//inserts the text "Published Date" into the DOM
				$("#result").append("<div class ='bookPublish'>"+_response.items[i].volumeInfo.publishedDate+"</div>");//fetches the Puslished Date from the GET request and inserts in the DOM
				img = $('<img class="aligning card z-depth-5" id="dynamic"><br><a href=' + _response.items[i].volumeInfo.infoLink + '><button id="imagebutton" class="btn red aligning">Read More</button></a>'); 	
           url= _response.items[i].volumeInfo.imageLinks.thumbnail;
           img.attr('src', url);
           img.appendTo('#result');
           
			}
} //displayResults


//function that cleans the interface in order to display new Books data
function clear(){
	$("#result").empty();
}	

//function that cleans the variables for a new search.
function clearv(){
	_searchText ="";
	_searchType=""; 
}

}); //Document ready
