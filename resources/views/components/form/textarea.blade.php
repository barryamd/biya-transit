@props([
    'name'  => '',
    'label' => '',
    'value' => '',
    'required' => '',
    'id' => Str::random(5)
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group">
    @if ($label !='none')
        <label for="{{ $id }}" class="form-label">{{ __($label) }}: @if ($required != '') <span class="text-danger">*</span>@endif</label>
    @endif
    <textarea name='{{ $name }}' id='{{ $id }}' {{ $attributes->merge(['class' => 'form-control']) }}>{{ $value }}</textarea>
    @error($name)
    <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
