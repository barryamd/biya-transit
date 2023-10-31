<?php

namespace App\Http\Livewire;

use App\Models\Folder;
use App\Models\FolderCharge;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderChargeDetails extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;

    public Folder $folder;
    public Collection|array $charges;

    protected function rules() {
        return [
            'charges.*.folder_id' => 'required',
            'charges.*.name'   => ['required', 'string'],
            'charges.*.amount' => ['required', 'numeric'],
        ];
    }

    public function mount(Folder $folder)
    {
        $action = $folder->id ? 'edit' : 'create';
        $this->authorize($action.'-charge');

        $this->folder = $folder;
        $this->charges = $folder->charges->collect();
    }

    public function addCharge()
    {
        $this->charges->add([
            'folder_id' => $this->folder->id,
            'name' => null,
            'amount' => null,
        ]);
    }

    public function removeCharge($index)
    {
        $this->charges = $this->charges->except([$index])->values();
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            FolderCharge::query()->upsert($this->charges->toArray(), ['id']);
            DB::commit();

            $this->flash('success', "Les charges ont été enregistrées avec succès.");
            redirect()->route('folder-charges.index');
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function render()
    {
        return view('folder-charges.form');
    }
}
