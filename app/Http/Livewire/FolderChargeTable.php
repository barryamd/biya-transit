<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
//use App\LivewireTables\Views\Column\DateColumn;
use App\Models\Folder;
//use App\Models\FolderCharge;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FolderChargeTable extends DataTableComponent
{
    protected $model = Folder::class;
    protected array $createButtonParams = [
        'permission' => null,
    ];
    //public FolderCharge $charge;

    public function mount()
    {
        $this->authorize('read-charge');
        // $this->charge = new FolderCharge();
    }

    public function columns(): array
    {
        return [
            Column::make("Dossier", 'number')
//                ->title(fn($row) => $row->number)
//                ->location(fn($row) => route('invoices.show', $row))
                ->sortable(),
            Column::make("Total des charges", "id")
                ->format(fn($value, $row) => moneyFormat($row->charges_sum_amount)),
            Column::make("Montant facturé", "id")
                ->format(fn($value, $row) => moneyFormat($row->invoices_sum_total)),
            Column::make('Actions', 'id')
                ->view('folder-charges.action-buttons')
        ];
    }

    public function builder(): Builder
    {
        return Folder::query()->select('folders.*')->withSum('invoices', 'total')
            ->withSum('charges', 'amount');
    }

    /*
    protected function rules(): array
    {
        return [
            'charge.folder_id'   => 'required',
            'charge.amount'      => ['required', 'numeric'],
            'charge.description' => ['nullable', 'string'],
        ];
    }

    public function openEditModal(int $id, $modalId = null)
    {
        try {
            $this->charge = $this->model::findOrFail($id);
            $this->isEditMode = true;
            $this->dispatchBrowserEvent('open-chargeFormModal');
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $this->charge->save();
            $this->closeModal();
            $this->alert('success', "La charge a été enregistré avec succès.");
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function closeModal($modalId = null)
    {
        $this->dispatchBrowserEvent('close-chargeFormModal');
        $this->emitSelf('refresh');
        $this->charge = new FolderCharge();
        $this->isEditMode = false;
    }

    public function customView(): string
    {
        return 'folder-charges.form-modal';
    }
    */
}
