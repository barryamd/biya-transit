@props([
    'options' => [],
    'id' => Str::random(5),
    'name' => '',
    'label' => '',
    'value' => '',
])
@php
    $options = array_merge([
        'altInput' => true,
        'altFormat' => "d/m/Y",
        'dateFormat' => 'Y-m-d',
        'enableTime' => false,
        'time_24hr' => true,
        //'locale' => 'fr',
    ], $options);
@endphp
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group">
    @if ($label !='none')
        <label for="{{$id}}" class="form-label">{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <input
        x-data
        x-init="flatpickr($refs.input, {{json_encode((object)$options)}});"
        x-ref="input"
        type="text" id="{{$id}}" name="{{$name}}" value="{{$value}}"
        {{ $attributes->merge(['class' => (auth()->user()->thememode ? 'bg-light- form-control' : 'bg-white- form-control')]) }}>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
