<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Support\Collection;
use Livewire\Component;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

class InvoiceDetails extends Component
{
    public Invoice $invoice;
    public Collection $amounts;
    public mixed $folder;
    public $containers;
    public string $totalInText;

    public function mount()
    {
        $this->amounts = InvoiceDetail::with('service')->where('invoice_id', $this->invoice->id)->get();

        $this->invoice->loadSum('amounts', 'amount')
            ->load('folder.customer.user', 'folder.containers', 'amounts.service');
        $this->folder = $this->invoice->folder;
        $this->containers = $this->folder->containers;
        $this->amounts = $this->invoice->amounts;
        $this->folder->loadCount('containers');

        $total = new Money($this->invoice->amounts_sum_amount, new Currency('GNF'));
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter('fr_FR', \NumberFormatter::SPELLOUT);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        $this->totalInText = $moneyFormatter->format($total);
    }

    public function render()
    {
        return view('invoices.show-details');
    }
}
