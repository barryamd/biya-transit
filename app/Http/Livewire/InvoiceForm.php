<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\Service;
use App\Models\Tva;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class InvoiceForm extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;
    use WithFileUploads;

    public Invoice $invoice;
    public Collection|array $amounts;
    public Collection|array $services = [];
    public Collection|array $tvas = [];
    public $selectedFolder = [];
    public $tva;

    protected function rules() {
        return [
            'invoice.folder_id'  => 'required',
            'invoice.subtotal'   => ['required', 'numeric'],
            'invoice.tva_id'     => 'nullable',
            'invoice.tax'        => ['nullable', 'numeric'],
            'invoice.total'      => ['required', 'numeric'],
            'amounts.*.service_id' => 'required',
            'amounts.*.amount'     => ['required', 'numeric'],
        ];
    }

    public function mount(Invoice $invoice)
    {
        $action = $invoice->id ? 'edit' : 'create';
        $this->authorize($action.'-invoice');

        $this->invoice = $invoice;
        if ($invoice->id) {
            $this->amounts = $invoice->amounts;
            $folder = $this->invoice->folder;
            $this->selectedFolder = ['id' => $folder->id, 'text' => $folder->number];
        } else {
            $this->invoice->tax = 0;
            $this->amounts = collect();
        }
        $this->services = Service::all()->pluck('name', 'id');
        $this->tvas = Tva::all()->pluck('rate', 'id');
    }

    public function updated($property, $value)
    {
        if ($property == 'invoice.tva_id') {
            if ($value) {
                $this->tva = Tva::findOrFail($value);
                $this->invoice->tax = $this->invoice->subtotal * $this->tva->rate / 100;
                $this->invoice->total = $this->invoice->subtotal + $this->invoice->tax;
            } else {
                $this->invoice->tva_id = null;
                $this->invoice->tax = 0;
                $this->invoice->total = $this->invoice->subtotal;
            }
        }
    }

    public function setTotal()
    {
        $this->invoice->subtotal = $this->amounts->sum('amount');
        if ($this->invoice->tva_id && $this->tva) {
            $this->invoice->tax = $this->invoice->subtotal * $this->tva->rate / 100;
        }
        $this->invoice->total = $this->invoice->subtotal + $this->invoice->tax;
    }

    public function addAmount()
    {
        $this->amounts->add([
            'service_id' => null,
            'amount' => null,
        ]);
    }

    public function removeAmount($index)
    {
        $this->amounts = $this->amounts->except([$index])->values();
    }

    public function save()
    {
        $this->validate();

        try {
            $this->invoice->generateUniqueNumber();

            DB::beginTransaction();

            $this->invoice->save();
            $this->invoice->amounts()->delete();
            $this->invoice->amounts()->createMany($this->amounts->toArray());

            DB::commit();

            $this->flash('success', "L'enregistrement a été effectué avec succès.");
            redirect()->route('invoices.show', $this->invoice);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function render()
    {
        return view('invoices.form');
    }
}
