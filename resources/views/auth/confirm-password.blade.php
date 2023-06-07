<x-guest-layout>
    <x-auth.auth-card>
        <x-slot name="logo">
            <x-auth.auth-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-auth.validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <x-auth.input type="password" name="password" :placeholder="__('Password')" icon="envelope" required autocomplete="current-password" autofocus />

            <x-auth.submit title="Confirm" />
        </form>
    </x-auth.auth-card>
</x-guest-layout>
