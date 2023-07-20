@props([
    'label' => null,
    'name' => null,
    'id' => Str::random(5),
    'value' => null,
    'valueLabel' => '',
    'placeholder' => __('Search ...'),
    'routeName' => null,
    'parentId' => null,
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
        const _select = $("#{{$id}}");
        _select.select2({
            placeholder: "-- {{$placeholder}} --",
            minimumInputLength: 1,
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
            dropdownParent: $('#{{$parentId}}')
        });
        _select.on('select2:select', (e) => @this.set('{{$name}}', e.target.value));
        for (let selectedOption of @json($selectedOptions)) {
            // create the option and append to Select2
            var option = new Option(selectedOption.text, selectedOption.id, true, true);
            _select.append(option);
        }

        // manually trigger the `select2:select` event
        _select.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
    });
</script>
@endpush
