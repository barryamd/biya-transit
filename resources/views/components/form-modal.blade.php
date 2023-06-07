@props(['id', 'size' => null, 'title' => '', 'submit' => 'save', 'submitBtn' => 'Save'])

<div wire:ignore.self class="modal fade" id="{{ $id }}" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog {{ $size ? 'modal-'.$size : '' }}" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal('{{$id}}')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="{{ $submit }}">
                <div class="modal-body mb-0 pb-0 pt-3">
                    {{ $content }}
                </div>
                <div class="modal-footer justify-content-between">
                    @if(isset($footer))
                        {{ $footer }}
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                {{--wire:click="resetModal" wire:loading.attr="disabled"--}}
                                wire:click="closeModal('{{$id}}')">
                            {{ __('Close') }}
                        </button>
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fa fa-check-circle"></i> {{ __('Save') }}
                        </button>
                    @endif
                </div>
            </form>
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
