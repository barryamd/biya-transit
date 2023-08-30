<div class="btn-group btn-group-sm">
    @can('read-folder')
    <a href="{{ route('folders.show', $row->id) }}" class='btn text-info text-lg' title="Voir le dossier"><i class='fas fa-eye'></i></a>
    @endcan
    @if($row->status == 'En attente')
        @can('update-folder')
        <a href="{{ route('folders.edit', $row->id) }}" class='btn text-warning text-lg' title="Modifier le dossier"><i class='fas fa-edit'></i></a>
        @endcan
    @endif
    @if($row->status == 'En attente' || $row->status == 'En cours')
        @can('delete-folder')
        <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="Supprimer le dossier"><i class="fas fa-trash"></i></button>
        @endif
    @endcan
</div>
