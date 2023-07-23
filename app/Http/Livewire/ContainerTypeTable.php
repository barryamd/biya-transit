<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Traits\WithCrudActions;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ContainerType;

class ContainerTypeTable extends DataTableComponent
{
    use WithCrudActions;

    protected $model = ContainerType::class;
    protected array $createButtonParams = [
        'title'  => 'Nouveau type de container',
        'modal' => 'containerTypeFormModal',
        'permission' => 'update-settings',
    ];
    public string $label = '';

    public function mount()
    {
        $this->authorize('update-settings');
    }

    public function columns(): array
    {
        return [
            Column::make("Libellé", "label")
                ->sortable()->searchable(),
            Column::make('Actions', 'id')
                ->view('container-types.action-buttons')
        ];
    }

    protected function rules(): array
    {
        return [
            'label' => ['required', 'string'],
        ];
    }

    public function customView(): string
    {
        return 'container-types.form-modal';
    }
}
