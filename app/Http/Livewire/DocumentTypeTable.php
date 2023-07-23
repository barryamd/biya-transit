<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Traits\WithCrudActions;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\DocumentType;

class DocumentTypeTable extends DataTableComponent
{
    use WithCrudActions;

    protected $model = DocumentType::class;
    protected array $createButtonParams = [
        'title'  => 'Nouveau type de document',
        'modal' => 'documentTypeFormModal',
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
                ->view('document-types.action-buttons')
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
        return 'document-types.form-modal';
    }
}
