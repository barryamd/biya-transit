@props(['disabled' => false, 'type' => 'text', 'name'])

<input
    type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
    class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
    @if ($bind) wire:model="{{ $name }}" @else wire:model.defer="{{ $name }}" @endif
    {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }}
    @isset ($autocomplete) autocomplete="{{ $autocomplete }}" @endisset>
