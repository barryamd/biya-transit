<?php

namespace App\Http\Livewire;

use App\Models\FolderCharge;
use App\Models\Folder;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Tva;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
    public Collection|array $charges;
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
            'charges.*.service_id'   => 'required',
            'charges.*.service_name' => 'required',
            'charges.*.amount'       => ['required', 'numeric'],
            'charges.*.benefit'      => ['required', 'numeric'],
        ];
    }

    public function mount(Invoice $invoice)
    {
        $action = $invoice->id ? 'update' : 'create';
        $this->authorize($action.'-invoice');

        $this->invoice = $invoice;
        if ($invoice->id) {
            $this->charges = $invoice->charges->collect();
            $folder = $invoice->folder;
            $this->selectedFolder = ['id' => $folder->id, 'text' => $folder->number];
        } else {
            $this->invoice->tax = 0;
            $this->charges = collect();
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

        if ($property == 'invoice.folder_id') {
            $charges = FolderCharge::with('service')->whereHas('service')
                ->where('folder_id', $this->invoice->folder_id)->get();

            foreach ($charges as $charge) {
                $this->charges->add([
                    'service_id' => $charge->service_id,
                    'service_name' => $charge->service->name,
                    'amount' => $charge->amount,
                    'benefit' => null,
                ]);
            }

            $this->setTotal();
        }
    }

    public function setTotal()
    {
        $this->invoice->subtotal = $this->charges->sum('amount') + $this->charges->sum('benefit');
        if ($this->invoice->tva_id && $this->tva) {
            $this->invoice->tax = $this->invoice->subtotal * $this->tva->rate / 100;
        }
        $this->invoice->total = $this->invoice->subtotal + $this->invoice->tax;
    }

    public function addCharge()
    {
        $this->charges->add([
            'service_id' => null,
            'service_name' => null,
            'amount' => null,
            'benefit' => null,
        ]);
    }

    public function removeCharge($index)
    {
        $this->charges = $this->charges->except([$index])->values();
        $this->setTotal();
    }

    public function save()
    {
        $this->validate();

        try {
            if (!$this->invoice->id) {
                $this->invoice->generateUniqueNumber();
                $this->invoice->user_id = Auth::user()->id;
            }
            if (!$this->invoice->user_id)
                $this->invoice->user_id = Auth::user()->id;

            DB::beginTransaction();

            $this->invoice->save();
            $this->invoice->charges()->delete();
            $this->invoice->charges()->createMany($this->charges->except(['service_name'])->toArray());

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
