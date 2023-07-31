<div class="btn-group btn-group-sm">
    @can('edit-payment')
    <button wire:click="openEditModal({{ $row->id }}, 'paymentFormModal')" class='btn text-primary text-lg' title="{{__('Edit') }}"><i class='fas fa-edit'></i></button>
    @endcan
    @can('delete-payment')
    <button wire:click="delete({{$row->id}})" class="btn text-danger text-lg" title="{{__('Delete') }}"><i class="fas fa-trash"></i></button>
    @endcan
</div>
