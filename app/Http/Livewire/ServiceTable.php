<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Traits\WithCrudActions;
use App\Models\Service;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ServiceTable extends DataTableComponent
{
    use WithCrudActions;

    protected $model = Service::class;
    protected array $createButtonParams = [
        'title' => 'Ajouter un service',
        'modal' => 'serviceFormModal',
        'permission' => 'edit-settings',
    ];
    public string $name = '', $description = '';

    public function mount()
    {
        $this->authorize('edit-settings');
    }

    public function columns(): array
    {
        return [
            Column::make("Nom", "name")
                ->sortable()->searchable(),
            Column::make("Description", "description"),
            Column::make('Actions', 'id')
                ->view('services.action-buttons')
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function customView(): string
    {
        return 'services.form-modal';
    }
}
