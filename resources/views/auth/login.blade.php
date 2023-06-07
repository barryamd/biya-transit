<x-guest-layout>
    <x-auth.auth-card>
        <x-slot name="logo">
            <x-auth.auth-logo></x-auth.auth-logo>
        </x-slot>

        <p class="login-box-msg">{{ __('Sign in to start your session') }}</p>

        <x-auth.validation-errors class="mb-3"></x-auth.validation-errors>

        @if (session('status'))
            <div class="mb-3 font-weight-normal text-sm text-green">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <x-auth.input type="email" name="email" :value="old('email')" :value="old('email')" :placeholder="__('Email')" icon="envelope" required autofocus></x-auth.input>

            <x-auth.password name="password" :placeholder="__('Password')" required autocomplete="current-password"></x-auth.password>

            <x-auth.checkbox></x-auth.checkbox>

            <x-auth.submit title="Log in"></x-auth.submit>
        </form>

        @if (Route::has('password.request'))
            <p class="mb-1">
                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            </p>
        @endif
        {{--<p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
        </p>--}}
    </x-auth.auth-card>
</x-guest-layout>
