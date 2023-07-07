<?php

namespace App\Http\Livewire;

use App\Models\DocumentType;
use App\Models\Folder;
use App\Models\Product;
use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderCreateForm extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;
    use WithFileUploads;

    public Folder $folder;
    public Collection $containers;
    public Collection $documents;
    public array $products = [];
    public array|string $documentsFiles = [];
    public string $productDesignation = '';
    public Collection|array $documentTypes = [];

    protected function rules() {
        return [
            'folder.customer_id' => 'nullable',
            'folder.num_cnt'     => [
                'required', 'string',
                Rule::unique('folders', 'num_cnt')
            ],
            'folder.weight'      => ['required', 'string'],
            'folder.harbor'      => ['required', 'string'],
            'folder.observation' => ['nullable', 'string'],
            'products'           => ['required'],
            'documents'          => ['nullable'],

            'containers.*.folder_id'      => 'nullable',
            'containers.*.number'         => ['required', 'string'],
            'containers.*.weight'         => ['required', 'string'],
            'containers.*.package_number' => ['required', 'string'],
            'containers.*.arrival_date'   => ['required', 'date'],

            'documents.*.folder_id' => 'nullable',
            'documents.*.type_id'   => 'required',
            'documents.*.number'    => ['required','string', Rule::unique('documents', 'number')],
            'documentsFiles.*'      => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ];
    }

    public function mount(Folder $folder)
    {
        $this->authorize('create-folder');

        $this->folder = $folder;
        $this->containers = $this->documents = collect();
        $this->documentTypes = DocumentType::all()->pluck('label', 'id');

        $user = Auth::user();
        if ($user->hasRole('Customer'))
            $this->folder->customer_id = $user->customer->id;
    }

    public function addNewProduct()
    {
        $this->validate([
            'productDesignation' => [
                'required', 'string',
                Rule::unique('products', 'designation')
            ]
        ]);

        try {
            $product = Product::query()->create([
                'designation' => $this->productDesignation
            ]);
            $this->closeModal();
            $this->alert('success', "Le produit a été enregistré avec succès.");
            $this->emit('newProductAdded', [$product->id, $product->designation]);
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
            'arrival_date' => null,
        ]);
    }

    public function removeContainer($index)
    {
        $this->containers = $this->containers->except([$index])->values();
    }

    public function addDocument()
    {
        $this->documents->add([
            'folder_id' => null,
            'type_id' => null,
            'number' => null,
            'attach_file' => null,
        ]);
    }

    public function removeDocument($index)
    {
        $this->documents = $this->documents->except([$index])->values();
    }

    public function save()
    {
        $this->validate();

//        try {
            $this->folder->generateUniqueNumber();

            DB::beginTransaction();

            $this->folder->save();
            $this->folder->products()->sync($this->products);
            $this->folder->containers()->createMany($this->containers);

            //$this->folder->purchaseDocuments()->createMany($this->documents);
            //$documents = PurchaseDocument::query()->where('folder_id', $this->folder->id)->get();
            foreach ($this->documents as $index => $documentInputs) {
                $documentInputs['folder_id'] = $this->folder->id;
                $document = new Document($documentInputs);
                $document->save();
                $document->addFile($this->documentsFiles[$index]);
            }

            DB::commit();

            $this->flash('success', "L'enregistrement a été effectué avec succès.");
            redirect()->route('folders.show', $this->folder);
//        } catch (\Exception $e) {
//            throw new UnprocessableEntityHttpException($e->getMessage());
//        }
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-addProductModal');
        $this->productDesignation = '';
    }

    public function render()
    {
        return view('folders.create-form');
    }
}
