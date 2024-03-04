<?php

namespace App\Http\Livewire;

use App\Models\Folder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FolderChargeShow extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;

    public Folder $folder;
    public Collection|array $charges;

    public function mount(Folder $folder)
    {
        $this->authorize('read-charge');
        $this->folder = $folder;
        $this->charges = $folder->charges;
    }

    public function render()
    {
        return view('folder-charges.show');
    }
}
