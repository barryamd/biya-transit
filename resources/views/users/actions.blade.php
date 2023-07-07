<div class="btn-group btn-group-sm">
    @can('edit-user')
    <button wire:click="userFormModal({{ $row->id }})" class='btn text-warning text-lg' title="Modifier les infos de l'utilisateur"><i class='fas fa-edit'></i></button>
    @endcan
    @can('delete-user')
    <button wire:click="delete({{$row->id}})" class="btn text-danger text-lg" title="Supprimer l'utilisateur"><i class="fas fa-trash"></i></button>
    @endcan
</div>
