@props(['type' => session('alert.style', 'success'), 'message' => session('alert.message')])
@if($message)
@push('scripts')
{{--<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">--}}
{{--<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>--}}
{{--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            title: '{{ $message }}',
            icon: '{{ $type }}',
        })
        /*window.addEventListener('alert', ({detail:{type,message}})=>{
            Toast.fire({
                icon: type,  // success, info, error, question,
                title: message
                //iconColor: ,
            })
        })*/
    });
</script>
@endpush
@endif
