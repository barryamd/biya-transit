@props([
    'label' => null,
    'options' => null,
    'multiple' => false,
    'id' => Str::random(5),
    'placeholder' => ''
])
@if ($label != null)
    @php($label = __($label))
@endif
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group" wire:ignore>
    @if ($label !='none')
        <label for='{{ $id }}' class='form-select'>{{ $label }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <select name='{{ $name }}' id='{{ $id }}' {{ $attributes->merge(['class' => 'form-control']) }}>
        <option value=''>-- {{ $placeholder != '' ? $placeholder : 'Select '.$label }} --</option>
        @foreach($options as $key => $option)
            <option value="{{ $key }}">{{ __($option) }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
