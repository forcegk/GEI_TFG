const { Socket } = require('dgram');
const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server);
const { spawn, exec } = require('child_process');
const utf8 = require('utf8');
const { exit } = require('process');

// Add webpage dir
app.use(express.static('www'));

// Socket handling
io.on('connection', (socket) => {
    console.log('a user connected');
    socket.on('disconnect', () => {
        console.log('user disconnected');
        // Solo funciona en dispositivos *NIX
        exec('killall mpirun', () => {});
    });
});

io.on('connection', (socket) => {
    socket.on('spawn', (bench_name) => {
        console.log('User ' + socket.id + ' called benchmark: ' + bench_name);

        // TODO CAMBIAR EN LINUX
        // OJO IMPORTANTE HACER UN SWITCH CON BENCH NAME Y NO METERLO DIRECTO AL COMANDO
        var command;
        var params;
        switch (bench_name) {
            case 'lu':
            case 'cg':
            case 'ft':
            case 'is':
            case 'mg':
            case 'ep':
                command = 'mpirun';
                params = ['-np', '32', '--hostfile', '/mpishared/hostfile', '--mca', 'opal_warn_on_missing_libcuda', '0', `/mpishared/NPB3.4.2/NPB3.4-MPI/bin/${bench_name}.*.x`];
                break;
        
            default:
                command = 'neofetch';
                params = [];
                break;
        }
        
        /* const ping = spawn('ping', ['www.google.es', '-c5']);
        ping.stdout.on('data', (data) => {
            socket.emit('youve_got_mail', utf8.encode(data.toString()));
            //  io.emit // Para enviarlo a todos los usuarios conectados
        });

        ping.stdout.on('close', (code) => {
            socket.emit('finished_execution', utf8.encode(`Program exited with code ${Number(code)}`));
        }); */

        // mpirun -np 32 --hostfile /mpishared/hostfile --mca opal_warn_on_missing_libcuda 0 /mpishared/NPB3.4.2/NPB3.4-MPI/bin/ft.C.x
        const cmd = spawn(command, params);
        cmd.stdout.on('data', (data) => {
            socket.emit('youve_got_mail', utf8.encode(data.toString()));
            //  io.emit // Para enviarlo a todos los usuarios conectados
        });

        cmd.stdout.on('close', (code) => {
            socket.emit('finished_execution', utf8.encode(`Program exited with code ${Number(code)}`));
        });
    });

});

server.listen(3000, () =>{
    console.log('listening on *:3000');
});