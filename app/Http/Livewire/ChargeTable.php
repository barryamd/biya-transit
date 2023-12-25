<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\Models\Charge;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ChargeTable extends DataTableComponent
{
    use WithFileUploads;

    protected $model = Charge::class;
    protected array $createButtonParams = [
        'title' => 'Nouvelle charge',
        'modal' => 'chargeFormModal',
        'permission' => 'create-charge',
    ];
    public Charge $charge;
    public $type = null;
    public $file;

    public function mount()
    {
        $this->authorize('read-charge');

        $this->charge = new Charge(['type' => $this->type]);
    }

    public function columns(): array
    {
        return [
            Column::make("Charge", "name")
                ->sortable(),
            Column::make("Periode", "period")
                ->format(fn($value, $row) => dateFormat($value, 'M Y'))
                ->sortable(),
            Column::make("Valeur", "amount")
                ->format(fn($value, $row) => moneyFormat($value))
                ->sortable(),
            Column::make("Fichier jointe", "attach_file_path")
                ->view('charges.download-btn'),
                //->format(fn($value, $row) => moneyFormat($value)),
            Column::make('Details')->collapseOnTablet(),
            Column::make("Autheur", "user.first_name")
                ->format(fn($value, $row) => $row->user?->full_name),
            Column::make('Actions', 'id')
                ->view('charges.action-buttons')
        ];
    }

    public function builder(): Builder
    {
        return Charge::query()->with('user')->select('last_name')
            ->where('type', $this->type);
    }

    protected function rules(): array
    {
        return [
            'charge.type'    => ['required', 'string'],
            'charge.name'    => ['required', 'string'],
            'charge.amount'  => ['required', 'numeric'],
            'charge.period'  => ['required', 'date'],
            'charge.details' => ['nullable', 'string'],
            'file' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
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
            $this->charge->user_id = Auth::user()->id;
            $this->charge->save();
            if ($this->file)
                $this->charge->addFile($this->file);
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
        $this->charge = new Charge(['type' => $this->type]);
        $this->isEditMode = false;
    }

    public function customView(): string
    {
        return 'charges.form-modal';
    }

    public function downloadFile($modelId)
    {
        $charge = Charge::query()->where('id', $modelId)->first();
        if ($charge) {
            $filePath = public_path('uploads/'.$charge->attach_file_path);
            if (file_exists($filePath)) {
                return response()->download($filePath);
            } else {
                $this->alert('warning', 'Fichier non trouvé');
            }
        }
        return null;
    }
}
