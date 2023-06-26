<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Traits\WithCrudActions;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ServiceTable extends DataTableComponent
{
    use WithCrudActions;

    protected $model = ServiceTable::class;
    protected array $createButtonParams = [
        'text'  => 'Ajouter un service',
        'modal' => 'serviceFormModal',
        'roles' => 'Admin',
    ];
    public string $label = '';

    public function columns(): array
    {
        return [
            Column::make("Nom", "name")
                ->sortable()->searchable(),
            Column::make('Actions', 'id')
                ->view('services.action-buttons')
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function customView(): string
    {
        return 'services.form-modal';
    }
}
