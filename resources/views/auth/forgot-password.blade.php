<x-guest-layout>
    <x-auth.auth-card>
        <x-slot name="logo">
            <x-auth.auth-logo></x-auth.auth-logo>
        </x-slot>

        <p class="login-box-msg">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-auth.validation-errors class="mb-4"></x-auth.validation-errors>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <x-auth.input type="email" name="email" :value="old('email')" :placeholder="__('Email')" icon="envelope" required autofocus></x-auth.input>

            <x-auth.submit title="Email Password Reset Link"></x-auth.submit>
        </form>

        <p class="mt-3 mb-1">
            <a href="{{ route('login') }}">{{ __('Login') }}</a>
        </p>

    </x-auth.auth-card>
</x-guest-layout>
