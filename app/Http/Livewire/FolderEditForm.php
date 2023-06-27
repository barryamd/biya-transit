<?php

namespace App\Http\Livewire;

use App\Models\DdiOpening;
use App\Models\Declaration;
use App\Models\Delivery;
use App\Models\DeliveryNote;
use App\Models\Exoneration;
use App\Models\Folder;
use App\Models\Transporter;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderEditForm extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public int $currentStep = 1;

    public Folder $folder;

    public DdiOpening|null $ddiOpening = null;
    public Exoneration|null $exoneration = null;
    public Declaration|null $declaration = null;
    public DeliveryNote|null $deliveryNote = null;
    public Delivery|null $delivery = null;
    public Transporter|null $transporter = null;

    public array $products = [], $exonerationProducts = [];

    public $ddiFile, $exonerationFile, $declarationFile, $liquidationFile,
        $receiptFile, $bonFile, $deliveryNoteFile, $deliveryFile;
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

            'deliveryNote.bcm' => ['required'],
            'deliveryNote.bct' => ['required'],
            'deliveryNoteFile' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],

            'delivery.transporter_id' => ['required'],
            'delivery.date'  => ['required', 'date'],
            'delivery.place' => ['required'],
        ];
    }

    public function mount()
    {
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

        $this->deliveryNote = $this->folder->deliveryNote;
        if ($this->deliveryNote) {
            $this->currentStep = 5;
        } else {
            $this->deliveryNote = new DeliveryNote();
        }

        $this->delivery = $this->folder->deliveryDetails ?? new Delivery();
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
            'ddiOpening.dvt_number'        => ['required', 'string'],
            'ddiOpening.dvt_obtained_date' => ['required', 'date'],
            'ddiOpening.ddi_number'        => ['nullable', 'string'],
            'ddiOpening.ddi_obtained_date' => ['nullable', 'date'],
            'ddiFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->ddiOpening->folder_id = $this->folder->id;
            $this->ddiOpening->save();
            if ($this->ddiFile) {
                $this->ddiOpening->addFile($this->ddiFile);
            }

            //$this->alert('success', "La facture a été enregistré avec succès.");
            $this->confirm("Utilisez-vous des exonerations ?", [
                'confirmButtonText' => 'Oui',
                'cancelButtonText' => 'Non',
                'onConfirmed' => 'confirmed',
                'onDismissed' => 'cancelled'
            ]);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function submitExonerationStep()
    {
        $this->validate([
            'exoneration.number'      => ['required', 'string', Rule::unique('exonerations', 'number')],
            'exoneration.date'        => ['required', 'date'],
            'exoneration.responsible' => ['required', 'string'],
            'exonerationProducts'     => ['required'],
        ]);

        try {
            $this->exoneration->folder_id = $this->folder->id;
            $this->exoneration->save();
            $this->exoneration->products()->sync($this->exonerationProducts);
            $this->currentStep = 3;

            $this->alert('success', "L'exoneration a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function submitDeclarationStep()
    {
        $this->validate([
            'declaration.number'               => ['required', 'string', Rule::unique('declarations', 'number')],
            'declaration.date'                 => ['required', 'date'],
            'declaration.destination_office'   => ['required', 'string'],
            'declaration.verifier'             => ['required', 'string'],
            'declaration.liquidation_bulletin' => ['required', 'string', Rule::unique('declarations', 'liquidation_bulletin')],
            'declaration.liquidation_date'     => ['required', 'date'],
            'declaration.receipt_number'       => ['required', 'string', Rule::unique('declarations', 'receipt_number')],
            'declaration.receipt_date'         => ['required', 'date'],
            'declaration.bon_number'           => ['required'],
            'declaration.bon_date'             => ['required', 'date'],
            'declarationFile' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'liquidationFile' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'receiptFile'     => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'bonFile'         => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->declaration->folder_id = $this->folder->id;
            $this->declaration->save();
            if ($this->declarationFile) {
                $this->declaration->addFile($this->declarationFile, 'file_path');
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
            $this->currentStep = 4;

            $this->alert('success', "La declaration a été enregistrée avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function submitDeliveryNoteStep()
    {
        $this->validate([
            'deliveryNote.bcm' => ['required', 'string'],
            'deliveryNote.bct' => ['required', 'string'],
            'deliveryNoteFile' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->deliveryNote->folder_id = $this->folder->id;
            $this->deliveryNote->save();
            if ($this->deliveryNoteFile) {
                $this->deliveryNote->addFile($this->deliveryNoteFile);
            }
            $this->currentStep = 5;

            $this->alert('success', "Le bon de livraison a été enregistré avec succès.");
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
            'deliveryFile'   => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->delivery->folder_id = $this->folder->id;
            $this->delivery->save();
            if ($this->deliveryFile) {
                $this->delivery->addFile($this->deliveryFile);
            }
            $this->folder->update(['status' => 'Fermé']);

            $this->flash('success', "Les détails de la livraison ont été enregistrés avec succès.");
            redirect()->route('closed-folders.index');
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function back($step)
    {
        if ($step == 2 && !$this->exoneration->id) {
            $this->currentStep = 1;
        } else {
            $this->currentStep = $step;
        }
    }

    public function confirmed()
    {
        $this->currentStep = 2;
    }

    public function cancelled()
    {
        $this->currentStep = 3;
    }

    public function render()
    {
        return view('folders.edit-form');
    }
}
