# CSE330
464082 Helen Jiang 466205 Zach Zhao

Zach Zhao instance:  http://ec2-107-23-252-146.compute-1.amazonaws.com/~zlzhao124/mod5/calendar.php
Helen Jiang instance: http://ec2-54-245-201-215.us-west-2.compute.amazonaws.com/~jzy/mod5/group/calendar.php


Note: we used xmlHTTP requests instead of the newer fetch() calls because one of the group members couldn't figure out how the fetch() calls worked but the xmlHTTP requests for register and login were already working, so we decided to keep going with it. I know Professor Sproul encouraged us to use fetch(), but it didn't say that was the only way to do it; as long as we are making AJAX requests smoothly and successfully we believe we should earn full points.



Creative Portion

•We added a quick-move function: if a string in the form 'MM/YYYY' is typed into a textbox and the return key is hit after that is typed, the calendar will move automatically to that month and that year. According to Connor, this is worth 5 points and we have the piazza post to prove he said that.

•Users can tag an event with a particular category and enable/disable those tags in the calendar view. (5 points) 

•Users can share specific events to other users that will display on their calendars. Once the event is shared, the shared user is free to do whatever he/she wants with that event (whether it be edit, delete, or share), and deleting the original event will not affect the shared event. Shared events are marked with a asterisk at the end of the title. I hope this is enough to earn the last 5 points, because it's very similar to creating group events. 
