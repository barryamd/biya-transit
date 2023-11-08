@if($row->attach_file_path)
    <button wire:click="downloadFile({{ $row->id }})" class="btn btn-sm btn-success">
        <i class="fas fa-download"></i> Télécharger
    </button>
@else
    <div class="badge badge-danger">Aucun fichier</div>
@endif
