<div class="btn-group btn-group-sm">
    @role('Admin')
    <a href="{{ route('folders.show', $row->id) }}" class='btn text-info text-lg' title="Voir le dossier"><i class='fas fa-eye'></i></a>
    <a href="{{ route('folders.edit', $row->id) }}" class='btn text-info text-lg' title="Traiter le dossier"><i class='fas fa-edit'></i></a>
    <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="Supprimer le dossier"><i class="fas fa-trash"></i></button>
    @endrole
</div>
