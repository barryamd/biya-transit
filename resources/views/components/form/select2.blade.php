@props([
    'label' => null,
    'name' => '',
    'id' => Str::random(5),
    'options' => null,
    'value' => '',
    'placeholder' => __('Select'),
    'modalId' => null,
])
@php($name = $attributes->wire('model')->value)
<div wire:ignore class="form-group">
    @if ($label !=null)
        <label for='{{ $id }}'>{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <select name='{{ $name }}' id='{{ $id }}' {{ $attributes->merge(['class' => 'form-control']) }} style="width: 100%;">
        <option value="">-- {{$placeholder}} --</option>
        @foreach($options as $key => $option)
        <option value="{{ $key }}">{{ __($option) }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
@push('scripts')
@if($modalId)
    <script>
        $(document).ready(function() {
            const _select = $("#{{$id}}");
            _select.on('change', (e) => @this.set('{{$name}}', _select.val()));
            _select.select2({placeholder: "-- {{$placeholder}} --", dropdownParent: $('#{{$modalId}}')})
                .val(@this.get({{$name}})).trigger('change.select2');
        });
    </script>
@else
    <script>
        $(document).ready(function() {
            const _select = $("#{{$id}}");
            _select.on('change', (e) => @this.set('{{$name}}', _select.val()));
            _select.select2({placeholder: "-- {{$placeholder}} --"}).val(@this.get({{$name}})).trigger('change.select2');
        });
    </script>
@endif
@endpush
