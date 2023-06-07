@props(['id' => null, 'maxWidth' => null, 'title' => ''])
<div wire:ignore.self class="modal fade" id="{{ $id }}" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog {{ $maxWidth ? 'modal-'.$maxWidth : '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $content }}
            </div>
            @isset($footer)
                <div class="modal-footer justify-content-between">
                    {{ $footer }}
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            @endisset
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        /*window.addEventListener('show-{{$id}}', (event) => {
            $('#{{$id}}').modal('show');
        });
        window.addEventListener('close-{{$id}}', (event) => {
            $('#{{$id}}').modal('hide');
        });*/
        window.livewire.on('show-{{$id}}', () => {
            $('#{{$id}}').modal('show');
        });
        window.livewire.on('close-{{$id}}', () => {
            $('#{{$id}}').modal('hide');
        });
    </script>
@endpush
{{--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#$id"> Launch Default Modal </button>--}}
