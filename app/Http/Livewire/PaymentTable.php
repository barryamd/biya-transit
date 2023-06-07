<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Payment;

class PaymentTable extends DataTableComponent
{
    protected $model = Payment::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Folder id", "folder_id")
                ->sortable(),
            Column::make("Invoice number", "invoice_number")
                ->sortable(),
            Column::make("Type", "type")
                ->sortable(),
            Column::make("Amount", "amount")
                ->sortable(),
            Column::make("Attach file", "attach_file")
                ->sortable(),
            Column::make("Date", "date")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
