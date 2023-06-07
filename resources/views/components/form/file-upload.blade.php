@props([
    'label',
    'append',
    'required' => false,
    'id' => Str::random(5),
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group" wire:ignore>
    @isset($label)
        <label for="{{ $id }}">@lang($label): @if($required) <span class="text-danger">*</span> @endif</label>
    @endisset
    <div class="input-group">
        <input type="file" id="{{$id}}" {{ $attributes->merge(['class' => 'form-control']) }}>
        @isset($append))
        <div class="input-group-append">
            <span class="input-group-text {{ $height ? 'form-control-'.$height : '' }}">{{ $append }}</span>
        </div>
        @endisset
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
