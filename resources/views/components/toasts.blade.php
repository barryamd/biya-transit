@props(['style' => session('alert.style', 'success'), 'title' => session('alert.title', 'Success'), 'message' => session('alert.message')])
@if($message)
@push('scripts')
<script>
    $(function() {
        $(document).Toasts('create', {
            class: 'bg-{{ $style }}',   // bg-success, bg-info, bg-warning, bg-danger, bg-maroon
            title: '{{ $title }}',
            // subtitle: 'subtitle',
            body: '{{ $message }}',
            position: 'topRight', // topRight, topLeft, bottomRight, bottomLeft
            autohide: true,
            delay: 3000,
            // icon: 'fas fa-envelope fa-lg',
            // image: '../../dist/img/user3-128x128.jpg',
            // imageAlt: 'User Picture',
            // fixed: false,
        })
    });
</script>
@endpush
@endif
