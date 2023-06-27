<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Support\Collection;
use Livewire\Component;

class InvoiceDetails extends Component
{
    public Invoice $invoice;
    public Collection $amounts;

    public function mount()
    {
        $this->amounts = InvoiceDetail::with('service')->where('invoice_id', $this->invoice->id)->get();
    }

    public function render()
    {
        return view('invoices.show-details');
    }
}
