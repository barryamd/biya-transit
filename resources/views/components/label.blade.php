@props(['value', 'for' => null, 'required' => false])

<label for="{{ $for ?? $value }}">
    {{ __($value) ?? $slot }} @if($required) <span class="text-danger">*</span> @endif
</label>
