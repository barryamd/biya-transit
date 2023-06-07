<x-guest-layout>
    <x-auth.auth-card>
        <x-slot name="logo">
            <x-auth.auth-logo></x-auth.auth-logo>
        </x-slot>

        <x-auth.validation-errors class="mb-4"></x-auth.validation-errors>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <x-auth.input type="email" name="email" :value="old('email', $request->email)" :placeholder="__('Email')" icon="envelope" required autofocus></x-auth.input>

            <x-auth.password name="password" :placeholder="__('Password')" icon="lock" required autocomplete="new-password"></x-auth.password>

            <x-auth.password name="password_confirmation" :placeholder="__('Confirm Password')" icon="lock" required autocomplete="new-password"></x-auth.password>

            <x-auth.submit title="Reset Password"></x-auth.submit>
        </form>

        <p class="mt-3 mb-1">
            <a href="{{ route('login') }}">{{ __('Login') }}</a>
        </p>
    </x-auth.auth-card>
</x-guest-layout>
