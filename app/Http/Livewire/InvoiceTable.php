<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\Models\Folder;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class InvoiceTable extends DataTableComponent
{
    protected $model = Folder::class;
    protected array $createButtonParams = [
        'title' => 'Nouvelle facture',
        'route' => 'invoices.create',
        'permission' => 'create-invoice',
    ];
    public string|null $status = null;
    public int|null $customerId = null;

    public function mount()
    {
        $this->authorize('read-invoice');
    }

    public function columns(): array
    {
        return [
            Column::make('number')->hideIf(true)->searchable(),
            LinkColumn::make("Numero de la facture")
                ->title(fn($row) => $row->number)
                ->location(fn($row) => route('invoices.show', $row))
                ->sortable(),
            Column::make("Numero du dossier", 'folder.number')
                ->sortable(),
            Column::make("Sous-total", "subtotal")
                ->format(fn($value, $row) => moneyFormat($value))
                ->sortable(),
            Column::make("TVA", "tva.rate")
                ->sortable(),
            Column::make("Montant TVA", "tax")
                ->format(fn($value, $row) => moneyFormat($value))
                ->sortable(),
            Column::make("Total", "total")
                ->format(fn($value, $row) => moneyFormat($value))
                ->sortable(),
            DateColumn::make("Date", "created_at")
                ->sortable(),
            Column::make('Actions', 'id')
                ->view('invoices.action-buttons')
        ];
    }

    public function builder(): Builder
    {
        return Invoice::with('folder')->with('tva');
    }
}
