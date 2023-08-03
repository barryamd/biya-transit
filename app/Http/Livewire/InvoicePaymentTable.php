<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\Models\Folder;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class InvoicePaymentTable extends DataTableComponent
{
    protected $model = InvoicePayment::class;
    protected array $createButtonParams = [
        'title' => 'Nouveau paiement',
        'modal' => 'paymentFormModal',
        'permission' => 'create-payment'
    ];

    public int|null $invoiceId = null;

    public InvoicePayment $payment;
    public Invoice $invoice;
    public $invoices = [];
    public $customer, $due_amount = 0, $invoice_amount = 0;
    public $date;

    public function mount($invoiceId = null)
    {
        $this->authorize('view-payment');
        $this->invoiceId = $invoiceId;
        $this->date = date('Y-m-d');
        $this->payment = new InvoicePayment(['type' => 'espece']);
        $this->payment->created_at = $this->date;
    }

    public function columns(): array
    {
        return [
            Column::make("N° du dossier", "folder.number"),
            //->linkTo(fn($value, $column, $row) => route('folders.show', $row->folder_id)),
            Column::make("N° de la facture", "invoice.number"),
                //->linkTo(fn($value, $column, $row) => route('invoices.show', $row->invoice_id)),
            Column::make("Client", "folder.customer.name"),
                //->linkTo(fn($value, $column, $row) => route('customers.show', $row->folder->customer_id)),
            DateColumn::make("Date du paiement", "created_at")->sortable(),
            Column::make("Montant", "amount")->sortable()
                ->format(fn($value) => moneyFormat($value))
                ->footer(fn($rows) => '<strong>Total: </strong>'.moneyFormat($rows->sum('amount')))->html(),
            Column::make("Details du paiement", "note"),
            //Column::make("Caissier(e)", "user.name"),
            Column::make('Actions', 'id')
                ->view('invoice-payments.actions-buttons')
        ];
    }

    public function filters(): array
    {
        return [
            DateFilter::make('Début période', 'from')
                ->filter(fn($query, $date) => $query->where('date', '>=', $date)),
            DateFilter::make('Fin période', 'to')
                ->filter(fn($query, $date) => $query->where('date', '<=', $date)),
            SelectFilter::make('Dossier')
                ->options(Folder::all()->pluck('number', 'id')
                    ->merge(['' => '--Séléctioner--'])->reverse()->toArray())
                ->filter(fn ($query, $folder) => $query->where('folder_id', '=', $folder)),
            SelectFilter::make('Mode de paiement', 'payment')
                ->options(array_merge(['' => '--Séléctioner--'], aPaymentMethods()))
                ->filter(fn ($query, $payment) => $query->where('type', '=', $payment)),
            NumberFilter::make('Montant min', 'total_min')
                ->filter(fn($query, $amount) => $query->where('total', '>=', $amount)),
            NumberFilter::make('Montant max', 'total_max')
                ->filter(fn($query, $amount) => $query->where('total', '<=', $amount)),
        ];
    }

    public function query(): Builder
    {
        return Payment::query()->with('folder.customer')->with('invoice')
            //->select('invoice_payments.*', 'invoices.number')
            ->when($this->invoiceId, fn(Builder $query, $invoiceId) => $query->where('invoice_id', '=', $invoiceId));
    }

    protected function rules()
    {
        return [
            'payment.folder_id' => ['required', 'numeric'],
            'payment.invoice_id' => ['required', 'numeric'],
            'payment.amount' => ['required', 'numeric'],
            'payment.created_at' => ['required', 'date'],
            'payment.type' => ['required', 'string'],
            'payment.check_number' => ['nullable'/*'required_if:payment.type,cheque'*/, 'string'],
            'payment.bank' => ['nullable'/*'required_if:payment.type,virement'*/, 'string'],
            'payment.date' => ['nullable'/*'required_if:payment.type,cheque'*/, 'date'],
            'payment.note' => ['nullable', 'string'],
        ];
    }

    public function updated($name, $value): void
    {
        if ($name == 'payment.folder_id' && !$this->payment->id) {
            $this->setInvoices($value);
        }

        if ($name === 'payment.invoice_id') {
            $this->invoice = Invoice::findOrFail($value);
            $this->invoice->loadSum('payments', 'amount');
            $this->invoice_amount = round($this->invoice->total - $this->invoice->payments_sum_amount);
            $this->payment->amount = $this->invoice_amount;
        }

        if ($name === 'payment.amount') {
            $this->due_amount = round($this->invoice_amount - $this->payment->amount);
            if ($value >= $this->invoice_amount)
                $this->invoice->status = 'paid';
            if ($value > 0 && $value < $this->invoice_amount)
                $this->invoice->status = 'partial';
        }
    }

    public function openEditModal($id, $modalId)
    {
        try {
            $this->payment = InvoicePayment::findOrFail($id);
            $this->invoice = $this->payment->invoice;
            $this->invoice->loadSum('payments', 'amount');
            $this->invoice_amount = round($this->invoice->total - $this->invoice->payments_sum_amount + $this->payment->amount);
            $this->payment->created_at = Str::before($this->payment->created_at, ' ');
            $folder = $this->invoice->folder;

            $this->emit('setFolder', [$folder->id, $folder->number]);
            $this->emit('setInvoice', [$this->invoice->id, $this->invoice->number]);
            $this->dispatchBrowserEvent('open-paymentFormModal');
        } catch (\Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }
    }

    public function savePayment()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                //$this->payment->user_id = auth()->user()->id;
                $this->payment->saveOrFail();
                if ($this->invoice->total <= ($this->invoice->payments_sum_amount + $this->payment->amount)) {
                    //$this->invoice->status = 'paid';
                    $this->invoice->saveOrFail();
                }
            });

            $this->closeModal();
            $this->alert('success', "Le paiement a été effectué avec succès.");
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function closeModal($modalId = null)
    {
        $this->dispatchBrowserEvent('close-paymentFormModal');
        $this->payment = new InvoicePayment(['type' => 'espece']);
        $this->payment->created_at = $this->date;
    }

    public function customView(): string
    {
        return 'invoice-payments.form-modal';
    }

    public function setInvoices($folderId)
    {
        $invoices = Invoice::query()->withSum('payments', 'amount')
            ->where('folder_id', '=', $folderId)->get();

        $this->invoices = $invoices->filter(function ($item) {
            $item->remaining = $item->total - $item->payments_sum_amount;
            return $item->remaining >= 10 ? $item : null;
        })->pluck('number', 'id')->toArray();

        $options = '<option value="">--Sélectionner la facture à payer--</option>';
        foreach ($this->invoices as $key => $value) {
            $options .= "<option value='$key'>$value</option>";
        }

        $this->emit('setInvoices', $options);
    }
}
