@component('mail::message')
{{-- Greeting --}}
# @lang('Hello!') @lang('Welcome to') {{ config('app.name') }} !

{{-- Intro Lines --}}
{{ str_replace(':app_name', config('app.name'), __("Your account to access the \":app_name\" application has just been created.")) }}

@component('mail::panel')
# @lang('Here are your login details'):

* **@lang('Email'):** {{ $email }}
* **@lang('Password'):** {{ $password }}
@endcomponent

@lang('Please click the button below to verify your email address and confirm your account:')

{{-- Action Button --}}
@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent

{{-- Outro Lines --}}
{{-- Salutation --}}
@lang('Regards'),<br>
{{ config('app.name') }}

{{-- Subcopy --}}
@slot('subcopy')
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endcomponent
