<?php

namespace App\Http\Livewire;

use App\Actions\Fortify\PasswordValidationRules;
use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\LivewireTables\Views\Column\SwitchColumn;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class CustomerTable extends DataTableComponent
{
    use PasswordValidationRules;

    protected $model = User::class;
    protected array $createButtonParams = [
        'title' => 'Nouveau client',
        'modal' => 'customerFormModal',
        'permission' => 'create-customer',
    ];
    public User $user;
    public Customer $customer;
    public string $password = '', $password_confirmation = '';

    public function mount()
    {
        $this->authorize('view-customer');
        $this->user = new User();
        $this->customer = new  Customer();
    }

    public function columns(): array
    {
        return [
            Column::make("NIF", "customer.nif")
                ->sortable()->searchable(),
            Column::make("Prenoms et Nom", "first_name")
                ->format(fn($value, $row) => $row->full_name)
                ->sortable()->searchable(),
            Column::make("", "last_name")
                ->hideIf(true)->searchable(),
            Column::make("Téléphone", "phone_number")
                ->sortable()->searchable(),
            Column::make("Email", "email")
                ->sortable()->searchable(),
            SwitchColumn::make('Active')
                ->sortable()
                ->collapseOnMobile(),
            DateColumn::make("Date d'ajout", "created_at")
                ->sortable()
                ->collapseOnTablet(),
            Column::make('Actions', 'id')
                ->view('customers.action-buttons')
                ->collapseOnMobile()
                ->excludeFromColumnSelect()
        ];
    }

    public function builder(): Builder
    {
        return User::with('customer')->whereHas('customer');
    }

    protected function rules(): array
    {
        return [
            'user.email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id)
            ],
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.last_name'  => ['required', 'string', 'max:255'],
            'user.phone_number' => [
                'required', 'string',
                Rule::unique('users', 'phone_number')->ignore($this->user->id)
            ],
            'user.address' => ['nullable', 'string', 'max:255'],
            'password' => $this->isEditMode ? 'nullable' : $this->passwordRules(),

            'customer.name' => [
                'nullable', 'string',
                Rule::unique('customers', 'name')->ignore($this->customer->id)
            ],
            'customer.nif' => [
                'required', 'string',
                Rule::unique('customers', 'nif')->ignore($this->customer->id)
            ],
            'customer.phone_number1' => ['nullable', 'string'],
            'customer.phone_number2' => ['nullable', 'string'],
            'customer.phone_number3' => ['nullable', 'string'],
            'customer.email1' => ['nullable', 'string', 'email', 'max:255',],
            'customer.email2' => ['nullable', 'string', 'email', 'max:255',],
            'customer.email3' => ['nullable', 'string', 'email', 'max:255',],
        ];
    }

    public function openEditModal(int $id, $modalId = null)
    {
        try {
            $this->user = $this->model::findOrFail($id);
            $this->customer = $this->user->customer;
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
            if (!$this->isEditMode)
                $this->user->password = Hash::make($this->password);
            DB::transaction(function () {
                $this->user->saveOrFail();
                if (!$this->isEditMode) {
                    $this->user->givePermissionTo(['view-folder', 'create-folder', 'edit-folder']);
                    $this->customer->user_id = $this->user->id;
                }
                $this->customer->save();
            });

            if (!$this->isEditMode) {
                $this->user->password = $this->password;
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
        $this->isEditMode = false;
        $this->user = new User();
        $this->customer = new Customer();
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function customView(): string
    {
        return 'customers.form-modal';
    }
}
