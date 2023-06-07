@props(['type' => session('alert.style', 'success'), 'message' => session('alert.message')])
@if($message)
@push('scripts')
{{--<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">--}}
{{--<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>--}}
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>--}}
<script>
    $(function() {
        toastr['{{ $type }}']('{{ $message }}', '{{ $title ?? '' }}')
    })
    /*window.addEventListener('alert', event => {
        toastr[event.detail.type](event.detail.message, event.detail.title ?? '')
        toastr.options = { "closeButton": true, "progressBar": true }
    })*/
</script>
@endpush
@endif
