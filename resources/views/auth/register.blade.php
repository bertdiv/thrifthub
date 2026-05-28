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
                      :value="old('name')"
                      required
                      autofocus
                      autocomplete="name" />

        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email Address')" />

        <x-text-input id="email"
                      class="block mt-1 w-full"
                      type="email"
                      name="email"
                      :value="old('email')"
                      required
                      autocomplete="username" />

        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Contact Number -->
    <div class="mt-4">
        <x-input-label for="contact_number" :value="__('Contact Number')" />

        <x-text-input id="contact_number"
                      class="block mt-1 w-full"
                      type="text"
                      name="contact_number"
                      :value="old('contact_number')"
                      placeholder="09XXXXXXXXX"
                      required />

        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
    </div>

    <!-- Address -->
    <div class="mt-4">
        <x-input-label for="address" :value="__('Address (Optional)')" />

        <x-text-input id="address"
                      class="block mt-1 w-full"
                      type="text"
                      name="address"
                      :value="old('address')" />

        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <!-- Facebook Link -->
    <div class="mt-4">
        <x-input-label for="facebook_link" :value="__('Facebook Link (Optional)')" />

        <x-text-input id="facebook_link"
                      class="block mt-1 w-full"
                      type="url"
                      name="facebook_link"
                      :value="old('facebook_link')"
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
                      required
                      autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation"
                      class="block mt-1 w-full"
                      type="password"
                      name="password_confirmation"
                      required
                      autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- Show Password Checkbox -->
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

        <!-- Back to Home (lighter) -->
        <a href="/"
           class="text-sm text-gray-300 hover:text-gray-7where /R C:\ git.exe00 text-center sm:text-left">
            ← Back to Home
        </a>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">

            <!-- Already registered (lighter but visible) -->
            <a class="underline text-sm text-gray-300 hover:text-gray-700 text-center sm:text-left"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <!-- Register centered text -->
            <div class="w sm:w-auto flex justify-center">
                <button type="submit"
    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto justify-center">
    Register
</button>
            </div>

        </div>

    </div>

</form>

<script type="module">

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {

    getAuth,
    createUserWithEmailAndPassword,
    sendEmailVerification

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

window.togglePasswords = function () {

    const password = document.getElementById('password');

    const confirm = document.getElementById('password_confirmation');

    const type = password.type === 'password'
        ? 'text'
        : 'password';

    password.type = type;

    confirm.type = type;
};

document.querySelector("form").addEventListener("submit", async function (e) {

    e.preventDefault();

    const form = this;

    const email = document.getElementById('email').value;

    const password = document.getElementById('password').value;

    try {

        const userCredential =
            await createUserWithEmailAndPassword(
                auth,
                email,
                password
            );

        await sendEmailVerification(userCredential.user);

        alert(
            "Verification email sent. Please verify your email before continuing."
        );

    } catch (error) {

        alert(error.message);

        console.log(error);

    }

});

</script>



</x-guest-layout>
<script type="module">

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";

import {

    getAuth,
    createUserWithEmailAndPassword,
    sendEmailVerification

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

window.togglePasswords = function () {

    const password = document.getElementById('password');

    const confirm = document.getElementById('password_confirmation');

    const type = password.type === 'password'
        ? 'text'
        : 'password';

    password.type = type;

    confirm.type = type;
};

document.getElementById("registerForm")
.addEventListener("submit", async function (e) {

    e.preventDefault();

    const name = document.getElementById('name').value;

    const email = document.getElementById('email').value;

    const password = document.getElementById('password').value;

    try {

        const userCredential =
            await createUserWithEmailAndPassword(
                auth,
                email,
                password
            );

        await sendEmailVerification(userCredential.user);

        alert(
            "Verification email sent! Please check your Gmail."
        );

    } catch (error) {

        alert(error.message);

        console.log(error);

    }

});

</script>