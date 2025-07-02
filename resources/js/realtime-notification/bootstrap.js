window.axios = require("axios");
window.axios.defaults.baseURL = process.env.MIX_APP_URL;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error("CSRF token not found");
}

import Echo from 'laravel-echo';

if (window.Laravel.pushNotif) {
    window.io = require('socket.io-client');
    
    if (typeof io !== undefined) {
        window.Echo = new Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ":" + process.env.MIX_BROADCASTER_PORT
        });
    }
}
