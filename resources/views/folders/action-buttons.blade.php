<div class="btn-group btn-group-sm">
    @can('view-invoice')
    <a href="{{ route('folders.show', $row->id) }}" class='btn text-info text-lg' title="Voir le dossier"><i class='fas fa-eye'></i></a>
    @endcan
    @if($status != 'Fermé')
        @can('edit-invoice')
        <a href="{{ route('folders.edit', $row->id) }}" class='btn text-warning text-lg' title="Traiter le dossier"><i class='fas fa-edit'></i></a>
        @endcan
        @can('delete-invoice')
        <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="Supprimer le dossier"><i class="fas fa-trash"></i></button>
    @endif
    @endcan
</div>
