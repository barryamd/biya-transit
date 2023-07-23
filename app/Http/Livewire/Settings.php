<?php

namespace App\Http\Livewire;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;
    use WithFileUploads;

    public Setting $setting;
    public $logo;
    public $signature;

    protected function rules()
    {
        return [
            'setting.name'         => ['required', 'string'],
            'setting.acronym'      => ['required', 'string'],
            'setting.email'        => ['nullable', 'string'],
            'setting.phone1'       => ['required', 'string'],
            'setting.phone2'       => ['nullable', 'string'],
            'setting.phone3'       => ['nullable', 'string'],
            'setting.address'      => ['nullable', 'string'],
            'setting.bic'          => ['nullable', 'string'],
            'setting.iban'         => ['nullable', 'string'],
            'setting.bank'         => ['nullable', 'string'],
            'setting.bank_address' => ['nullable', 'string'],
            'logo'              => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'signature'         => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    public function mount()
    {
        $this->authorize('update-settings');

        $this->setting = Setting::query()->get()->first();
    }

    public function updated($property, $value)
    {
        if ($property == 'setting.name') {
            $this->setting->acronym = explode(' ', $this->setting->name)[0];
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $this->setting->saveOrFail();
                if ($this->logo)
                    $this->setting->updatePhoto($this->logo, 'logo', 'logo.png');
                if ($this->signature)
                    $this->setting->updatePhoto($this->signature, 'signature', 'signature.jpg');
            });
            $this->alert('success', 'La modification a été enregistré avc succès.');
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function render()
    {
        return view('settings.form');
    }
}
