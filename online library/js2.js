$(document).ready(function(){	

   $("#myform").submit(function(){

   	  var search = $("#books").val();
   	  if(search == "")
   	  {
   	  	alert("ENTER STUFF");
   	  }
   	  else{		
   	  var url = "";
   	  var img = "";
      var title = "";
      var author = "";
      var publishedDate = "";

   	  $.get("https://www.googleapis.com/books/v1/volumes?q=" + search,function(response){

          for(i=0;i<response.items.length;i++)
          {
           title=$('<h3 class="center-align white-text"> Book Title: ' + response.items[i].volumeInfo.title + '</h5>');  
           author=$('<h3 class="center-align white-text"> By: ' + response.items[i].volumeInfo.authors + '</h5>');
           publishedDate=$('<h3 class="center-align white-text"> Publish Date:  '+response.items[i].volumeInfo.publishedDate+'</h5>');
           img = $('<img class="aligning card z-depth-5" id="dynamic"><br><a href=' + response.items[i].volumeInfo.infoLink + '><button id="imagebutton" class="btn red aligning">Read More</button></a>'); 	
           url= response.items[i].volumeInfo.imageLinks.thumbnail;
           img.attr('src', url);
           title.appendTo('#result');
           author.appendTo('#result');
           publishedDate.appendTo('#result');
           img.appendTo('#result');
          }
   	  });
      
      }
      return false;
   });

});