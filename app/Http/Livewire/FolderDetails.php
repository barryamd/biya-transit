<?php

namespace App\Http\Livewire;

use App\Models\Folder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
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
        if ($collection == 'purchase_invoices')
            $model = $this->purchaseInvoices->where('id', $modelId)->first();

        if (isset($model))
            return response()->download(storage_path($model->attach_file_path));
            //return response()->download($model->file_url);
        return null;
        //return Storage::disk()->download('invoice.pdf');
    }
}
