import { io } from 'https://cdn.socket.io/4.3.2/socket.io.esm.min.js';

const socket = io();
const encryptionKey = 'my-secret-key';
const loginForm = document.getElementById('login-form');
const chatSection = document.getElementById('chat');
const form = document.getElementById('form');
const input = document.getElementById('input');
const messages = document.getElementById('messages');


loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const username = document.getElementById('username').value;
    socket.emit('login', username);
    loginForm.style.display = 'none'; 
    chatSection.style.display = 'flex';
});


socket.on('previous messages', (msgs) => {
    msgs.forEach((msg) => {
        const decryptedMsg = CryptoJS.AES.decrypt(msg.message, encryptionKey).toString(CryptoJS.enc.Utf8);
        const item = `<li>${decryptedMsg}</li>`;
        messages.insertAdjacentHTML('beforeend', item);
    });
});


socket.on('chat message', (data) => {
    const decryptedMsg = CryptoJS.AES.decrypt(data.message, encryptionKey).toString(CryptoJS.enc.Utf8);
    
    const item = `<li><strong>${data.username}:</strong> ${decryptedMsg}</li>`;
    messages.insertAdjacentHTML('beforeend', item);
    messages.scrollTop = messages.scrollHeight; 
});

form.addEventListener('submit', (e) => {
    e.preventDefault();
    if (input.value) {
      
        const encryptedMessage = CryptoJS.AES.encrypt(input.value, encryptionKey).toString();
        socket.emit('chat message', encryptedMessage); 
        input.value = ''; 
    }
});
