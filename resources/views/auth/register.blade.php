<x-guest-layout>

<form id="registerForm" class="px-2 sm:px-0">
    @csrf

    <!-- Hidden Role -->
    <input type="hidden" name="role" value="seller">

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Full Name')" />

        <x-text-input id="name"
                      class="block mt-1 w-full"
                      type="text"
                      name="name"
                      required
                      autofocus />

        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email Address')" />

        <x-text-input id="email"
                      class="block mt-1 w-full"
                      type="email"
                      name="email"
                      required />

        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Contact Number -->
    <div class="mt-4">
        <x-input-label for="contact_number" :value="__('Contact Number')" />

        <x-text-input id="contact_number"
                      class="block mt-1 w-full"
                      type="text"
                      name="contact_number"
                      placeholder="09XXXXXXXXX"
                      required />

        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
    </div>

    <!-- Address -->
    <div class="mt-4">
        <x-input-label for="address" :value="__('Address')" />

        <x-text-input id="address"
                      class="block mt-1 w-full"
                      type="text"
                      name="address"
                      required />

        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <!-- Facebook Link -->
    <div class="mt-4">
        <x-input-label for="facebook_link" :value="__('Facebook Link (Optional)')" />

        <x-text-input id="facebook_link"
                      class="block mt-1 w-full"
                      type="url"
                      name="facebook_link"
                      placeholder="https://facebook.com/yourprofile" />

        <x-input-error :messages="$errors->get('facebook_link')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password"
                      class="block mt-1 w-full"
                      type="password"
                      name="password"
                      required />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation"
                      class="block mt-1 w-full"
                      type="password"
                      name="password_confirmation"
                      required />
    </div>

    <!-- Show Password -->
    <div class="mt-4 flex items-center">

        <input type="checkbox"
               id="showPassword"
               onclick="togglePasswords()"
               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">

        <label for="showPassword" class="ms-2 text-sm text-gray-600">
            Show Password
        </label>

    </div>

    <!-- Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-6 gap-3">

        <a href="/"
           class="text-sm text-gray-500 hover:text-gray-700">
            ← Back to Home
        </a>

        <div class="flex flex-col sm:flex-row items-center gap-3">

            <a class="underline text-sm text-gray-500 hover:text-gray-700"
               href="{{ route('login') }}">
                Already registered?
            </a>

            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">

                Register

            </button>

        </div>

    </div>

</form>

<script type="module">

import { initializeApp }
from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {

    getAuth,
    createUserWithEmailAndPassword,
    sendEmailVerification

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

// INITIALIZE FIREBASE
const app = initializeApp(firebaseConfig);

const auth = getAuth(app);

// SHOW/HIDE PASSWORD
window.togglePasswords = function () {

    const password =
        document.getElementById('password');

    const confirm =
        document.getElementById(
            'password_confirmation'
        );

    const type =
        password.type === 'password'
        ? 'text'
        : 'password';

    password.type = type;

    confirm.type = type;

};

// REGISTER FORM
document.getElementById("registerForm")
.addEventListener("submit", async function (e) {

    e.preventDefault();

    // GET VALUES
    const name =
        document.getElementById('name').value;

    const email =
        document.getElementById('email').value;

    const contact_number =
        document.getElementById(
            'contact_number'
        ).value;

    const address =
        document.getElementById('address').value;

    const facebook_link =
        document.getElementById(
            'facebook_link'
        ).value;

    const password =
        document.getElementById('password').value;

    const password_confirmation =
        document.getElementById(
            'password_confirmation'
        ).value;

    // CHECK PASSWORD MATCH
    if (password !== password_confirmation) {

        alert("Passwords do not match.");

        return;

    }

    try {

        // CREATE FIREBASE ACCOUNT
        const userCredential =
            await createUserWithEmailAndPassword(

                auth,
                email,
                password

            );

        const user = userCredential.user;

        // SEND EMAIL VERIFICATION
        await sendEmailVerification(user);

        // SAVE USER TO LARAVEL DATABASE
        const response = await fetch(
            '/save-user',
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

                    name: name,

                    email: email,

                    contact_number: contact_number,

                    address: address,

                    facebook_link: facebook_link,

                    firebase_uid: user.uid,

                    role: 'seller'

                })

            }
        );

        const result = await response.json();

        if (!result.success) {

            throw new Error(
                'Failed to save user.'
            );

        }

        // SUCCESS
        alert(
            "Verification email sent! Please check your Gmail inbox or Spam Folder."
        );

        // REDIRECT
        window.location.href =
            "/firebase-verified";

    } catch (error) {

        console.error(error);

        let message = '';

        switch (error.code) {

            case 'auth/email-already-in-use':

                message =
                    'Email already registered.';
                break;

            case 'auth/invalid-email':

                message =
                    'Invalid email address.';
                break;

            case 'auth/weak-password':

                message =
                    'Password should be at least 6 characters.';
                break;

            default:

                message = error.message;

        }

        alert(message);

    }

});

</script>

</x-guest-layout>