# CSE330
466205 (Zach Zhao)
464082 (Helen Jiang)

Link to project:
http://ec2-54-245-201-215.us-west-2.compute.amazonaws.com/~jzy/mod7




Zach Zhao and Helen Jiang

Ebook management site:
(similar to story sharing site in mod 3 but with additional features and more programming languages used)

Submitted rubric (5 points)
I hope we’re not too late!

Languages/Frameworks used (10 points)
10 - Collection of APIs: Google Book,Google Location and Dark Sky
0 - MySQL Database
0- PHP
0- HTML

Functionality (58 points)
User Management (15 Points):
1) user can register and login (5 points)
2) Passwords are hashed, salted, and checked. (3 points) 
3) Users can edit and delete his own book but not other user’s book.(7 points)

Book Management (43 points):
4) User can search and browse books from all over the internet, and being redirect to Google Book and read the book content when click on ReadMore. User can also search for weather (10 points)

5) users can enter the book information that they've already owned and upload a picture. (8points)
book name (2pts)
Author (2pts)
public year (2pts)
category (2pts)

information above can also be viewed in mySQL database

6) users can enter the book information that they would like to buy (book name, Author, publish year, category). (8 points)
book name (2pts)
Author (2pts)
publish year (2pts)
category (2pts)
information above can also be viewed in mySQL database

7）user can view two lists of the books (books they owned, books they want to buy) (5 points)

8) A more detailed information such as book abstract and ISBN # will be displayed while clicking on the book title.(3 points)

9 ) Users can sort the book list based on category(3 points)

10) Users can delete book name and its description.(4 points) 

11)  Users can log out(2 points)

Best Practices (7 Points):
Code is well formatted and easy to read, with proper commenting (2 points)
Safe from SQL Injection attacks (2 points)
CSRF Tokens used when modifying book information (2 points)
All HTML pages pass the W3C HTML and CSS validators (1 point)

Usability/Style (5 Points):
Site is intuitive to use and navigate (3 points)
Site is visually appealing with proper interactive features(2 points)

Creative Portion (15 points) 

1)Provide services for unregistered/logged-out users (5 points)  
-View list of books but cannot do anything with the list (2.5) 
-Search for books on home page (2.5)
 2)Users can see each other’s profiles with a list of books they own and want to buy (5 points)
  3)The Search for Books can be sorted by Author or Title, and by Relevance or Date Published (5 points) 

