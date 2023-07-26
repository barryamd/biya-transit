<?php

namespace App\Http\Livewire;

use App\Models\Container;
use App\Models\ContainerType;
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

class FolderForm extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;
    use WithFileUploads;

    public Folder $folder;
    public $selectedCustomer = [];
    public Collection $containers;
    public Collection $documents;
    public Collection|array $selectedProducts = [], $products = [];
    public array|string $documentsFiles = [];
    public string $productDesignation = '';
    public Collection|array $containerTypes = [], $documentTypes = [];
    public float $totalWeight = 0.0;

    protected $messages = [
        'containers' => 'Il faut au minimum un conteneur',
        'documents' => 'Il faut au minimum un document',
    ];

    protected function rules() {
        return [
            'folder.customer_id' => 'nullable',
            'folder.type'        => 'required',
            'folder.num_cnt'     => [
                'required', 'string',
                Rule::unique('folders', 'num_cnt')->ignore($this->folder->id)
            ],
            'folder.weight'      => [
                'required', 'string',
                function ($attribute, $value, $fail) {
                    if ($this->containers->sum(fn($item) => $item['weight']) > $value) {
                        $fail('Ce numéro est dupliqué.');
                    }
                }
            ],
            'folder.harbor'      => ['required', 'string'],
            'folder.country'     => ['required', 'string'],
            'folder.observation' => ['nullable', 'string'],
            'selectedProducts'   => ['required'],

            'containers'                  => 'required',
            'containers.*.folder_id'      => 'nullable',
            'containers.*.type_id'        => 'required',
            'containers.*.number'         => [
                'required', 'string',
                function ($attribute, $value, $fail) {
                    if ($this->containers->where('number', $value)->count() > 1) {
                        $fail('Ce numéro est dupliqué.');
                    }
                }
            ],
            'containers.*.weight'         => ['required', 'string'],
            'containers.*.package_number' => ['required', 'string'],
            'containers.*.arrival_date'   => ['required', 'date'],

            'documents'             => 'required',
            'documents.*.folder_id' => 'nullable',
            'documents.*.type_id'   => 'required',
            'documents.*.number'    => [
                'required','string',
                function ($attribute, $value, $fail) {
                    if ($this->documents->where('number', $value)->count() > 1) {
                        $fail('Ce numéro est dupliqué.');
                    }
                }
            ],
            'documentsFiles.*'      => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ];
    }

    public function mount(Folder $folder)
    {
        $this->authorize(($folder->id ? 'edit' : 'create').'-folder');

        $this->folder = $folder;
        if ($this->folder->id) {
            $this->folder->load('customer.user');
            $this->selectedCustomer = [[
                'id' => $this->folder->customer->id,
                'text' => $this->folder->customer->user->full_name
            ]];

            $this->containers = $this->folder->containers->collect();
            $this->documents = $this->folder->documents->collect();

            $this->selectedProducts = $this->folder->products->pluck('id')->toArray();
            $this->products = $this->folder->products->map(function ($product) {
                return ['id' => $product->id, 'text' => $product->designation];
            })->toArray();
        } else {
            $this->containers = collect();
            $this->documents = collect();

            $user = Auth::user();
            if ($user->customer) {
                $this->folder->customer_id = $user->customer->id;
            }
        }

        $this->containerTypes = ContainerType::all()->pluck('label', 'id');
        $this->documentTypes = DocumentType::all()->pluck('label', 'id');
    }

    public function addNewProduct()
    {
        $this->validate([
            'productDesignation' => [
                'required', 'string', Rule::unique('products', 'designation')
            ]
        ]);

        try {
            $product = Product::query()->create([
                'designation' => $this->productDesignation
            ]);
            $this->closeModal();
            //$this->alert('success', "Le produit a été enregistré avec succès.");
            $this->emit('newProductAdded', [$product->id, $product->designation]);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function addContainer()
    {
        $this->containers->add([
            'folder_id' => null,
            'type_id' => null,
            'number' => null,
            'weight' => null,
            'package_number' => null,
            'arrival_date' => null,
        ]);
    }

    public function setTotalWeight()
    {
        $this->totalWeight = $this->containers->sum('weight');
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
            'attach_file_path' => null,
        ]);
    }

    public function removeDocument($index)
    {
        $this->documents = $this->documents->except([$index])->values();
    }

    public function save()
    {
        $this->validate();

        try {
            $this->folder->generateUniqueNumber();

            DB::beginTransaction();

            $this->folder->save();
            $this->folder->products()->sync($this->selectedProducts);

            if ($this->folder->id) {
                Container::query()->where('folder_id', $this->folder->id)
                    ->whereNotIn('id', $this->containers->pluck('id'))->delete();
            }
            $containers = $this->containers->map(function ($item) {
                $item['folder_id'] = $this->folder->id;
                return $item;
            });
            Container::query()->upsert($containers->toArray(), ['id']);

            foreach ($this->documents as $index => $documentInputs) {
                $documentInputs['folder_id'] = $this->folder->id;
                if (array_key_exists('id', $documentInputs)) {
                    $document = $this->folder->documents->where('id', $documentInputs['id'])->first();
                    $document->update($documentInputs);
                } else {
                    $document = Document::query()->create($documentInputs);
                }
                if (array_key_exists($index, $this->documentsFiles)) {
                    $document->addFile($this->documentsFiles[$index]);
                }
            }

            DB::commit();

            $this->flash('success', "L'enregistrement a été effectué avec succès.");
            redirect()->route('folders.show', $this->folder);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-addProductModal');
        $this->productDesignation = '';
    }

    public function render()
    {
        return view('folders.form');
    }
}
