@props([
    'name' => '',
    'label' => '',
    'value' => '',
])
@if ($label === 'none')
@elseif ($label === '')
    @php
        //remove underscores from name
        $label = str_replace('_', ' ', $name);
        //detect subsequent letters starting with a capital
        $label = preg_split('/(?=[A-Z])/', $label);
        //display capital words with a space
        $label = implode(' ', $label);
        //uppercase first letter and lower the rest of a word
        $label = ucwords(strtolower($label));
    @endphp
@endif
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div wire:ignore class="form-group">
    @if ($label !='none')
        <label for="{{ $name }}" class="form-label">{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <input type="tel" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}"
        {{ $attributes->merge(['class' => 'form-control phoneNumber']) }}
        onkeyup='if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")'
    />
    <br>
    <input type="hidden" name="prefix_code" wire:model.defer="prefix_code" class="prefix_code">
    <span class="text-success valid-msg d-none fw-400 fs-small mt-2">✓ &nbsp; {{__('messages.valid')}}</span>
    <span class="text-danger error-msg d-none fw-400 fs-small mt-2"></span>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
