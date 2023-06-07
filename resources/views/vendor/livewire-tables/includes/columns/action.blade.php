@if(isset($showRouteName))
<a href="{{ route($showRouteName, $row->id) }}" title="{{__('messages.common.show') }}"
    class="btn px-1 text-info fs-3 ps-0">
    <i class="fa-solid fa-eye"></i>
</a>
@endif
@if(isset($editRouteName))
<a href="{{ route($editRouteName, $row->id) }}" title="{{__('messages.common.edit') }}"
   class="btn px-1 text-primary fs-3 ps-0">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
@endif
<a href="javascript:void(0)" title="{{__('messages.common.delete')}}" data-id="{{ $id }}"
   class="btn px-1 text-danger fs-3 pe-0" wire:key="{{$id}}" wire:click="$emit('triggerDelete',{{ $id }})" type="button">
    <i class="fa-solid fa-trash"></i>
</a>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            @this.on('triggerDelete', (id, header = 'Item') => {
                Swal.fire({
                    //title: Lang.get('messages.issued_item.item_returned'),
                    title: $('.deleteVariable').val(),
                    text: $('.confirmVariable').val()  + header + '?',
                    icon: $('.sweetAlertIcon').val(),   // 'warning'
                    buttons: {
                        confirm:$('.yesVariable').val()  + ' ' +  $('.deleteVariable').val(),
                        cancel: $('.noVariable').val()  + ' ' +  $('.cancelVariable').val(),
                    },
                    //showCancelButton: true,
                }).then((result) => {
                    if (result.value) {
                        @this.call('delete',id);
                            //.then(result => { });
                    }
                });
            });
        })
    </script>
@endpush
