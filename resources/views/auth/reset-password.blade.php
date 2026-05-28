<x-guest-layout>

<div class="mb-4 text-sm text-gray-600">
    Forgot your password?
    Enter your email and Firebase will send
    a reset link.
</div>

<form id="resetForm">

    <div>

        <x-input-label
            for="email"
            :value="__('Email')" />

        <x-text-input
            id="email"
            class="block mt-1 w-full"
            type="email"
            name="email"
            required />

    </div>

    <div class="flex items-center justify-end mt-4">

        <x-primary-button>

            Send Reset Link

        </x-primary-button>

    </div>

</form>

<script type="module">

import { initializeApp }
from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {
    getAuth,
    sendPasswordResetEmail
}
from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

const firebaseConfig = {

    apiKey: "AIzaSyC0NVxBhA7Lxq6ZgZNuRkLmhIZEQj7UzG0",

    authDomain: "thrifthub-142be.firebaseapp.com",

    projectId: "thrifthub-142be",

    storageBucket: "thrifthub-142be.firebasestorage.app",

    messagingSenderId: "32277704559",

    appId: "1:32277704559:web:b704953c491d72a3cd429a"

};

const app = initializeApp(firebaseConfig);

const auth = getAuth(app);

document.getElementById('resetForm')
.addEventListener('submit', async (e) => {

    e.preventDefault();

    const email =
        document.getElementById('email').value;

    try {

        await sendPasswordResetEmail(
            auth,
            email
        );

        alert(
            'Password reset email sent!'
        );

    } catch (error) {

        alert(error.message);

    }

});

</script>

</x-guest-layout>
```
