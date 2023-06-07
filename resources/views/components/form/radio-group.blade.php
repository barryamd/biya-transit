@props([
    'label',
    'name' => '',
    'id' => Str::random(5),
    'options',
    'required' => false,
])
@php($name = $attributes->wire('model')->value)
<div class="form-group">
    @isset($label)
        <label for="{{ $name }}">@lang($label): @if($required) <span class="text-danger">*</span> @endif</label>
    @endisset
    <div class="row">
        @foreach($options as $value => $option)
            <div class="col">
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="{{ $value }}" name="{{ $name }}" value="{{ $value }}" {{ $attributes }}>
                    <label for="{{ $value }}"  class="custom-control-label">{{ __($option) }}</label>
                </div>
            </div>
        @endforeach
    </div>
    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>

