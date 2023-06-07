@props([
    'name' => '',
    'id' => Str::random(5)
    'options' => null,
    'value' => '',
    'placeholder' => __('Select'),
    'multiple' => false,
])

<div wire:ignore>
    <select name='{{$name}}' id='{{$id}}' {{ $attributes->merge(['class' => 'form-control']) }}
        @if($multiple) multiple data-placeholder="{{ $placeholder }}" @endif data-control='select2'
    >
        @if(!$multiple)
            <option value=''>{{ $placeholder }}</option>
        @endif
        @if($options)
            @foreach($options as $key => $option)
                <option value="{{$key}}">{{$option}}</option>
            @endforeach
        @else
            {{ $slot }}
        @endif
        @if($name = $attributes->wire('model')->value)
            <script>
                $(document).ready(function() {
                    $('#{{$id}}').select2().val(@this.get({{$name}})).trigger('change');
                    $('#{{$id}}').on('change', function (e) { @this.set('{{$name}}', e.target.value ) });
                });
            </script>
        @else
            <script>
                $(document).ready(function() {
                    $('#{{$id}}').select2().val({{$value}}).trigger('change');
                });
            </script>
        @endif
    </select>
    @error($name)
    <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
