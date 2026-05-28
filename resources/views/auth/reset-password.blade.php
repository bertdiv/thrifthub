<x-guest-layout>

<div class="text-center py-10">

    <h1 class="text-2xl font-bold mb-4">
        Redirecting...
    </h1>

    <p class="text-gray-600">
        Please wait while we redirect you to
        the password reset page.
    </p>

</div>

<script>

setTimeout(() => {

    window.location.href = "{{ route('password.request') }}";

}, 1500);

</script>

</x-guest-layout>