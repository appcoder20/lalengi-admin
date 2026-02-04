importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyCpApULsxWnp6CMUDjzjBfireomzIHf2h4",
    authDomain: "lalengi.firebaseapp.com",
    projectId: "lalengi",
    storageBucket: "lalengi.firebasestorage.app",
    messagingSenderId: "324266336176",
    appId: "1:324266336176:web:7d73028170adb3699d0075",
    measurementId: "G-M8H7LP1P48"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body ? payload.data.body : '',
        icon: payload.data.icon ? payload.data.icon : ''
    });
});