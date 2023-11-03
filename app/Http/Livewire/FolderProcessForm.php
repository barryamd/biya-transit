<?php

namespace App\Http\Livewire;

use App\Models\Container;
use App\Models\DdiOpening;
use App\Models\Declaration;
use App\Models\Delivery;
use App\Models\DeliveryFile;
use App\Models\Document;
use App\Models\Exoneration;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderProcessForm extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;
    use WithFileUploads;

    public int $currentStep = 1;
    public bool $isEditMode = false;

    public Folder $folder;
    public User $user;

    public $exonerations;
    public Exoneration $exoneration;
    public array $products = [], $exonerationProducts = [];
    public $exonerationFile;

    public DdiOpening|null $ddiOpening = null;
    public $ddiFile;

    public $declarations;
    public Declaration $declaration;
    public $declarationFile = null, $liquidationFile, $receiptFile, $bonFile;

    public Collection $deliveryFiles;
    public $bcmFiles = [], $bctFiles = [];

    public Delivery|null $delivery = null;
    public Collection $transporterContainers, $containers, $foldersCntLta;
    public string|null $container, $transporter;
    public $deliveryExitFile, $deliveryReturnFile;

    protected $messages = [
        'deliveryFiles' => 'Il faut au minimum un bon',
    ];

    public function getRules()
    {
        return [
            'ddiOpening.dvt_number'        => ['required'],
            'ddiOpening.dvt_obtained_date' => ['required', 'date'],
            'ddiOpening.ddi_number'        => ['nullable'],
            'ddiOpening.ddi_obtained_date' => ['nullable', 'date'],

            //'exoneration.container_id'=> ['nullable'],
            'exoneration.number'      => ['nullable'],
            'exoneration.date'        => ['nullable'],
            'exoneration.responsible' => ['nullable'],

            //'declaration.container_id'         => ['nullable'],
            'declaration.number'               => ['required'],
            'declaration.date'                 => ['required', 'date'],
            'declaration.destination_office'   => ['required'],
            'declaration.verifier'             => ['required'],
            'declaration.liquidation_bulletin' => ['required'],
            'declaration.liquidation_date'     => ['required', 'date'],
            'declaration.receipt_number'       => ['required'],
            'declaration.receipt_date'         => ['required', 'date'],
            'declaration.bon_number'           => ['required'],
            'declaration.bon_date'             => ['required', 'date'],

            'folder.bcm' => ['required', 'string'],
            'folder.bct' => ['required', 'string'],
            'deliveryFiles.*.id' => 'nullable',
            'deliveryFiles.*.folder_id' => 'nullable',
            'deliveryFiles.*.bcm_file_path' => 'nullable',
            'deliveryFiles.*.bct_file_path' => 'nullable',

            'delivery.date'  => ['required', 'date'],
            'delivery.place' => ['required'],
        ];
    }

    public function mount()
    {
        $this->authorize('update-folder');

        $this->user = Auth::user();

        $this->folder->load('exonerations.container', 'exonerations.products');
        $this->exonerations = $this->folder->exonerations;
        if ($this->exonerations->count() > 0) {
            $this->currentStep = 2;
        } else {
            $this->exonerations = collect();
        }
        $this->exoneration = new Exoneration();
        $this->products = $this->folder->products->pluck('designation', 'id')->toArray();

        $this->containers = Container::query()->where('folder_id', $this->folder->id)
            ->pluck('number', 'id');
        $this->foldersCntLta = Folder::query()->pluck('num_cnt', 'id');

        $this->ddiOpening = $this->folder->ddiOpening;
        if ($this->ddiOpening) {
            $this->currentStep = 3;
        } else {
            $this->ddiOpening = new DdiOpening();
        }

        $this->declarations = $this->folder->declarations;
        if ($this->declarations->count()) {
            $this->currentStep = 4;
        } else {
            $this->declarations = collect();
        }
        $this->declaration = new Declaration();

        $this->deliveryFiles = $this->folder->deliveryFiles->collect();
        if ($this->folder->bcm) {
            $this->currentStep = 5;
        }

        $this->delivery = $this->folder->deliveryDetails;
        if ($this->delivery) {
            $this->transporterContainers = Container::with('transporter')
                ->where('folder_id', $this->folder->id)->whereHas('transporter')->get();
        } else {
            $this->delivery = new Delivery();
            $this->transporterContainers = collect();
        }
    }

    public function saveExoneration()
    {
        $this->validate([
            //'exoneration.container_id'=> ['required'],
            'exoneration.number'      => ['required', Rule::unique('exonerations', 'number')->ignore($this->exoneration->id)],
            'exoneration.date'        => ['required', 'date'],
            'exoneration.responsible' => ['required', 'string'],
            'exonerationProducts'     => ['required'],
            'exonerationFile'         => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            if (!$this->isEditMode)
                $this->exoneration->folder_id = $this->folder->id;

            DB::beginTransaction();
            $this->exoneration->save();
            $this->exoneration->products()->sync($this->exonerationProducts);
            DB::commit();

            if ($this->exonerationFile)
                $this->exoneration->addFile($this->exonerationFile);

            $this->closeModal('exonerationFormModal');

            $this->exonerations = Exoneration::with('container', 'products')
                ->where('folder_id', $this->folder->id)->get();

            $this->alert('success', "L'exoneration a été enregistré avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function editExoneration($id)
    {
        try {
            $this->exoneration = Exoneration::find($id);
            $this->exonerationProducts = $this->exoneration->products->pluck('id')->toArray();
            $this->isEditMode = true;
            $this->dispatchBrowserEvent('open-exonerationFormModal');
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function deleteExoneration($id)
    {
        $exoneration = Exoneration::query()->find($id);
        $exoneration->delete();
        $this->exonerations = Exoneration::with('container', 'products')
            ->where('folder_id', $this->folder->id)->get();
        $this->alert('success', "L'exoneration a été supprimée avec succès.");
    }


    public function submitDdiOpeningStep()
    {
        $this->validate([
            'ddiOpening.dvt_number'        => ['required', 'string', Rule::unique('ddi_openings', 'dvt_number')->ignore($this->ddiOpening->id)],
            'ddiOpening.dvt_obtained_date' => ['required', 'date'],
            'ddiOpening.ddi_number'        => ['nullable', 'string', Rule::unique('ddi_openings', 'ddi_number')->ignore($this->ddiOpening->id)],
            'ddiOpening.ddi_obtained_date' => ['nullable', 'date'],
            'ddiFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->ddiOpening->folder_id = $this->folder->id;
            $this->ddiOpening->save();
            if ($this->ddiFile) {
                $this->ddiOpening->addFile($this->ddiFile);
            }
            $this->folder->update(['status' => 'En cours']);

            if ($this->user->can('add-declaration')) {
                $this->currentStep = 3;
            }

            $this->alert('success', "Ouverture ddi éfféctué avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }


    public function saveDeclaration()
    {
        $this->validate([
            //'declaration.container_id'         => ['required', Rule::unique('declarations', 'container_id')->ignore($this->declaration->id)],
            'declaration.number'               => ['required', 'string', Rule::unique('declarations', 'number')->ignore($this->declaration->id)],
            'declaration.date'                 => ['required', 'date'],
            'declaration.destination_office'   => ['required', 'string'],
            'declaration.verifier'             => ['required', 'string'],
            'declaration.liquidation_bulletin' => ['nullable', 'string', Rule::unique('declarations', 'liquidation_bulletin')->ignore($this->declaration->id)],
            'declaration.liquidation_date'     => ['nullable', 'date'],
            'declaration.receipt_number'       => ['nullable', 'string', Rule::unique('declarations', 'receipt_number')->ignore($this->declaration->id)],
            'declaration.receipt_date'         => ['nullable', 'date'],
            'declaration.bon_number'           => ['nullable', 'string', Rule::unique('declarations', 'bon_number')->ignore($this->declaration->id)],
            'declaration.bon_date'             => ['nullable', 'date'],
            'declarationFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'liquidationFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'receiptFile'     => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'bonFile'         => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->declaration->folder_id = $this->folder->id;
            $this->declaration->save();
            if ($this->declarationFile) {
                $this->declaration->addFile($this->declarationFile, 'declaration_file_path');
            }
            if ($this->liquidationFile) {
                $this->declaration->addFile($this->liquidationFile, 'liquidation_file_path');
            }
            if ($this->receiptFile) {
                $this->declaration->addFile($this->receiptFile, 'receipt_file_path');
            }
            if ($this->bonFile) {
                $this->declaration->addFile($this->bonFile, 'bon_file_path');
            }

            $this->closeModal('declarationFormModal');
            $this->alert('success', "La declaration a été enregistrée avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function editDeclaration($id)
    {
        try {
            $this->declaration = Declaration::find($id);
            $this->isEditMode = true;
            $this->dispatchBrowserEvent('open-declarationFormModal');
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function deleteDeclaration($id)
    {
        $declaration = Declaration::query()->find($id);
        $declaration->delete();
        $this->declarations = Declaration::with('container')->where('folder_id', $this->folder->id)->get();
        $this->alert('success', "La declaration a été supprimée avec succès.");
    }


    public function addDeliveryFile()
    {
        $this->deliveryFiles->add([
            'folder_id' => null,
            'bcm_file_path' => null,
            'bct_file_path' => null,
        ]);
    }

    public function removeDeliveryFile($index)
    {
        $this->deliveryFiles = $this->deliveryFiles->except([$index])->values();
    }

    public function submitDeliveryNoteStep()
    {
        $this->validate([
            'folder.bcm' => ['nullable', 'string', Rule::unique('folders', 'bcm')->ignore($this->folder->id)],
            'folder.bct' => ['nullable', 'string', Rule::unique('folders', 'bct')->ignore($this->folder->id)],
            'deliveryFiles.*.id' => 'nullable',
            'deliveryFiles.*.folder_id' => 'nullable',
            'deliveryFiles.*.bcm_file_path' => 'nullable',
            'deliveryFiles.*.bct_file_path' => 'nullable',
            'deliveryFiles' => 'required',
            'bcmFiles.*' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'bctFiles.*' => ['required', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->folder->save();
            foreach ($this->deliveryFiles as $index => $deliveryFileInputs) {
                $deliveryFileInputs['folder_id'] = $this->folder->id;
                if (array_key_exists('id', $deliveryFileInputs)) {
                    $deliveryFile = $this->folder->deliveryFiles->where('id', $deliveryFileInputs['id'])->first();
                    $deliveryFile->update($deliveryFileInputs);
                } else {
                    $deliveryFile = DeliveryFile::query()->create($deliveryFileInputs);
                }
                if (array_key_exists($index, $this->bcmFiles)) {
                    $deliveryFile->addFile($this->bcmFiles[$index], 'bcm_file_path');
                }
                if (array_key_exists($index, $this->bctFiles)) {
                    $deliveryFile->addFile($this->bctFiles[$index], 'bct_file_path');
                }
            }

            if ($this->user->can('add-delivery-details')) {
                $this->currentStep = 5;
            }

            $this->alert('success', "Les bons de livraisons ont été enregistrés avec succès.");
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }


    public function addTransporter()
    {
        $this->validate([
            'container' => ['required', 'string'],
            'transporter' => ['required', 'string'],
        ]);

        try {
            $container = Container::query()->find($this->container);
            $container->update(['transporter_id' => $this->transporter]);

            $this->transporterContainers = Container::with('transporter')
                ->where('folder_id', $this->folder->id)->whereHas('transporter')->get();

            $this->closeModal('transporterFormModal');
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function editTransporter($containerId)
    {
        $this->container = $containerId;
        $this->isEditMode = true;
        $this->dispatchBrowserEvent('open-transporterFormModal');
    }

    public function submitDeliveryDetailsStep()
    {
        $this->validate([
            'delivery.date'  => ['required', 'date'],
            'delivery.place' => ['required', 'string'],
            'deliveryExitFile'   => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'deliveryReturnFile' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        try {
            $this->delivery->folder_id = $this->folder->id;
            $this->delivery->save();
            if ($this->deliveryExitFile) {
                $this->delivery->addFile($this->deliveryExitFile, 'exit_file_path');
            }
            if ($this->deliveryReturnFile) {
                $this->delivery->addFile($this->deliveryReturnFile, 'return_file_path');
            }

            $this->transporterContainers = Container::with('transporter')
                ->where('folder_id', $this->folder->id)->whereHas('transporter')->get();

            $this->alert('success', "Les détails de la livraison ont été enregistrés avec succès.");
            //redirect()->route('folders.show', $this->folder);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function closeModal($modalId)
    {
        $this->dispatchBrowserEvent('close-'.$modalId);
        if ($modalId == 'transporterFormModal') {
            $this->container = $this->transporter = null;

        } elseif ($modalId == 'exonerationFormModal') {
            $this->exoneration = new Exoneration();
            $this->exonerationProducts = [];
            $this->exonerationFile = null;

        } elseif ($modalId == 'declarationFormModal') {
            $this->declaration =  new Declaration();
            $this->declarationFile = $this->liquidationFile = $this->receiptFile = $this->bonFile = null;
        }
        $this->isEditMode = false;
    }

    public function setStep($step)
    {
        $this->currentStep = $step;
    }

    public function render()
    {
        return view('folders.process-form');
    }

    public function downloadFile($collection, $attribute = 'attach_file_path', $modelId = null)
    {
        $filePath = '';
        if ($collection == 'exonerations') {
            $exoneration = $this->exonerations->where('id', $modelId)->first();
            $filePath = $exoneration?->$attribute;
        } elseif ($collection == 'ddi_openings') {
                $filePath = $this->ddiOpening?->$attribute;
        } elseif ($collection == 'declarations') {
            $declaration = $this->declarations->where('id', $modelId)->first();
            $filePath = $declaration?->$attribute;
        } elseif ($collection == 'delivery_files') {
            $deliveryFile = $this->deliveryFiles->where('id', $modelId)->first();
            $filePath = $deliveryFile?->$attribute;
        } elseif ($collection == 'deliveries') {
            $filePath = $this->delivery?->$attribute;
        }
        $filePath = public_path('uploads/'.$filePath);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
        return null;
    }

    public function deleteFile($collection, $attribute = 'attach_file_path', $modelId = null)
    {
        if ($collection == 'exonerations') {
            $exoneration = $this->exonerations->where('id', $modelId)->first();
            $exoneration?->deleteFile($attribute);
        } elseif ($collection == 'ddi_openings') {
            $this->ddiOpening?->deleteFile($attribute);
        } elseif ($collection == 'declarations') {
            $declaration = $this->declarations->where('id', $modelId)->first();
            $declaration?->deleteFile($attribute);
        } elseif ($collection == 'delivery_files') {
            $deliveryFile = $this->deliveryFiles->where('id', $modelId)->first();
            $deliveryFile?->deleteFile($attribute);
        } elseif ($collection == 'deliveries') {
            $this->delivery?->deleteFile($attribute);
        }
    }
}
