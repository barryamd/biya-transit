<?php

namespace App\Http\Livewire;

use App\Models\Charge;
use App\Models\Folder;
use App\Models\FolderCharge;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FolderChargeForm extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;

    public Folder $folder;
    public Collection|array $charges;

    protected function rules() {
        return [
            'charges.*.id'        => 'nullable',
            'charges.*.folder_id' => 'required',
            'charges.*.name'      => ['required', 'string'],
            'charges.*.amount'    => ['required', 'numeric'],
        ];
    }

    public function mount(Folder $folder)
    {
        $action = $folder->id ? 'update' : 'create';
        $this->authorize($action.'-charge');

        $folder->load('charges');
        $this->folder = $folder;
        $this->charges = $folder->charges->collect();
    }

    public function addCharge()
    {
        $this->charges->add([
            'id' => null,
            'folder_id' => $this->folder->id,
            'name' => null,
            'amount' => null,
        ]);
    }

    public function removeCharge($index, $id = null)
    {
        $charge = $this->folder->charges->where('id', $id)->first();
        $charge?->delete();
        $this->charges = $this->charges->except([$index])->values();
        $this->alert('success', 'La charge a été supprimée avec succès');
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            // FolderCharge::query()->upsert($this->charges->toArray(), ['id']);
            foreach ($this->charges as $chargeInputs) {
                FolderCharge::query()->updateOrCreate($chargeInputs);
            }
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
