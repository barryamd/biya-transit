<div class="btn-group btn-group-sm">
    @can('update-charge')
    <button wire:click="openEditModal({{ $row->id }}, 'chargeFormModal')" class='btn text-warning text-lg' title="{{__('Edit') }}"><i class='fas fa-edit'></i></button>
    @endcan
    @can('delete-charge')
    <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="{{__('Delete') }}"><i class="fas fa-trash"></i></button>
    @endcan
</div>
