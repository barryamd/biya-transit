@props([
    'label'
])

<div>
    <label class="form-label">{{ $label }}</label>
    <div class="mt-2">
        {{ $slot }}
    </div>
</div>
