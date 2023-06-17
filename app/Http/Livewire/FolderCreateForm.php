<?php

namespace App\Http\Livewire;

use App\Models\Folder;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderCreateForm extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public Folder $folder;
    public Collection $containers;
    public Collection $invoices;
    public array $products = [];
    public array|string $invoicesFiles = [];
    public $cntFile;
    public string $productCode = '', $productDesignation = '';

    protected function rules() {
        return [
            'folder.num_cnt'     => 'required',
            'folder.ship'        => 'required',
            'folder.harbor'      => 'required',
            'folder.observation' => 'nullable',
            'cntFile'            => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'products'           => 'required',

//            'containers.*.folder_id'      => 'nullable',
//            'containers.*.number'         => 'required',
//            'containers.*.designation'    => 'required',
//            'containers.*.weight'         => ['required', 'numeric'],
//            'containers.*.package_number' => 'required',
//            'containers.*.filling_date'   => ['required', 'date'],
//            'containers.*.arrival_date'   => ['required', 'date'],
//
//            'invoices.*.folder_id'      => 'nullable',
//            'invoices.*.invoice_number' => 'required',
//            'invoices.*.amount'         => 'required',
//            'invoicesFiles.*'           => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function mount(Folder $folder)
    {
        $this->folder = $folder;
        $this->containers = $this->invoices = collect();
    }

    public function addNewProduct()
    {
        $this->validate([
            'productCode' => 'required',
            'productDesignation' => 'required'
        ]);

        try {
            $product = Product::query()->create([
                'code' => $this->productCode,
                'designation' => $this->productDesignation
            ]);

            $this->alert('success', "Le produit a été enregistré avec succès.");
            $this->emit('newProductAdded', [$product->id, $product->code.' - '.$product->designation]);
            $this->dispatchBrowserEvent('close-addProductModal');
            $this->reset('productCode', 'productDesignation');
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function addContainer()
    {
        $this->containers->add([
            'folder_id' => null,
            'number' => null,
            'designation' => null,
            'weight' => null,
            'package_number' => null,
            'filling_date' => null,
            'arrival_date' => null,
        ]);
    }

    public function removeContainer($index)
    {
        $this->containers = $this->containers->except([$index])->values();
    }

    public function addInvoice()
    {
        $this->invoices->add([
            'folder_id' => null,
            'invoice_number' => null,
            'amount' => null,
            'attach_file' => null,
        ]);
    }

    public function removeInvoice($index)
    {
        $this->invoices = $this->invoices->except([$index])->values();
    }

    public function save()
    {
        $this->validate();

        try {
            $this->folder->generateUniqueNumber();
            $this->folder->customer_id = Auth::user()->customer->id;

            DB::beginTransaction();

            $this->folder->save();
            $this->folder->addFile($this->cntFile);
            $this->folder->products()->sync($this->products);
            $this->folder->containers()->createMany($this->containers);

            //$this->folder->purchaseInvoices()->createMany($this->invoices);
            //$invoices = PurchaseInvoice::query()->where('folder_id', $this->folder->id)->get();
            foreach ($this->invoices as $index => $invoiceInputs) {
                $invoiceInputs['folder_id'] = $this->folder->id;
                $invoice = new PurchaseInvoice($invoiceInputs);
                $invoice->save();
                $invoice->addFile($this->invoicesFiles[$index]);
            }

            DB::commit();

            $this->flash('success', "L'enregistrement a été effectué avec succès.");
            redirect()->route('folders.show', $this->folder);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function render()
    {
        return view('folders.create-form');
    }
}
