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
            'folder.harbor'      => ['required', 'string'],
            'folder.country'     => ['required', 'string'],
            'folder.num_cnt'     => ['required', 'string'],
            'folder.observation' => ['nullable', 'string'],
            'selectedProducts'   => ['required'],

            'containers'                  => 'nullable',
            'containers.*.id'             => 'nullable',
            'containers.*.folder_id'      => 'nullable',
            'containers.*.type_id'        => 'required',
            'containers.*.number'         => [
                'required', 'string',
                Rule::unique('containers', 'number')->ignore($this->folder->id, 'folder_id'),
                function ($attribute, $value, $fail) {
//                    if ($value == $this->folder->num_cnt) {
//                        $fail('Ce numéro doit être identique au CNT.');
//                    }

                    if ($this->containers->where('number', $value)->count() > 1) {
                        $fail('Ce numéro est dupliqué.');
                    }
                },
            ],
            'containers.*.weight'         => ['required', 'numeric'],
            'containers.*.package_number' => ['required', 'numeric'],
            'containers.*.arrival_date'   => ['required', 'date'],
            'containers.*.user_id'        => 'nullable',

            'documents'             => 'required',
            'documents.*.id'        => 'nullable',
            'documents.*.folder_id' => 'nullable',
            'documents.*.type_id'   => 'required',
            'documents.*.number'    => [
                'required','string',
                function ($attribute, $value, $fail) {
                    if ($value == $this->folder->num_cnt) {
                        $fail('Ce numéro doit être différent du numéro CNT.');
                    }

                    if ($this->documents->where('number', $value)->count() > 1) {
                        $fail('Ce numéro est dupliqué.');
                    }
                },
                Rule::unique('documents', 'number')->ignore($this->folder->id, 'folder_id')
            ],
            'documents.*.user_id'   => 'nullable',
            'documentsFiles.*'      => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ];
    }

    public function mount(Folder $folder)
    {
        $this->authorize(($folder->id ? 'update' : 'create').'-folder');

        if ($folder->id) {
            $folder->load('customer.user');
            $this->selectedCustomer = [[
                'id' => $folder->customer->id,
                'text' => $folder->customer->user->full_name
            ]];

            $folder->load(['containers', 'documents', 'products']);

            $this->containers = $folder->containers->collect();
            $this->documents = $folder->documents->collect();

            $this->selectedProducts = $folder->products->pluck('id')->toArray();
            $this->products = $folder->products->map(function ($product) {
                return ['id' => $product->id, 'text' => $product->designation];
            })->toArray();
        } else {
            $this->containers = collect();
            $this->documents = collect();

            $user = Auth::user();
            if ($user->customer) {
                $folder->customer_id = $user->customer->id;
            }
        }
        $this->folder = $folder;

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
            'id' => null,
            'folder_id' => null,
            'type_id' => null,
            'number' => null,
            'weight' => null,
            'package_number' => null,
            'arrival_date' => null,
            'user_id' => Auth::user()->id
        ]);
    }

    public function removeContainer($index, $id = null)
    {
        $container = $this->folder->containers->where('id', $id)->first();
        $container?->delete();
        $this->containers = $this->containers->except([$index])->values();
        $this->alert('success', 'Le conteneur a été supprimé avec succès');
    }

    public function setTotalWeight()
    {
        $this->totalWeight = $this->containers->sum('weight');
    }

    public function addDocument()
    {
        $this->documents->add([
            'id' => null,
            'folder_id' => null,
            'type_id' => null,
            'number' => null,
            'attach_file_path' => null,
            'user_id' => Auth::user()->id
        ]);
    }

    public function removeDocument($index, $id = null)
    {
        $document = $this->deleteDocumentFile($id);
        $document?->delete();
        $this->documents = $this->documents->except([$index])->values();
        $this->alert('success', 'Le document a été supprimé avec succès');
    }

    public function downloadDocumentFile($id)
    {
        $document = Document::query()->find($id);
        $filePath = public_path('uploads/'.$document->attach_file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
        return null;
    }

    public function deleteDocumentFile($id)
    {
        $document = $this->folder->documents->where('id', $id)->first();
        $document?->deleteFile();
        return $document;
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-addProductModal');
        $this->productDesignation = '';
    }

    public function save()
    {
        $this->validate();

        try {
            if (!$this->folder->id) {
                $this->folder->generateUniqueNumber();
                $this->folder->user_id = Auth::user()->id;
            }
            if (!$this->folder->user_id)
                $this->folder->user_id = Auth::user()->id;

            DB::beginTransaction();

            $this->folder->save();
            $this->folder->num_cnt = $this->folder->getCntOrLta();
            $this->folder->products()->sync($this->selectedProducts);

            /*
            if ($this->folder->id) {
                Container::query()->where('folder_id', $this->folder->id)
                    ->whereNotIn('id', $this->containers->pluck('id'))->delete();
            }
            $containers = $this->containers->map(function ($item) {
                unset($item['created_at'], $item['updated_at']);
                $item['folder_id'] = $this->folder->id;
                return $item;
            });
            Container::query()->upsert($containers->toArray(), ['id']);
            */

            foreach ($this->containers as $containerInputs) {
                $containerInputs['folder_id'] = $this->folder->id;
                Container::query()->updateOrCreate($containerInputs);
            }

            foreach ($this->documents as $index => $documentInputs) {
                $documentInputs['folder_id'] = $this->folder->id;
                unset($documentInputs['type']);
                $document = Document::query()->updateOrCreate($documentInputs);
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

    public function render()
    {
        return view('folders.form');
    }
}
