<x-guest-layout>

<div class="flex flex-col items-center justify-center min-h-[60vh]">

    <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gray-900"></div>

    <h1 class="mt-6 text-2xl font-bold">
        Waiting for Email Verification
    </h1>

    <p class="mt-2 text-gray-600">
        Verify your email in Gmail...
    </p>

</div>

<script type="module">

import { initializeApp }
from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {
    getAuth,
    onAuthStateChanged
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

onAuthStateChanged(auth, (user) => {

    if (!user) {

        window.location.href = "/register";

        return;
    }

    const checker = setInterval(async () => {

        await user.reload();

        if (user.emailVerified) {

            clearInterval(checker);

            try {

                const response =
                    await fetch(
                        '/firebase-register',
                        {
                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

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
                        }
                    );

                const data =
                    await response.json();

                if (data.success) {

                    localStorage.clear();

                    window.location.href =
                        "/login";
                }

            } catch (error) {

                console.log(error);

                alert(
                    "Failed to create account."
                );

            }
        }

    }, 1000);

});

</script>

</x-guest-layout>
```
