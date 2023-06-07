@props([
    'label' => 'Status',
    'value' => 1,
    'id'    => Str::random(5),
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group">
    @if ($label !='none')
        <label for='{{$id}}' class='form-label'>{{ __($label) }}:</label>
    @endif
    <div class="custom-control custom-switch">
        <input type="checkbox" name="{{ $name }}" class="custom-control-input" id="{{ $id }}" value="{{ $value }}" {{ $attributes }}>
        <label class="custom-control-label" for="{{ $id }}"></label>
    </div>
</div>
