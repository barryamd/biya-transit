@props([
    'label' => null,
    'name' => null,
    'id' => Str::random(5),
    'selectedOptions' => [],
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
            multiple: '{{$multiple}}',
            placeholder: "-- {{$placeholder}} --",
            ajax: {
                url: "{{route($routeName)}}", // L'URL de l'API pour charger les options via Ajax
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 1, // Permet de charger toutes les options au chargement de la page
            // Autres options Select2...
        })//.val(@json($selectedOptions)).trigger('change.select2');

        _select.on('select2:select', (e) => @this.set('{{$name}}', _select.val()));

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
