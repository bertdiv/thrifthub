<x-guest-layout>

    <div class="text-center py-10">

        <h2 class="text-2xl font-bold mb-4">

            Verify Your Email

        </h2>

        <p class="text-gray-600 mb-6">

            A verification email has been sent
            to your Gmail account.

            Please check your inbox or Spam folder.

        </p>

        <div class="flex justify-center">

            <a href="{{ route('login') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">

                Go to Login

            </a>

        </div>

    </div>

</x-guest-layout>