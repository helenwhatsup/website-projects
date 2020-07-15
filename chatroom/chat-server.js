var http = require("http"),
socketio = require("socket.io"),
fs = require("fs");

// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
var app = http.createServer(function(req, resp){
// This callback runs when a new connection is made to our HTTP server.

fs.readFile("client.html", function(err, data){
        // This callback runs when the client.html file has been read from the filesystem.        
        if(err) return resp.writeHead(500);
        resp.writeHead(200);
        resp.end(data);
        });
});
app.listen(3456);
var allUsers={}; //object of users, will contain username and current room
var usersarray = [];//array of users, used to iterate through to find a certain name sometimes
var allRooms = [{'roomName':'lobby', 'creator': ' '},{'roomName':'sampleroom', 'creator': ' '}]; //a json of all rooms. the lobby and a sample room have been added initally.
var socketIDs = {};//IDs of sockets must be stored so one specific socket can be target for private message, kick, and ban

// Do the Socket.IO magic:
var io = socketio.listen(app);
io.sockets.on("connection", function(socket){
		// This callback runs when a new Socket.IO connection is established.
		
		//some of the code this newUser blockwas inspired by this link:  
		//http://psitsmike.com/2011/10/node-js-and-socket-io-multiroom-chat-tutorial/
        socket.on('newUser', function(username){
                //every time a new user is added, store their relevant information and update who is in the room
                var userInvalid = false;
		//if a username is "" or it matches a current username, it is invalid
                if (username == null || username == "") {
            		userInvalid = true;
                }
		 for (var user in usersarray){
			if (usersarray[user] == username){
				userInvalid = true;
			}
		}
                if (!userInvalid){
			var newUser={}; //want to store current room and username inside one variable, and then store that one into a json of usernames
			socketIDs[username] = socket.id;
                        socket.currentUser = username;
			socket.bans = '';
                        newUser.name = username;
                        socket.currentRoom = 'lobby';
                        socket.join('lobby');
                        socket.broadcast.to('lobby').emit('update', username + ' has connected');
                        socket.emit('updateRoom', allRooms, 'lobby');
                        newUser.room= socket.currentRoom;
                        allUsers[username] = newUser;
			usersarray.push(username);
                for (var user in usersarray){
                        if (io.sockets.connected[socketIDs[usersarray[user]]]) {
                        console.log(user);
                        let socket = io.sockets.connected[socketIDs[usersarray[user]]];
                        if (socket.currentRoom == 'lobby'){//updates everyone in the lobby that someone has arrived (updates the namelist here)
                            socket.emit("getUserList",  { users: allUsers, room: 'lobby' });
                                }
                        }
                }
                }
        });

        socket.on('message_to_server', function(data) {
                // This callback runs when the server receives a new message from the client.
                        console.log(socket.currentUser+": "+data.message); // log it to the Node.JS output
                        io.sockets.in(socket.currentRoom).emit("message_to_client", socket.currentUser, {message:data.message }); // broadcast the message to other users

        });
	//updates the userlist of users in a current room
	socket.on("updateUser", function (data) { // process update user info and send it back to server side
	        io.sockets.emit("getUserList", { users: allUsers, room: socket.currentRoom });
	});


        socket.on("switchRoom", function(newRoom){
                                //switchRoom code was also inspired by http://psitsmike.com/2011/10/node-js-and-socket-io-multiroom-chat-tutorial/
		//this is for switching in and out of rooms. Update all the relevant user information
                //and update who is in the room you just entered and broadcast to everyone in the previous room you left
		var oldRoom = socket.currentRoom
		if (socket.bans.includes(", " + newRoom)){
			//failure because banned
			socket.emit('update', 'You are banned from this room!');
		}

		        else{
	        socket.leave(socket.currentRoom);
	        socket.join(newRoom);
	        console.log('join');
	        allUsers[socket.currentUser].room = newRoom;
	        console.log(allUsers);
		//switching process
	        console.log("now a user has switched from" + oldRoom + " to " + allUsers[socket.currentUser].room);
	        socket.emit('update', 'you have connected to ' +newRoom);
	        socket.broadcast.to(socket.currentRoom).emit('update', socket.currentUser + ' has left this room');
	        socket.currentRoom = newRoom;
	        socket.broadcast.to(newRoom).emit('update', socket.currentUser + ' has joined this room');
		for (var user in usersarray){
                   //     console.log(usersarray[user]);
                        if (io.sockets.connected[socketIDs[usersarray[user]]]) {
                        console.log(user);
			//must update room lists for both the old room and the new room
                        let socket = io.sockets.connected[socketIDs[usersarray[user]]];
                        if (socket.currentRoom == newRoom){
                            socket.emit("getUserList",  { users: allUsers, room: newRoom });
                                }
			else if (socket.currentRoom == oldRoom){
                            socket.emit("getUserList",  { users: allUsers, room: oldRoom });
                                }
                        }
                }
	        socket.emit('updateRoom', allRooms, newRoom);
	        }
        });

	//adds a new room to the chat
        socket.on("addRoom", function(addRoom){
		var validname = true;
		for(var i=0; i<allRooms.length; i++){
			if(allRooms[i].roomName == addRoom){
				validname = false;
			}
		}
		if (validname){
                allRooms.push({roomName:addRoom , creator:socket.currentUser});
                console.log(allRooms);
                io.emit('updateRoom', allRooms, socket.currentRoom);
			}
		});
	//creative portion: the creator of a chat room can change the name of the room
	socket.on("changename", function(oldName, newName){
		var changed = false;
		for(var i=0; i<allRooms.length; i++){ //checking for creator
           		if(allRooms[i].roomName == oldName && allRooms[i].creator == socket.currentUser){
				allRooms[i].roomName = newName;
				io.emit('updateRoom', allRooms, socket.currentRoom);
				console.log("name of " + oldName + " changed to " + newName);
				changed = true;
				}
			}

		if (changed){ //"moves" all users currently in the room to the newly named same room by resetting variables 
		for (var user in usersarray){
			console.log(usersarray[user]);
			if (io.sockets.connected[socketIDs[usersarray[user]]]) {
			console.log(user);
			let socket = io.sockets.connected[socketIDs[usersarray[user]]];
			if (socket.currentRoom == oldName){
				console.log(user + "currently in " + socket.currentRoom);
				socket.leave(socket.currentRoom);
		                socket.join(newName);
				socket.currentRoom = newName;
				}
				socket.emit('updateRoom', allRooms, socket.currentRoom);
				socket.emit("getUserList",  { users: allUsers, room: newName });	
			}
		}
		}

		});


        socket.on("removeRoom", function (data) { 
            var rmName = data["roomName"];
                for(var i=0; i<allRooms.length; i++){
                if (allRooms[i].roomName == rmName) {
                    if (allRooms[i].creator == socket.currentUser) {
			//removes the room name from the array of rooms
		     allRooms.splice(allRooms.indexOf(rmName), 1);
			//sends all people in the room to the lobby to empty the room
                     for (var user in usersarray){
                        console.log(usersarray[user]);
                        if (io.sockets.connected[socketIDs[usersarray[user]]]) {
                        console.log(user);
                        let socket = io.sockets.connected[socketIDs[usersarray[user]]];
                        if (socket.currentRoom == rmName){
                                console.log(user + "currently in " + socket.currentRoom);
                                socket.leave(socket.currentRoom);
                                socket.join('lobby');
                                socket.currentRoom = 'lobby';
				allUsers[usersarray[user]].room = 'lobby';
                           //  updates userlists and roomlists for users 
                                socket.emit("getUserList",  { users: allUsers, room: 'lobby' });
                socket.broadcast.to("lobby").emit("getUserList",  { users: allUsers, room: 'lobby' });
					}
				socket.emit('updateRoom', allRooms, socket.currentRoom);
                                }
                         }  
			//sends a success message to the chat log
                       io.sockets.emit("removesuccess", { currentRoom: rmName });
                    }
                    else{
                        console.log("Only the creator of the room can delete!")
                    }

                }
            }
        
        });


//activates when someone tries to enter a room with a password
socket.on("privateRoom", function(privateRoom){
                //every private room should open a prompt onclick, redirect to that function in the html
                for(var i=0; i<allRooms.length; i++){
                        console.log(allRooms[i].hasOwnProperty('password'));
                        if(allRooms[i].roomName == privateRoom){
				//emits joinpwd which checks their input with the password
                                if(allRooms[i].hasOwnProperty('password')){
                                        socket.emit('joinpwd', allRooms[i]);
                                }
                        }
                }
        });
//creates a room with a password
socket.on("newRoomPW", function (data) {// create new Private room 
        var rmName = data["roomName"];
        var rmPW = data["roomPW"];
        console.log(rmName);
        allRooms.push({roomName:rmName , creator:socket.currentUser, password:rmPW});
        console.log(allRooms);
        io.emit('updateRoom', allRooms, socket.currentRoom);
        });


	//private message someone in the same room as you
	socket.on("pm", function(receiver, data){
		if (io.sockets.connected[socketIDs[receiver]]) {
		console.log(socket.currentUser+": "+data.message + "private"); // log it to the Node.JS output
		var sender = socket.currentUser;
		if (socket.currentRoom == allUsers[receiver].room){
		socket.broadcast.to(socketIDs[receiver]).emit('pm2', sender, {message:data.message});
		}}
	});

	socket.on("kickuser", function(username){
		//temporarily kick a user to the lobby
	if (io.sockets.connected[socketIDs[username]]) {
        for(var i=0; i<allRooms.length; i++){
		//finds the socket to be kicked out a roo
            if(allRooms[i].roomName == socket.currentRoom && allRooms[i].creator == socket.currentUser && allUsers[username].room == socket.currentRoom){
//		if (io.sockets.connected[socketIDs[username]]) {
		oldRoom = allUsers[username].room;
		let socket = io.sockets.connected[socketIDs[username]];
		socket.leave(allUsers[username].room);
		socket.join("lobby");
	        socket.currentRoom = 'lobby';
		socket.emit('updateRoom', allRooms, "lobby");
        	//that user joins the lobby, then we have to update to everyone in both chatrooms about the removal and addition of someone, respectively
		io.sockets.connected[socketIDs[username]].emit('update', 'you were kicked to the lobby');
		socket.broadcast.to(allUsers[username].room).emit('update', socket.currentUser + ' has left this room');
		socket.broadcast.to("lobby").emit('update', socket.currentUser + ' has joined this room');
		allUsers[username].room = 'lobby';
		socket.emit('updateRoom', allRooms, "lobby");
		socket.emit("getUserList",  { users: allUsers, room: 'lobby' });
                for (var user in usersarray){
                   //     console.log(usersarray[user]);
                        if (io.sockets.connected[socketIDs[usersarray[user]]]) {
                        console.log(user);
                        let socket = io.sockets.connected[socketIDs[usersarray[user]]];
                        if (socket.currentRoom == 'lobby'){
			    console.log('trying to display lobby');
                            socket.emit("getUserList",  { users: allUsers, room: 'lobby' });
                                }
                        else if (socket.currentRoom == oldRoom){ 
                            socket.emit("getUserList",  { users: allUsers, room: oldRoom });
                                }
                        }
                }

//		socket.emit("getUserList",  { users: allUsers, room: 'lobby' });
		console.log("kicked a user. " + allUsers[username].room);
			}
			}
		}		
	});

        socket.on("banuser", function(username){
                //basically the same as kickuser, but we concatonate the banned chatroom to socket.bans
	 if (io.sockets.connected[socketIDs[username]]) {
        for(var i=0; i<allRooms.length; i++){
            if(allRooms[i].roomName == socket.currentRoom && allRooms[i].creator == socket.currentUser && allUsers[username].room == socket.currentRoom){
		oldRoom = allUsers[username].room;
                let socket = io.sockets.connected[socketIDs[username]];
                socket.leave(allUsers[username].room);
                socket.join("lobby");
                socket.currentRoom = 'lobby';
	
                socket.emit('updateRoom', allRooms, "lobby");

                io.sockets.connected[socketIDs[username]].emit('update', 'you were kicked to the lobby');
                socket.broadcast.to(allUsers[username].room).emit('update', socket.currentUser + ' has left this room');
                socket.broadcast.to("lobby").emit('update', socket.currentUser + ' has joined this room');
		socket.bans = socket.bans + ", " + allUsers[username].room;
                socket.emit('updateRoom', allRooms, "lobby");
                console.log("banned a user. " + allUsers[username].room);
		allUsers[username].room = 'lobby';
                for (var user in usersarray){
                   //     console.log(usersarray[user]);
                        if (io.sockets.connected[socketIDs[usersarray[user]]]) {
                        console.log(user);
                        let socket = io.sockets.connected[socketIDs[usersarray[user]]];
                        if (socket.currentRoom == 'lobby'){
                            socket.emit("getUserList",  { users: allUsers, room: 'lobby' });
                                }
                        else if (socket.currentRoom == oldRoom){
                            socket.emit("getUserList",  { users: allUsers, room: oldRoom });
                                }
                        }
                }

//		socket.emit("getUserList",  { users: allUsers, room: 'lobby' });
		console.log("current bans of " + socket.currentUser + " " + socket.bans);
                        }
			}
                }
        });

	socket.on("disconnectuser", function(username){ //creative portion: completely disconnects/freezes a user. they cannot chat anymore, and their name should be erased.
		if (io.sockets.connected[socketIDs[username]]) {
			oldRoom = allUsers[username].room;
			io.sockets.connected[socketIDs[username]].disconnect();
                for (var user in usersarray){
                   //     console.log(usersarray[user]);
                        if (io.sockets.connected[socketIDs[usersarray[user]]]) {
                        console.log(user);
                        let socket = io.sockets.connected[socketIDs[usersarray[user]]];
                        if (socket.currentRoom == oldRoom){
                            socket.emit("getUserList",  { users: allUsers, room: oldRoom });
                                }
                        }
                }
		}
	});

	
		//disconnect code was also inspired by http://psitsmike.com/2011/10/node-js-and-socket-io-multiroom-chat-tutorial/
        socket.on('disconnect', function(){
			delete allUsers[socket.username];
			socket.broadcast.emit('update', socket.username + ' has disconnected');
			socket.leave(socket.room);
        });
});
