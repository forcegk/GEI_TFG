const { Socket } = require('dgram');
const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server);
const { spawn } = require('child_process');

// GET Zone
app.get('/', (req, res) => {
    res.sendFile(__dirname + '/index.html');
});

app.get('/monitoring.html', (req, res) => {
    res.sendFile(__dirname + '/monitoring.html');
});

app.get('/style.css' , (req , res)=>{
    res.sendFile(__dirname + '/style.css');
})

// Socket handling
io.on('connection', (socket) => {
    console.log('a user connected');
    socket.on('disconnect', () => {
        console.log('user disconnected');
    });
});

io.on('connection', (socket) => {
    socket.on('chat message', (msg) => {
        console.log('message: ' + msg);
        // io.emit general
        socket.emit('chat message', msg);
    });

});

io.on('connection', (socket) => {
    socket.on('spawn_1', () => {
        const ping = spawn('ping', ['www.google.es']);
        ping.stdout.on('data', (data) => {
            socket.emit('spawn_1', `${data}`);
        });

        //socket.emit('spawn_1', "test_spawn_1");
    });
});

server.listen(3000, () =>{
    console.log('listening on *:3000');
});