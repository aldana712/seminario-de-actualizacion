import express from 'express';
import { Server } from 'socket.io';
import { createServer } from 'http';
import sqlite3 from 'sqlite3';
import CryptoJS from 'crypto-js';

const port = 8080;
const app = express();
const server = createServer(app);
const io = new Server(server);

const encryptionKey = 'my-secret-key';


app.use(express.static('client')); 

const db = new sqlite3.Database('./chatdb.sqlite', (err) => {
    if (err) {
        return console.error('Error connecting to SQLite:', err.message);
    }
    console.log('Connected to SQLite');
});

const createTableQuery = `
    CREATE TABLE IF NOT EXISTS messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        message TEXT NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    );
`;
db.run(createTableQuery, (err) => {
    if (err) throw err;
    console.log('Table created or exists already');
});


const users = {};

io.on('connection', (socket) => {
    console.log('A user has connected!');
    socket.on('login', (username) => {
        users[socket.id] = username;
        console.log(`${username} has logged in`);
        db.all('SELECT * FROM messages', (err, rows) => {
            if (err) throw err;
            socket.emit('previous messages', rows);
        });
    });

    socket.on('chat message', (msg) => {
        console.log(`Mensaje cifrado enviado: ${msg}`);
        const username = users[socket.id]; 
        const insertMessageQuery = 'INSERT INTO messages (message) VALUES (?)';
        db.run(insertMessageQuery, [msg], (err) => {
            if (err) {
                console.error('Error inserting message into the database:', err.message);
            } else {
                io.emit('chat message', { message: msg, username });
            }
        });
    });

    socket.on('disconnect', () => {
        console.log('A user has disconnected');
        delete users[socket.id]; 
    });
});

app.get('/', (req, res) => {
    res.sendFile(process.cwd() + '/client/index.html');
});

server.listen(port, () => {
    console.log(`Server running on port ${port}`);
});

process.on('SIGINT', () => {
    db.close((err) => {
        if (err) {
            console.error('Error closing the database:', err.message);
        }
        console.log('Database connection closed.');
        process.exit(0);
    });
});
