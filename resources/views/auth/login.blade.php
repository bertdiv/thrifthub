<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <!-- Back Button -->
    <div class="mb-4">

    </div>

    <!-- Error Message -->
    <div
        id="errorMessage"
        class="hidden mb-4 text-sm text-red-600"
    ></div>

    <!-- LOGIN FORM -->
    <form id="loginForm">

        @csrf

        <!-- Email -->
        <div>

            <x-input-label
                for="email"
                :value="__('Email')"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                required
                autofocus
            />

        </div>

        <!-- Password -->
        <div class="mt-4">

            <x-input-label
                for="password"
                :value="__('Password')"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
            />

            <!-- Show Password -->
            <div class="mt-2 flex items-center">

                <input
                    type="checkbox"
                    id="showPassword"
                    onclick="togglePassword()"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                >

                <label
                    for="showPassword"
                    class="ms-2 text-sm text-gray-600"
                >
                    Show Password
                </label>

            </div>

        </div>

        <!-- Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-6 gap-3">

    <!-- Back to Home -->
    <a href="/"
       class="text-sm text-gray-500 hover:text-gray-700">

        ← Back to Home

    </a>

    <div class="flex flex-col sm:flex-row items-center gap-3">

        <!-- Forgot Password -->
        @if (Route::has('password.request'))

            <a
                class="underline text-sm text-gray-500 hover:text-gray-700"
                href="{{ route('password.request') }}"
            >
                Forgot your password?
            </a>

        @endif

        <!-- Login Button -->
        <x-primary-button id="loginBtn">

            Log in

        </x-primary-button>

    </div>

</div>

    </form>

</x-guest-layout>

<!-- TOGGLE PASSWORD -->
<script>

function togglePassword() {

    const input =
        document.getElementById('password');

    input.type =
        input.type === 'password'
        ? 'text'
        : 'password';

}

</script>

<!-- FIREBASE LOGIN -->
<script type="module">

import { initializeApp }
from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {

    getAuth,
    signInWithEmailAndPassword

}
from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

// FIREBASE CONFIG
const firebaseConfig = {

    apiKey: "AIzaSyC0NVxBhA7Lxq6ZgZNuRkLmhIZEQj7UzG0",

    authDomain: "thrifthub-142be.firebaseapp.com",

    projectId: "thrifthub-142be",

    storageBucket: "thrifthub-142be.appspot.com",

    messagingSenderId: "32277704559",

    appId: "1:32277704559:web:b704953c491d72a3cd429a"

};

// INITIALIZE
const app = initializeApp(firebaseConfig);

const auth = getAuth(app);

// FORM
const form =
    document.getElementById('loginForm');

const errorMessage =
    document.getElementById('errorMessage');

const loginBtn =
    document.getElementById('loginBtn');

// SUBMIT
form.addEventListener('submit', async (e) => {

    e.preventDefault();

    errorMessage.classList.add('hidden');

    const email =
        document.getElementById('email').value;

    const password =
        document.getElementById('password').value;

    loginBtn.disabled = true;

    loginBtn.innerText = 'Logging in...';

    try {

        // FIREBASE LOGIN
        await signInWithEmailAndPassword(

            auth,
            email,
            password

        );
        const user = auth.currentUser;

await user.reload();

if (!user.emailVerified) {

    alert(
        'Please verify your email first.'
    );

    return;

}

        // LARAVEL LOGIN
        const response = await fetch(

            '/firebase-login',

            {

                method: 'POST',

                headers: {

                    'Content-Type':
                        'application/json',

                    'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content

                },

                body: JSON.stringify({

                    email: email

                })

            }

        );

        const result =
            await response.json();

        if (result.success) {

            window.location.href =
                '/dashboard';

        } else {

            throw new Error(
                'Laravel login failed.'
            );

        }

    } catch (error) {

        console.error(error);

        errorMessage.innerText =
            error.message;

        errorMessage.classList.remove('hidden');

    } finally {

        loginBtn.disabled = false;

        loginBtn.innerText = 'Log in';

    }

});

</script>