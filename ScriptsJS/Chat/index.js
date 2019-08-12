var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
    res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
    // Usuários online
    // console.log(socket.broadcast.server.engine.clientsCount);
    // console.log('a user connected');
    socket.on('disconnect', function(){
        // console.log('user disconnected');
    });

    socket.on('chat-message', function(msg){
        io.emit('chat-message', msg);
    });
});

http.listen(3000, function(){
    console.log('listening on *:3000');
});