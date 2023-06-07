@props([
    'label',
    'name',
    'append',
    'required' => false,
    'id' => Str::random(5),
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group">
    @isset($label)
        <label for="{{ $id }}">@lang($label): @if($required) <span class="text-danger">*</span> @endif</label>
    @endisset
    <div class="input-group">
        <input type="file" id="{{$id}}" name="{{$name}}"{{ $attributes->merge(['class' => 'form-control']) }}>
        @if($append)
            <div class="input-group-append">
                <span class="input-group-text {{ $height ? 'form-control-'.$height : '' }}">{{ $append }}</span>
            </div>
        @endif
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{--@props([--}}
{{--    'name' => '',--}}
{{--    'id' => 'documentImage',--}}
{{--    'label' => '',--}}
{{--    'previousFile' => '',--}}
{{--    'accept' => ".png, .jpg, .jpeg, .gif, .pdf, .docx, .doc",--}}
{{--])--}}

{{--@if ($label === 'none')--}}
{{--@elseif ($label === '')--}}
{{--    @php--}}
{{--        //remove underscores from name--}}
{{--        $label = str_replace('_', ' ', $name);--}}
{{--        //detect subsequent letters starting with a capital--}}
{{--        $label = preg_split('/(?=[A-Z])/', $label);--}}
{{--        //display capital words with a space--}}
{{--        $label = implode(' ', $label);--}}
{{--        //uppercase first letter and lower the rest of a word--}}
{{--        $label = ucwords(strtolower($label));--}}
{{--    @endphp--}}
{{--@endif--}}
{{--@if($previousFile)--}}
{{--    @php--}}
{{--        $ext = explode('.', $previousFile)[1];--}}
{{--        if ($ext === 'pdf') {--}}
{{--            $documentUrl = url('assets/img/pdf.png');--}}
{{--        } elseif (($ext === 'docx') || ($ext === 'doc')) {--}}
{{--            $documentUrl = url('assets/img/doc.png');--}}
{{--        } else {--}}
{{--            $documentUrl = url($previousFile);--}}
{{--        }--}}
{{--    @endphp--}}
{{--@else--}}
{{--    @php($documentUrl = url('assets/img/default_image.jpg'))--}}
{{--@endif--}}

{{--@if($attributes->wire('model')->value)--}}
{{--    @php($name = $attributes->wire('model')->value)--}}
{{--@endif--}}
{{--<div wire:ignore class="form-group">--}}
{{--    @if ($label !='none')--}}
{{--        <label for="{{ $name }}" class="form-label">{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>--}}
{{--    @endif--}}
{{--    <br>--}}
{{--    <div class="d-block">--}}
{{--        <div class="image-picker">--}}
{{--            <div class="image previewImage" id="documentPreviewImage"--}}
{{--                 style="background-image: url({{ asset('assets/img/default_image.jpg')}}">--}}
{{--                <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{ __($label) }}">--}}
{{--                    <label>--}}
{{--                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>--}}
{{--                        <input type="file" id="{{$id}}" name="{{$name}}" accept="{{$accept}}"--}}
{{--                               {{ $attributes->merge(['class' => 'image-upload d-none profileImage']) }} />--}}
{{--                        <input type="hidden" name="avatar_remove"/>--}}
{{--                    </label>--}}
{{--                </span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        @error($name)--}}
{{--        <span class="text-danger" role="alert">{{ $message }}</span>--}}
{{--        @enderror--}}
{{--    </div>--}}
{{--</div>--}}
{{----}}
{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        @this.get({{$previousFile}}).then(document_url => {--}}
{{--            if (!isEmpty(document_url)) {--}}
{{--                let ext = document_url.split('.').pop().toLowerCase();--}}
{{--                if (ext === 'pdf') {--}}
{{--                    $('#documentPreviewImage').css('background-image', 'url("' + $('.pdfDocumentImageUrl').val() + '")');--}}
{{--                } else if ((ext === 'docx') || (ext === 'doc')) {--}}
{{--                    $('#documentPreviewImage').css('background-image', 'url("' + $('.docxDocumentImageUrl').val() + '")');--}}
{{--                } else {--}}
{{--                    $('#documentPreviewImage').css('background-image', 'url("' + document_url + '")');--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}

{{--        listenHiddenBsModal('#add_documents_modal', function () {--}}
{{--            $('#documentPreviewImage').css('background-image', 'url(' + $('#indexDefaultDocumentImageUrl').val() + ')');--}}
{{--            documentFileName = null;--}}
{{--            resetModalForm('#addDocumentForm', '#documentErrorsBox');--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
{{----}}
