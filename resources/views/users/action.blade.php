<div class="btn-group btn-group-sm">
    @can('edit-user')
    <button wire:click="openEditRoleModal({{ $row->id }})" class='btn text-primary text-lg' title="Modifier les rôles"><i class='fas fa-edit'></i></button>
    @endcan
    @can('delete-user')
    <button wire:click="delete({{$id}})" class="btn text-danger text-lg" title="{{__('Delete') }}"><i class="fas fa-trash"></i></button>
    @endcan
</div>
