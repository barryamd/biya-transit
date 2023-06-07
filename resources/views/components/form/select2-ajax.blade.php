@props([
    'label' => null,
    'name' => null,
    'id' => Str::random(5),
    'value' => null,
    'valueLabel' => '',
    'placeholder' => __('Search ...'),
    'routeName' => null,
    'multiple' => false,
])
@php($name = $attributes->wire('model')->value)
<div wire:ignore class="form-group">
    @if ($label != null)
        <label for='{{ $id }}'>{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <!-- For defining select2 -->
    <select name='{{ $name }}' id='{{ $id }}' {{ $attributes->merge(['class' => 'form-control']) }} style="width: 100%;">
        @if($value)
            <option value="{{$value}}" selected="selected">{{$valueLabel}}</option>
        @endif
    </select>
    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<!-- Script -->
@push('scripts')
<script type="text/javascript">
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
        $( "#{{$id}}" ).select2({
            multiple: '{{$multiple}}',
            placeholder: "-- {{$placeholder}} --",
            minimumInputLength: 2,
            ajax: {
                url: "{{route($routeName)}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
        });
        $('#{{$id}}').on('select2:select', (e) => @this.set('{{$name}}', $('#{{$id}}').val()) );
    });
</script>
@endpush
