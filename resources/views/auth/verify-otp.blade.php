<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600 text-center">
        Enter the OTP sent to your email.
    </div>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- OTP -->
        <div>
            <x-input-label for="otp" :value="__('OTP Code')" />

            <x-text-input id="otp"
                          class="block mt-1 w-full text-center text-2xl tracking-widest"
                          type="text"
                          name="otp"
                          maxlength="6"
                          required
                          autofocus />

            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex justify-center mt-6">

            <x-primary-button>
                Verify OTP
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>