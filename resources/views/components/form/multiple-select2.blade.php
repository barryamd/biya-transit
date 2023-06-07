@props([
    'label' => '',
    'name' => '',
    'id' => Str::random(5),
    'options' => null,
    'placeholder' => __('Select'),
    'modalId' => null,
])
@if ($label === 'none')
@elseif ($label === '')
    @php
        //remove underscores from name
        $label = str_replace('_', ' ', $name);
        //detect subsequent letters starting with a capital
        $label = preg_split('/(?=[A-Z])/', $label);
        //display capital words with a space
        $label = implode(' ', $label);
        //uppercase first letter and lower the rest of a word
        $label = ucwords(strtolower($label));
    @endphp
@endif

<div wire:ignore class="form-group">
    @if ($label !='none')
        <label for='{{ $id }}' class='form-label'>{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <select name='{{ $name }}' id='{{ $id }}' {{ $attributes->merge(['class' => 'form-control']) }}
            multiple data-placeholder="{{ $placeholder }}" data-control='select2'>
        @foreach($options as $key => $option)
        <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
        @if($name = $attributes->wire('model')->value)
            <script>
                $(document).ready(function() {
                    $('#{{$id}}').on('change', function (e) { @this.set('{{$name}}', $('#{{$id}}').val() ) });
                });
            </script>
        @else
            <script>
                $(document).ready(function() {
                    $('#{{$id}}').select2().val({{$value}}).trigger('change.select2');
                });
            </script>
        @endif
    </select>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
