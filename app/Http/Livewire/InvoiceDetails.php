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
    public mixed $folder;
    public $containers;
    public string $totalInText;

    public function mount()
    {
        $this->invoice->load('folder.customer.user', 'folder.containers', 'charges.service');

        $this->folder = $this->invoice->folder;
        $this->containers = $this->folder->containers;
        $this->folder->loadCount('containers');

        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter('fr_FR', \NumberFormatter::SPELLOUT);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        $this->totalInText = $moneyFormatter->format(new Money($this->invoice->total, new Currency('GNF')));
    }

    public function render()
    {
        return view('invoices.show-details');
    }
}
