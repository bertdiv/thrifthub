```blade
<x-guest-layout>

<div class="text-center py-10">

    <h1 class="text-2xl font-bold mb-4">
        Verifying your email...
    </h1>

    <p class="text-gray-600">
        Please wait...
    </p>

</div>

<script type="module">

import { initializeApp }
from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {

    getAuth,
    onAuthStateChanged

} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

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

onAuthStateChanged(auth, async (user) => {

    if (!user) {

        alert("No Firebase user found.");

        window.location.href = "/register";

        return;
    }

    // Reload user to refresh verification state
    await user.reload();

    if (!user.emailVerified) {

        alert("Please verify your email first.");

        return;
    }

    try {

        const response = await fetch('/firebase-register', {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'Accept': 'application/json',

                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'

            },

            body: JSON.stringify({

                name:
                    localStorage.getItem('name'),

                email:
                    localStorage.getItem('email'),

                contact_number:
                    localStorage.getItem('contact_number'),

                address:
                    localStorage.getItem('address'),

                facebook_link:
                    localStorage.getItem('facebook_link'),

                password:
                    localStorage.getItem('password')

            })

        });

        const data = await response.json();

        console.log(data);

        if (data.success) {

            // Clear temp storage
            localStorage.removeItem('name');

            localStorage.removeItem('email');

            localStorage.removeItem('contact_number');

            localStorage.removeItem('address');

            localStorage.removeItem('facebook_link');

            localStorage.removeItem('password');

            alert(
                'Account created successfully!'
            );

            window.location.href = '/login';

        } else {

            alert('Registration failed.');

        }

    } catch (error) {

        console.log(error);

        alert(
            'Something went wrong while creating account.'
        );

    }

});

</script>

</x-guest-layout>
```
