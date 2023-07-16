<?php

namespace App\Http\Livewire;

use App\Models\DdiOpening;
use App\Models\Declaration;
use App\Models\Delivery;
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
    public Collection $documents;

    public DdiOpening|null $ddiOpening = null;
    public Exoneration|null $exoneration = null;
    public Declaration|null $declaration = null;
    public $deliveryNotes;
    public Delivery|null $delivery = null;
    public Transporter|null $transporter = null;

    public function mount()
    {
        $this->documents = Document::with('type')->where('folder_id', $this->folder->id)->get();

        $this->ddiOpening = $this->folder->ddiOpening;
        $this->exoneration = $this->folder->exoneration;
        if ($this->exoneration)
            $this->exoneration->load('products');
        $this->declaration = $this->folder->declaration;
        $this->deliveryNotes = $this->folder->deliveryNotes;
        $this->delivery = $this->folder->deliveryDetails;
        if ($this->delivery)
            $this->transporter = $this->delivery->transporter;
    }

    public function render()
    {
        return view('folders.show-details');
    }

    public function download($collection, $modelId)
    {
        if ($collection == 'folders') {
            $model = $this->documents->where('id', $modelId)->first();
        }

        if (isset($model)) {
            $filePath = public_path('uploads/'.$model->attach_file_path);

            if (file_exists($filePath)) {
                return response()->download($filePath);
            } else {
                abort(404, 'File not found');
            }
        }
        return null;
    }

    public function closeFolder()
    {
        $this->validate([
            'ddiOpening.ddi_number'        => 'required',
            'ddiOpening.ddi_obtained_date' => 'required',
            'ddiOpening.attach_file_path'  => 'required',

            'exoneration.attach_file_path' => 'required',

            'declaration.declaration_file_path' => 'required',
            'declaration.liquidation_file_path' => 'required',
            'declaration.receipt_file_path'     => 'required',
            'declaration.bon_file_path'         => 'required',

            'deliveryNotes.*.attach_file_path' => 'required',

            'delivery.exit_file_path'   => 'required',
            'delivery.return_file_path' => 'required',
        ]);

        $this->folder->update(['status' => 'Fermé']);
        $this->flash('success', "Le dossier a été fermé avec succès.");
        redirect()->route('closed-folders.index');
    }
}
