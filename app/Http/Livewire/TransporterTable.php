<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\Models\Transporter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TransporterTable extends DataTableComponent
{
    protected $model = Transporter::class;

    protected array $createButtonParams = [
        'title' => 'Nouveau transporteur',
        'modal' => 'transporterFormModal',
        'permission' => 'create-transporter',
    ];
    public Transporter $transporter;
    public string|null $email;

    public function mount()
    {
        $this->authorize('view-transporter');

        $this->transporter = new Transporter();
    }

    public function columns(): array
    {
        return [
            Column::make("Numéro d'immatriculation", "numberplate")
                ->sortable()->searchable(),
            Column::make("Marque", "marque")
                ->sortable()->searchable(),
            Column::make("Nom du chauffeur", "driver_name")
                ->sortable(),
            Column::make("Téléphone du chauffeur", "driver_phone")
                ->sortable(),
            Column::make("Date d'ajout", "created_at")
                ->sortable(),
            Column::make('Actions', 'id')
                ->view('transporters.action-buttons')
        ];
    }

    protected function rules(): array
    {
        return [
            'transporter.numberplate' => [
                'required', 'string',
                Rule::unique('transporters', 'numberplate')->ignore($this->transporter->id)
            ],
            'transporter.marque' => ['required', 'string'],
            'transporter.driver_name' => ['required', 'string'],
            'transporter.driver_phone' => [
                'required', 'string',
                Rule::unique('transporters', 'driver_phone')->ignore($this->transporter->id)
            ],
        ];
    }

    public function openEditModal(int $id, $modalId = null)
    {
        try {
            $this->transporter = $this->model::findOrFail($id);
            $this->isEditMode = true;
            $this->dispatchBrowserEvent('open-transporterFormModal');
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $this->transporter->save();

            $this->closeModal();
            $this->alert('success', "Le transporteur a été ajouté avec succès.");
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function closeModal($modalId = null)
    {
        $this->dispatchBrowserEvent('close-transporterFormModal');
        $this->emitSelf('refresh');
        $this->transporter = new Transporter();
        $this->isEditMode = false;
    }

    public function customView(): string
    {
        return 'transporters.form-modal';
    }
}
