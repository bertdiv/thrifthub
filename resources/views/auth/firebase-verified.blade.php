<x-guest-layout>

    <div class="text-center">

        <h1 class="text-2xl font-bold mb-4">
            Verifying Email...
        </h1>

        <p>
            Please wait...
        </p>

    </div>

<script type="module">

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {

    getAuth,
    onAuthStateChanged

} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

const firebaseConfig = {

    apiKey: "YOUR_API_KEY",

    authDomain: "YOUR_AUTH_DOMAIN",

    projectId: "YOUR_PROJECT_ID",

    storageBucket: "YOUR_STORAGE_BUCKET",

    messagingSenderId: "YOUR_MESSAGING_SENDER_ID",

    appId: "YOUR_APP_ID"

};

const app = initializeApp(firebaseConfig);

const auth = getAuth(app);

onAuthStateChanged(auth, async (user) => {

    if (user) {

        await user.reload();

        if (user.emailVerified) {

            // Create Laravel seller account
            const response = await fetch('/firebase-register', {

                method: 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                },

                body: JSON.stringify({

                    name: localStorage.getItem('name'),

                    email: localStorage.getItem('email'),

                    contact_number: localStorage.getItem('contact_number'),

                    address: localStorage.getItem('address'),

                    facebook_link: localStorage.getItem('facebook_link'),

                    password: localStorage.getItem('password'),

                })

            });

            const data = await response.json();

            if (data.success) {

                alert('Account created successfully!');

                window.location.href = '/login';

            }

        } else {

            alert('Email not verified yet.');

        }

    }

});

</script>

</x-guest-layout>