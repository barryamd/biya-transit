<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\Service;
use App\Models\Tva;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class InvoiceForm extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public Invoice $invoice;
    public Collection|array $amounts;
    public Collection|array $services = [];
    public Collection|array $tvas = [];
    public $tva;

    protected function rules() {
        return [
            'invoice.invoice_id' => 'nullable',
            'invoice.subtotal'   => ['required', 'numeric'],
            'invoice.tva_id'     => 'nullable',
            'invoice.tax'        => ['required', 'numeric'],
            'invoice.total'      => ['required', 'numeric'],
            'amounts.*.service_id' => 'required',
            'amounts.*.amount'     => ['required', 'numeric'],
        ];
    }

    public function mount(invoice $invoice)
    {
        $this->invoice = $invoice;
        if ($invoice->id) {
            $this->amounts = $invoice->amounts;
        } else {
            $this->amounts = collect();
        }
        $this->services = Service::all()->pluck('name', 'id');
        $this->tvas = Tva::all()->pluck('rate', 'id');
    }

    public function updated($property, $value)
    {
        if ($property == 'invoice.tva_id') {
            $this->tva = Tva::findOrFail($value);
            $this->invoice->tax = $this->invoice->subtotal * $this->tva->rate / 100;
            $this->invoice->total = $this->invoice->subtotal + $this->invoice->tax;
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
            $this->invoice->amounts()->createMany($this->amounts);

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
