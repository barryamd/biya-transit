@props([
    'type' => 'text',
    'name' => '',
    'label' => '',
    'value' => '',
    'id' => Str::random(5),
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
<div class="form-group">
    @if ($label !='none')
        <label for="{{ $id }}" class="form-label">{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {{ $attributes->merge(['class' => 'form-control']) }} />
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
