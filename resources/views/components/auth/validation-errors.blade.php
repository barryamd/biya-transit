@if ($errors->any())
    <div {{ $attributes }}>
        {{--<div class="font-weight-normal text-danger">{{ __('Whoops! Something went wrong.') }}</div>--}}
        <ul class="mb-3 list-disc list-inside text-sm text-danger">
            @if (session('error'))
                <li>{{ session('error') }}</li>
            @else
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endif
        </ul>
    </div>
@endif
{{--
@if ($errors->any())
    <div class="alert-box alert-box--error">
        <div style="padding-bottom:1rem">@lang('Whoops! Something went wrong.')</div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <span class="alert-box__close"></span>
    </div>
@endif
--}}
