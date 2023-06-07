@props(['id', 'maxWidth' => null, 'title' => ''])

<div wire:ignore.self id="{{ $id }}" class="modal fade" role="dialog" aria-hidden="true"
     tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="{{ $id }}">
    <div class="modal-dialog {{ $maxWidth ? 'modal-'.$maxWidth : '' }} overflow-hidden" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header py-4">
                <h2 class="modal-title">{{ $title }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-0 pb-0 pt-3">
                {{ $content }}
            </div>
            @if(isset($footer))
                <div class="modal-footer pt-0 pb-3 justify-content-between-">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('open-{{ $id }}', () => $('#{{ $id }}').modal('show'));
        window.addEventListener('close-{{ $id }}', () => $('#{{ $id }}').modal('hide'));
        window.addEventListener('close-modal', () => $('#{{$id}}').modal('hide'));
        /* window.livewire.on('close-{{$id}}', () => $('#{{$id}}').modal('hide'));*/
    </script>
@endpush
