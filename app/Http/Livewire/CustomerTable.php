<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;

class CustomerTable extends DataTableComponent
{
    protected $model = Customer::class;
    protected array $createButtonParams = [
        'text'  => 'Nouveau client',
        'modal' => 'customerFormModal',
        'roles' => 'admin',
    ];
    public Customer $customer;
    public string|null $email;

    public function mount()
    {
        $this->customer = new Customer();
    }

    public function columns(): array
    {
        return [
            Column::make("NIF", "nif")
                ->sortable()->searchable(),
            Column::make("Nom", "name")
                ->sortable(),
            Column::make("Téléphone", "phone")
                ->sortable()->searchable(),
            Column::make("Email", "user.email")
                ->sortable(),
            DateColumn::make("Date d'ajout", "created_at")
                ->sortable(),
            Column::make('Actions', 'id')
                ->view('customers.action-buttons')
        ];
    }

    public function builder(): Builder
    {
        return Customer::with('user');
    }

    protected function rules(): array
    {
        return [
            'customer.nif' => [
                'required', 'string',
                Rule::unique('customers', 'nif')->ignore($this->customer->id)
            ],
            'customer.name' => ['required', 'string'],
            'customer.phone'     => [
                'required', 'string',
                Rule::unique('customers', 'phone')->ignore($this->customer->id)
            ],
            'email' => [
                $this->isEditMode ? 'nullable' : 'required', 'string', 'email',
                Rule::unique('users', 'email')->ignore($this->customer->user_id)
            ],
        ];
    }

    public function openEditModal(int $id, $modalId = null)
    {
        try {
            $this->customer = $this->model::findOrFail($id);
            $this->isEditMode = true;
            $this->dispatchBrowserEvent('open-customerFormModal');
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEditMode) {
                $this->customer->save();
            } else {
                $user = DB::transaction(function () {
                    return tap(User::create([
                        //'name' => $this->username,
                        'email' => $this->email,
                        'password' => Hash::make($this->customer->nif),
                    ]), function (User $user) {
                        $user->assignRole('customer');
                        $this->customer->user_id = $user->id;
                        $this->customer->saveOrFail();
                    });
                });
                $user->password = $this->customer->nif;
                //event(new Registered($user));
            }

            $this->closeModal();
            $this->alert('success', "Le client a été enregistré avec succès.");
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function closeModal($modalId = null)
    {
        $this->dispatchBrowserEvent('close-customerFormModal');
        $this->emitSelf('refresh');
        $this->customer = new Customer();
        $this->isEditMode = false;
    }

    public function customView(): string
    {
        return 'customers.form-modal';
    }
}
