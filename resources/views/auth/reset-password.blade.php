<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600">
        Forgot your password?
        Enter your email address and we'll send you
        a password reset link.
    </div>

    <!-- Success Message -->
    <div
        id="successMessage"
        class="hidden mb-4 font-medium text-sm text-green-600"
    >
        Password reset email sent successfully.
    </div>

    <!-- Error Message -->
    <div
        id="errorMessage"
        class="hidden mb-4 font-medium text-sm text-red-600"
    ></div>

    <form id="resetForm">

        <!-- Email Address -->
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

        <div class="flex items-center justify-end mt-4">

            <x-primary-button id="submitBtn">

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

        const form = document.getElementById('resetForm');

        const submitBtn =
            document.getElementById('submitBtn');

        const successMessage =
            document.getElementById('successMessage');

        const errorMessage =
            document.getElementById('errorMessage');

        form.addEventListener('submit', async (e) => {

            e.preventDefault();

            successMessage.classList.add('hidden');

            errorMessage.classList.add('hidden');

            const email =
                document.getElementById('email').value;

            submitBtn.disabled = true;

            submitBtn.innerText = 'Sending...';

            try {

                await sendPasswordResetEmail(
                    auth,
                    email
                );

                successMessage.classList.remove('hidden');

                form.reset();

            } catch (error) {

                errorMessage.innerText =
                    error.message;

                errorMessage.classList.remove('hidden');

            } finally {

                submitBtn.disabled = false;

                submitBtn.innerText =
                    'Send Reset Link';

            }

        });

    </script>

</x-guest-layout>