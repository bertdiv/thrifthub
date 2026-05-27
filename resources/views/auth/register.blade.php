<x-guest-layout>

<form method="POST" action="{{ route('register') }}" class="px-2 sm:px-0">
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
                <x-primary-button class="w-full sm:w-auto">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

        </div>

    </div>

</form>

<!-- Script -->
<script>
function togglePasswords() {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');

    const type = password.type === 'password' ? 'text' : 'password';

    password.type = type;
    confirm.type = type;
}
</script>

</x-guest-layout>