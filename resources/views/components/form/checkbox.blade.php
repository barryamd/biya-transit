@props([
    'name'  => '',
    'label' => '',
    'id'    => Str::random(5),
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="custom-control custom-checkbox">
    <input type="checkbox" id="{{$id}}" name="{{$name}}" {{ $attributes->merge(['class' => 'custom-control-input']) }}>
    <label for="{{$id}}"  class="custom-control-label">{{ __($label) }}</label>
    @error($name)
    <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
