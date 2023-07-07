<div class="btn-group btn-group-sm">
    @can('view-invoice')
    <a href="{{ route('invoices.show', $row->id) }}" class='btn text-info text-lg' title="Voir la facture"><i class='fas fa-eye'></i></a>
    @endcan
    @can('edit-invoice')
    <a href="{{ route('invoices.edit', $row->id) }}" class='btn text-warning text-lg' title="Modifier la facture"><i class='fas fa-edit'></i></a>
    @endcan
    @can('delete-invoice')
    <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="Supprimer la facture"><i class="fas fa-trash"></i></button>
    @endcan
</div>
