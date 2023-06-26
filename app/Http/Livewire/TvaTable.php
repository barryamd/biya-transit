<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Traits\WithCrudActions;
use App\Models\Tva;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\DocumentType;

class TvaTable extends DataTableComponent
{
    use WithCrudActions;

    protected $model = Tva::class;
    protected array $createButtonParams = [
        'text'  => 'Nouveau tva',
        'modal' => 'tvaFormModal',
        'roles' => 'Admin',
    ];
    public string $rate = '';

    public function columns(): array
    {
        return [
            Column::make("Taux", "rate")
                ->sortable()->searchable(),
            Column::make('Actions', 'id')
                ->view('tavs.action-buttons')
        ];
    }

    protected function rules(): array
    {
        return [
            'rate' => ['required', 'string'],
        ];
    }

    public function customView(): string
    {
        return 'tvas.form-modal';
    }
}
