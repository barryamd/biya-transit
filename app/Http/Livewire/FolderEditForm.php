<?php

namespace App\Http\Livewire;

use App\Models\Delivery;
use App\Models\Exoneration;
use App\Models\Folder;
use App\Models\Payment;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderEditForm extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public string $activeTab = 'overview';

    public Folder $folder;
    public Payment|null $paymentDvt = null;
    public Exoneration|null $exoneration = null;
    public Payment|null $paymentDdi = null;
    public Payment|null $paymentTm = null;
    public Payment|null $paymentCt = null;

    public string|null $dvtNumber, $ddiNumber, $tmNumber, $ctNumber;
    public string|null $dvtAmount, $ddiAmount, $tmAmount, $ctAmount;
    public $dvtFile, $ddiFile, $tmFile, $ctFile;

    public int|null $exonerationAmount;
    public array $products = [], $exonerationProducts = [];

    public Delivery|null $delivery = null;
    public string|null $deliveryPlace, $deliveryDate;
    public $deliveryFile;
    public int|null $transporter;


    public function mount()
    {
        $this->products = $this->folder->products->pluck('designation', 'id')->toArray();

        $this->exoneration = $this->folder->exoneration;
        if ($this->exoneration) {
            $this->exonerationAmount = $this->exoneration->amount;
            $this->exonerationProducts = $this->exoneration->products->pluck('id')->toArray();
        }

        $payments = $this->folder->payments;

        $this->paymentDvt = $payments->where('type', 'DVT')->first();
        if ($this->paymentDvt) {
            $this->dvtNumber = $this->paymentDvt->invoice_number;
            $this->dvtAmount = $this->paymentDvt->amount;
        }

        $this->paymentDdi = $payments->where('type', 'DDI')->first();
        if ($this->paymentDdi) {
            $this->ddiNumber = $this->paymentDdi->invoice_number;
            $this->ddiAmount = $this->paymentDdi->amount;
        }

        $this->paymentTm = $payments->where('type', 'TM')->first();
        if ($this->paymentTm) {
            $this->tmNumber = $this->paymentTm->invoice_number;
            $this->tmAmount = $this->paymentTm->amount;
        }

        $this->paymentCt = $payments->where('type', 'CT')->first();
        if ($this->paymentCt) {
            $this->ctNumber = $this->paymentCt->invoice_number;
            $this->ctAmount = $this->paymentCt->amount;
        }

        $this->delivery = $this->folder->delivery;
        if ($this->delivery) {
            $this->deliveryDate = $this->delivery->delivery_date;
            $this->deliveryPlace = $this->delivery->delivery_place;
            $this->transporter = $this->delivery->transporter_id;
        }
    }

    public function render()
    {
        return view('folders.edit-form');
    }

    public function savePaymentDvt()
    {
        $this->validate([
            'dvtAmount' => ['required', 'numeric'],
            'dvtFile'   => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        try {
            if ($this->paymentDvt) {
                $this->paymentDvt->update(['amount' => $this->dvtAmount]);
            } else {
                $this->paymentDvt = Payment::create([
                    'folder_id' => $this->folder->id,
                    'type' => 'DVT',
                    'invoice_number' => $this->dvtNumber,
                    'amount' => $this->dvtAmount
                ]);
            }
            if ($this->dvtFile) {
                $this->paymentDvt->addFile($this->dvtFile);
            }

            $this->alert('success', "La facture a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function savePaymentDdi()
    {
        $this->validate([
            'ddiAmount' => ['required', 'numeric'],
            'ddiFile'   => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        try {
            if ($this->paymentDdi) {
                $this->paymentDdi->update(['amount' => $this->ddiAmount]);
            } else {
                $this->paymentDdi = Payment::create([
                    'folder_id' => $this->folder->id,
                    'type' => 'DDI',
                    'invoice_number' => $this->ddiNumber,
                    'amount' => $this->ddiAmount
                ]);
            }
            if ($this->ddiFile) {
                $this->paymentDdi->addFile($this->ddiFile);
            }

            $this->alert('success', "La facture a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function saveExoneration()
    {
        $this->validate([
            'exonerationAmount' => ['required', 'numeric'],
            'exonerationProducts'   => 'required',
        ]);

        try {
            if ($this->exoneration) {
                $this->exoneration->update(['amount' => $this->exonerationAmount]);
            } else {
                $this->exoneration = Exoneration::create([
                    'folder_id' => $this->folder->id,
                    'amount' => $this->exonerationAmount
                ]);
            }
            $this->exoneration->products()->sync($this->exonerationProducts);

            $this->alert('success', "L'exoneration a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function savePaymentTm()
    {
        $this->validate([
            'tmAmount' => ['required', 'numeric'],
            'tmFile'   => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        try {
            if ($this->paymentTm) {
                $this->paymentTm->update(['amount' => $this->tmAmount]);
            } else {
                $this->paymentTm = Payment::create([
                    'folder_id' => $this->folder->id,
                    'type' => 'TM',
                    'invoice_number' => $this->tmNumber,
                    'amount' => $this->tmAmount
                ]);
            }
            if ($this->tmFile) {
                $this->paymentTm->addFile($this->tmFile);
            }

            $this->alert('success', "La facture a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function savePaymentCt()
    {
        $this->validate([
            'ctAmount' => ['required', 'numeric'],
            'ctFile'   => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        try {
            if ($this->paymentCt) {
                $this->paymentCt->update(['amount' => $this->ctAmount]);
            } else {
                $this->paymentCt = Payment::create([
                    'folder_id' => $this->folder->id,
                    'type' => 'CT',
                    'invoice_number' => $this->ctNumber,
                    'amount' => $this->ctAmount
                ]);
            }
            if ($this->ctFile) {
                $this->paymentCt->addFile($this->ctFile);
            }

            $this->alert('success', "La facture a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function saveDeliveries()
    {
        $this->validate([
            'deliveryDate' => ['required', 'date'],
            'deliveryPlace' => ['required', 'string'],
            'deliveryFile' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'transporter' => 'required',
        ]);

        try {
            if ($this->delivery) {
                $this->delivery->update([
                    'transporter_id' => $this->transporter,
                    'delivery_date' => $this->deliveryDate,
                    'delivery_place' => $this->deliveryPlace,
                ]);
            } else {
                $this->delivery = Delivery::create([
                    'folder_id' => $this->folder->id,
                    'transporter_id' => $this->transporter,
                    'delivery_date' => $this->deliveryDate,
                    'delivery_place' => $this->deliveryPlace,
                ]);
            }
            $this->delivery->addFile($this->deliveryFile);

            $this->alert('success', "Les details de la livraison ont été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
