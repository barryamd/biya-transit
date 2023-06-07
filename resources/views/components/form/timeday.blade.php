@props([
    'options' => [],
    'required' => '',
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
@php
    $options = array_merge([
        'enableTime' => true,
        'noCalendar' => true,
        'dateFormat' => "H:i",
        'time_24hr' => true,
        'minTime' => "08:00",
        'maxTime' => "18:00"
    ], $options);
@endphp
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group">
    @if ($label !='none')
        <label for="{{ $name }}" class="form-label">{{ $label }} @if ($required != '') <span class="text-danger">*</span>@endif</label>
    @endif
    <input
        x-data
        x-init="flatpickr($refs.input, {{json_encode((object)$options)}});"
        x-ref="input"
        type="text"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $slot }}"
        {{ $required }}
        {{ $attributes->merge(['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control')]) }}>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
