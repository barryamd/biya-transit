@props([
    'options' => [],
    'required' => '',
    'name' => '',
    'label' => '',
    'value' => '',
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
@php
    $options = array_merge([
        'altInput' => true,
        'altFormat' => "d/m/Y",
        'dateFormat' => 'Y-m-d',
        'enableTime' => false,
        'time_24hr' => true,
        'mode' => 'range',
    ], $options);
@endphp
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
        {{ $attributes->merge(['class' => (auth()->user()->thememode ? 'bg-light form-control' : 'bg-white form-control')]) }}>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
