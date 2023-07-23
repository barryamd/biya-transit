<div class="btn-group btn-group-sm">
    @can('read-role')
    <a href="{{ route('roles.show', $row->id) }}" class='btn text-info text-lg' title="Voir les details du role"><i class='fas fa-eye'></i></a>
    @endcan
    @can('update-role')
    <a href="{{ route('roles.edit', $row->id) }}" class='btn text-warning text-lg' title="Modifier les permissions du role"><i class='fas fa-edit'></i></a>
    @endcan
    @can('delete-role')
    <button wire:click="delete({{$row->id}})" class="btn text-danger text-lg" title="Supprimer le role"><i class="fas fa-trash"></i></button>
    @endcan
</div>
