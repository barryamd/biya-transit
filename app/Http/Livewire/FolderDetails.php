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
use App\Models\Transporter;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FolderDetails extends Component
{
    use LivewireAlert;

    public Folder $folder;
    public Collection $containers, $documents;

    public $exonerations;
    public DdiOpening|null $ddiOpening = null;
    public $declarations;
    public $deliveryFiles;
    public Delivery|null $delivery = null;

    public function mount()
    {
        $this->folder->loadSum('containers', 'weight')
            ->loadSum('containers', 'package_number')
            ->load('customer.user');

        $this->containers = Container::with('type', 'transporter')
            ->where('folder_id', $this->folder->id)->get();

        $this->documents = Document::with('type')
            ->where('folder_id', $this->folder->id)->get();

        $this->exonerations = Exoneration::with('container', 'products')
            ->where('folder_id', $this->folder->id)->get();

        $this->ddiOpening = $this->folder->ddiOpening;

        $this->declarations = $this->folder->declarations;

        $this->deliveryFiles = $this->folder->deliveryFiles;

        $this->delivery = $this->folder->deliveryDetails;
    }

    public function render()
    {
        return view('folders.show-details');
    }

    public function downloadFile($collection, $attribute = 'attach_file_path', $modelId = null)
    {
        $filePath = '';
        if ($collection == 'exonerations') {
            $exoneration = $this->exonerations->where('id', $modelId)->first();
            $filePath = $exoneration->$attribute;
        } elseif ($collection == 'ddi_openings') {
            $filePath = $this->ddiOpening->$attribute;
        } elseif ($collection == 'declarations') {
            $declaration = $this->declarations->where('id', $modelId)->first();
            $filePath = $declaration->$attribute;
        } elseif ($collection == 'delivery_notes') {
            $deliveryNote = $this->deliveryFiles->where('id', $modelId)->first();
            $filePath = $deliveryNote->$attribute;
        } elseif ($collection == 'deliveries') {
            $filePath = $this->delivery->$attribute;
        }
        $filePath = public_path('uploads/'.$filePath);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
        return null;
    }

    public function closeFolder()
    {
        $this->validate([
            'ddiOpening.ddi_number'        => 'required',
            'ddiOpening.ddi_obtained_date' => 'required',
            'ddiOpening.attach_file_path'  => 'required',

            'exonerations.*.attach_file_path' => 'required',

            'declaration.liquidation_bulletin'  => 'required',
            'declaration.liquidation_date'      => 'required',
            'declaration.receipt_number'        => 'required',
            'declaration.receipt_date'          => 'required',
            'declaration.bon_number'            => 'required',
            'declaration.bon_date'              => 'required',
            'declaration.declaration_file_path' => 'required',
            'declaration.liquidation_file_path' => 'required',
            'declaration.receipt_file_path'     => 'required',
            'declaration.bon_file_path'         => 'required',

            'deliveryFiles.*.bcm_file_path' => 'required',
            'deliveryFiles.*.bct_file_path' => 'required',

            'delivery.exit_file_path'   => 'required',
            'delivery.return_file_path' => 'required',
        ]);

        $this->folder->update(['status' => 'Fermé']);
        $this->flash('success', "Le dossier a été fermé avec succès.");
        redirect()->route('closed-folders.index');
    }
}
