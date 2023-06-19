<?php

namespace App\Http\Livewire;

use App\Models\Folder;
use Illuminate\Support\Collection;
use Livewire\Component;

class FolderDetails extends Component
{
    public Folder $folder;
    public Collection $purchaseInvoices;

    public function mount()
    {
        $this->purchaseInvoices = $this->folder->purchaseInvoices;
    }

    public function render()
    {
        return view('folders.show-details');
    }

    public function download($collection, $modelId)
    {
        if ($collection == 'purchase_invoices') {
            $model = $this->purchaseInvoices->where('id', $modelId)->first();
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
}
