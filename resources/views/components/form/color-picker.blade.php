@props([
    'name' => '',
    'label' => '',
    'id' => Str::random(5),
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group">
    @if ($label !='none')
        <label for="{{ $id }}" class="form-label">{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <div class="input-group my-colorpicker2">
        <input type="text" id="{{ $id }}" name="{{ $name }}" class="form-control" {{ $attributes }} />
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-square"></i></span>
        </div>
    </div>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
