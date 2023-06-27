<div class="btn-group btn-group-sm">
    @role('Admin')
    <a href="{{ route('invoices.show', $row->id) }}" class='btn text-info text-lg' title="Voir la facture"><i class='fas fa-eye'></i></a>
    <a href="{{ route('invoices.edit', $row->id) }}" class='btn text-warning text-lg' title="Modifier la facture"><i class='fas fa-edit'></i></a>
    <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="Supprimer la facture"><i class="fas fa-trash"></i></button>
    @endrole
</div>
