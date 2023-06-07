@props([
    'name'  => '',
    'label' => '',
    'value' => '',
    'required' => '',
    'id' => Str::random(5)
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group" wire:ignore>
    @if ($label !='none')
        <label for="{{ $id }}" class="form-label">{{ __($label) }}: @if ($required != '') <span class="text-danger">*</span>@endif</label>
    @endif
    <textarea name='{{ $name }}' id='{{ $id }}' {{ $attributes->merge(['class' => 'form-control']) }}>{{ $value }}</textarea>
    @error($name)
        <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
@push('scripts')
    <script>
        $(function () {
            $('#{{$id}}').summernote({
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                    @this.set('{{$name}}', contents);
                    }
                }
            });
        })
    </script>
@endpush
