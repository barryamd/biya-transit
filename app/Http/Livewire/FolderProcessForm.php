<?php

namespace App\Http\Livewire;

use App\Models\DdiOpening;
use App\Models\Declaration;
use App\Models\Delivery;
use App\Models\DeliveryNote;
use App\Models\Exoneration;
use App\Models\Folder;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderProcessForm extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;
    use WithFileUploads;

    public int $currentStep = 1;

    public User $user;
    public Folder $folder;

    public DdiOpening|null $ddiOpening = null;
    public Exoneration|null $exoneration = null;
    public Declaration|null $declaration = null;
    public $deliveryNotes;
    public Delivery|null $delivery = null;
    public Transporter|null $transporter = null;

    public array $products = [], $exonerationProducts = [];

    public $ddiFile, $exonerationFile, $declarationFile, $liquidationFile,
        $receiptFile, $bonFile, $deliveryNoteFiles = [], $deliveryExitFile, $deliveryReturnFile;
    public bool $exonerationExist = false;

    protected $listeners = ['confirmed', 'cancelled'];

    public function getRules()
    {
        return [
            'ddiOpening.dvt_number'        => ['required'],
            'ddiOpening.dvt_obtained_date' => ['required', 'date'],
            'ddiOpening.ddi_number'        => ['nullable'],
            'ddiOpening.ddi_obtained_date' => ['nullable', 'date'],

            'exoneration.number'      => ['nullable'],
            'exoneration.date'        => ['nullable'],
            'exoneration.responsible' => ['nullable'],

            'declaration.number'               => ['required'],
            'declaration.date'                 => ['required', 'date'],
            'declaration.destination_office'   => ['required'],
            'declaration.verifier'             => ['required'],
            'declaration.liquidation_bulletin' => ['required'],
            'declaration.liquidation_date'     => ['required', 'date'],
            'declaration.receipt_number'       => ['required'],
            'declaration.receipt_date'         => ['required', 'date'],
            'declaration.bon_number'           => ['required'],
            'declaration.bon_date'             => ['required', 'date'],

            'deliveryNotes.*.id' => 'nullable',
            'deliveryNotes.*.folder_id' => 'nullable',
            'deliveryNotes.*.bcm' => ['required', 'string'],
            'deliveryNotes.*.bct' => ['required', 'string'],
            'deliveryNotes.*.attach_file_path' => 'nullable',

            'delivery.transporter_id' => ['required'],
            'delivery.date'  => ['required', 'date'],
            'delivery.place' => ['required'],
        ];
    }

    public function mount()
    {
        $this->authorize('edit-folder');

        $this->user = Auth::user();

        $this->products = $this->folder->products->pluck('designation', 'id')->toArray();

        $this->ddiOpening = $this->folder->ddiOpening;
        if ($this->ddiOpening) {
            $this->currentStep = 2;
        } else {
            $this->ddiOpening = new DdiOpening();
        }

        $this->exoneration = $this->folder->exoneration;
        if ($this->exoneration) {
            $this->currentStep = 3;
            $this->exonerationExist = true;
        } else {
            $this->exoneration = new Exoneration();
        }

        $this->declaration = $this->folder->declaration;
        if ($this->declaration) {
            $this->currentStep = 4;
        } else {
            $this->declaration = new Declaration();
        }

        if ($this->folder->id) {
            $this->folder->load('deliveryNotes');
            $this->deliveryNotes = $this->folder->deliveryNotes->collect();
            if ($this->deliveryNotes->count() > 0)
                $this->currentStep = 5;
            else
                $this->deliveryNotes = collect();
        } else {
            $this->deliveryNotes = collect();
        }

        $this->delivery = $this->folder->deliveryDetails;
        if ($this->delivery) {
            $this->transporter = $this->delivery->transporter;
        } else {
            $this->delivery = new Delivery();
        }
    }

    public function updated($property, $value)
    {
        if ($property == 'delivery.transporter_id') {
            $this->transporter = Transporter::findOrFail($value);
        }
    }

    public function submitDdiOpeningStep()
    {
        $this->validate([
            'ddiOpening.dvt_number'        => ['required', 'string', Rule::unique('ddi_openings', 'dvt_number')->ignore($this->exoneration->id)],
            'ddiOpening.dvt_obtained_date' => ['required', 'date'],
            'ddiOpening.ddi_number'        => ['nullable', 'string', Rule::unique('ddi_openings', 'ddi_number')->ignore($this->exoneration->id)],
            'ddiOpening.ddi_obtained_date' => ['nullable', 'date'],
            'ddiFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->ddiOpening->folder_id = $this->folder->id;
            $this->ddiOpening->save();
            if ($this->ddiFile) {
                $this->ddiOpening->addFile($this->ddiFile);
            }
            $this->folder->update(['status' => 'En cours']);

            if ($this->user->can('add-exoneration')) {
                $this->confirm("Utilisez-vous des exonerations ?", [
                    'confirmButtonText' => 'Oui',
                    'cancelButtonText' => 'Non',
                    'onConfirmed' => 'confirmed',
                    'onDismissed' => 'cancelled'
                ]);
            } else {
                $this->alert('success', "Ouverture DDI éfféctué avec succès.");
            }
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function submitExonerationStep()
    {
        $this->validate([
            'exoneration.number'      => ['required', 'string', Rule::unique('exonerations', 'number')->ignore($this->exoneration->id)],
            'exoneration.date'        => ['required', 'date'],
            'exoneration.responsible' => ['required', 'string'],
            'exonerationProducts'     => ['required'],
            'exonerationFile'         => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->exoneration->folder_id = $this->folder->id;

            DB::beginTransaction();
            $this->exoneration->save();
            $this->exoneration->products()->sync($this->exonerationProducts);
            DB::commit();

            if ($this->exonerationFile)
                $this->exoneration->addFile($this->exonerationFile);

            if ($this->user->can('add-declaration')) {
                $this->currentStep = 3;
            }

            $this->alert('success', "L'exoneration a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function submitDeclarationStep()
    {
        $this->validate([
            'declaration.number'               => ['required', 'string', Rule::unique('declarations', 'number')->ignore($this->declaration->id)],
            'declaration.date'                 => ['required', 'date'],
            'declaration.destination_office'   => ['required', 'string'],
            'declaration.verifier'             => ['required', 'string'],
            'declaration.liquidation_bulletin' => ['required', 'string', Rule::unique('declarations', 'liquidation_bulletin')->ignore($this->declaration->id)],
            'declaration.liquidation_date'     => ['required', 'date'],
            'declaration.receipt_number'       => ['required', 'string', Rule::unique('declarations', 'receipt_number')->ignore($this->declaration->id)],
            'declaration.receipt_date'         => ['required', 'date'],
            'declaration.bon_number'           => ['required'],
            'declaration.bon_date'             => ['required', 'date'],
            'declarationFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'liquidationFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'receiptFile'     => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'bonFile'         => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->declaration->folder_id = $this->folder->id;
            $this->declaration->save();
            if ($this->declarationFile) {
                $this->declaration->addFile($this->declarationFile, 'declaration_file_path');
            }
            if ($this->liquidationFile) {
                $this->declaration->addFile($this->liquidationFile, 'liquidation_file_path');
            }
            if ($this->receiptFile) {
                $this->declaration->addFile($this->receiptFile, 'receipt_file_path');
            }
            if ($this->bonFile) {
                $this->declaration->addFile($this->bonFile, 'bon_file_path');
            }

            if ($this->user->can('add-delivery-note')) {
                $this->currentStep = 4;
            }

            $this->alert('success', "La declaration a été enregistrée avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function addDeliveryNote()
    {
        $this->deliveryNotes->add([
            'folder_id' => null,
            'bcm' => null,
            'bct' => null,
            'attach_file_path' => null
        ]);
    }

    public function removeDeliveryNote($index)
    {
        $this->deliveryNotes = $this->deliveryNotes->except([$index])->values();
    }

    public function submitDeliveryNoteStep()
    {
        $this->validate([
            'deliveryNotes'      => 'required',
            'deliveryNotes.*.id' => 'nullable',
            'deliveryNotes.*.folder_id' => 'nullable',
            'deliveryNotes.*.bcm' => ['required', 'string'],
            'deliveryNotes.*.bct' => ['required', 'string'],
            'deliveryNotes.*.attach_file_path' => 'nullable',
            'deliveryNoteFiles.*' => ['mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            foreach ($this->deliveryNotes as $index => $deliveryNoteInputs) {
                $deliveryNoteInputs['folder_id'] = $this->folder->id;
                if (array_key_exists('id', $deliveryNoteInputs)) {
                    $deliveryNote = $this->folder->deliveryNotes->where('id', $deliveryNoteInputs['id'])->first();
                    $deliveryNote->update($deliveryNoteInputs);
                } else {
                    $deliveryNote = DeliveryNote::query()->create($deliveryNoteInputs);
                }
                if (array_key_exists($index, $this->deliveryNoteFiles)) {
                    $deliveryNote->addFile($this->deliveryNoteFiles[$index]);
                }
            }

            if ($this->user->can('add-delivery-details')) {
                $this->currentStep = 5;
            }

            $this->alert('success', "Les bons de livraisons ont été enregistrés avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function submitDeliveryDetailsStep()
    {
        $this->validate([
            'delivery.transporter_id' => ['required'],
            'delivery.date'  => ['required', 'date'],
            'delivery.place' => ['required', 'string'],
            'deliveryExitFile'   => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'deliveryReturnFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->delivery->folder_id = $this->folder->id;
            $this->delivery->save();
            if ($this->deliveryExitFile) {
                $this->delivery->addFile($this->deliveryExitFile, 'exit_file_path');
            }
            if ($this->deliveryReturnFile) {
                $this->delivery->addFile($this->deliveryReturnFile, 'return_file_path');
            }

            $this->flash('success', "Les détails de la livraison ont été enregistrés avec succès.");
            redirect()->route('folders.show', $this->folder);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function back($step)
    {
        if ($step == 2 && !$this->exoneration->id && $this->user->can('add-ddi-opening')) {
            $this->currentStep = 1;
        } else {
            $this->currentStep = $step;
        }
    }

    public function confirmed()
    {
        $this->currentStep = 2;
        $this->alert('success', "Ouverture ddi éfféctué avec succès.");
    }

    public function cancelled()
    {
        $this->currentStep = 3;
    }

    public function render()
    {
        return view('folders.edit-form');
    }

    public function deleteFile($collection, $attribute = 'attach_file_path', $modelId = null)
    {
        if ($collection == 'ddi_openings') {
            $this->ddiOpening->deleteFile($attribute);
        } elseif ($collection == 'exonerations') {
            $this->exoneration->deleteFile($attribute);
        } elseif ($collection == 'declarations') {
            $this->declaration->deleteFile($attribute);
        } elseif ($collection == 'delivery_notes') {
            $deliveryNote = $this->deliveryNotes->where('id', $modelId)->first();
            if ($deliveryNote)
                $deliveryNote->deleteFile($attribute);
        } elseif ($collection == 'deliveries') {
            $this->delivery->deleteFile($attribute);
        }
    }

    public function downloadFile($collection, $attribute, $modelId = null)
    {
        $filePath = '';
        if ($collection == 'ddi_openings') {
            $filePath = $this->ddiOpening->attach_file_path;
        } elseif ($collection == 'exonerations') {
            $filePath = $this->exoneration->attach_file_path;
        } elseif ($collection == 'declarations') {
            $filePath = $this->declaration->$attribute;
        } elseif ($collection == 'delivery_notes') {
            $deliveryNote = $this->deliveryNotes->where('id', $modelId)->first();
            $filePath = $deliveryNote->attach_file_path;
        } elseif ($collection == 'deliveries') {
            $filePath = $this->delivery->$attribute;
        }
        $filePath = public_path('uploads/'.$filePath);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
        return null;
    }
}
