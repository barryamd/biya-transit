<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Folder;
use Illuminate\Support\Collection;
use Livewire\Component;

class FolderDetails extends Component
{
    public Folder $folder;
    public Collection $documents;

    public function mount()
    {
        $this->documents = Document::with('type')->where('folder_id', $this->folder->id)->get();
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
}
