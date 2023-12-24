<?php

namespace App\Http\Livewire;

use App\Actions\Fortify\PasswordValidationRules;
use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\LivewireTables\Views\Column\SwitchColumn;
use App\LivewireTables\Views\YesNoFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Spatie\Permission\Models\Role;

class UserTable extends DataTableComponent
{
    //use PasswordValidationRules;

    public string $tableName = 'users';
    public array $users = [];

    public $columnSearch = [
        'name' => null,
        'email' => null,
    ];

    protected $model = User::class;
    protected array $createButtonParams = [
        'title' => 'Nouveau utilisateur',
        'modal' => 'userFormModal',
        'permission' => 'create-user',
    ];

    public User $user;
    //public string $password = '', $password_confirmation = '';
    public array $roles = [];
    public int|null $role;

    public function columns(): array
    {
        return [
            ImageColumn::make('Photo')
                ->location(fn($row) =>  getProfilePhotoUrlAttribute($row->profile_photo_path))
                ->attributes(fn($row) => ['class' => 'h-25 w-25 rounded-circle', 'alt' => 'Photo']),
            Column::make('Nom', 'first_name')
                ->format(fn($value, $row) => $row->full_name)
                ->sortable()
                ->searchable(),
            Column::make('Adresse E-mail', 'email')
                ->sortable()
                ->searchable(),
            SwitchColumn::make('Active')
                ->sortable()
                ->collapseOnMobile(),
            DateColumn::make('Verifié', 'email_verified_at')
                ->sortable()
                ->collapseOnTablet(),
            Column::make('Role')
                ->label(fn($row) => $row->roles->pluck('name')->implode(', ')),
            Column::make('Actions', 'id')
                ->view('users.actions')
                ->collapseOnMobile()
                ->excludeFromColumnSelect()
        ];
    }

    public function filters(): array
    {
        return [
            MultiSelectFilter::make('Roles')
                ->options(Role::query()->orderBy('name')->pluck('name','id')->toArray())
                ->filter(function(Builder $builder, array $values) {
                    $builder->whereHas('roles', fn($query) => $query->whereIn('roles.id', $values));
                }),
            YesNoFilter::make('E-mail Verifé', 'email_verified_at'),
            YesNoFilter::make('Active')->setFilterPillTitle('Status'),
//            DateFilter::make('Verified From')
//                ->filter(function(Builder $builder, string $value) {
//                    $builder->where('email_verified_at', '>=', $value);
//                }),
//            DateFilter::make('Verified To')
//                ->filter(function(Builder $builder, string $value) {
//                    $builder->where('email_verified_at', '<=', $value);
//                }),
        ];
    }

    public function builder(): Builder
    {
        return User::query()->with('roles')
            ->whereDoesntHave('customer')->where('id', '<>', Auth::user()->id)
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('users.first_name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['email'] ?? null, fn ($query, $email) => $query->where('users.email', 'like', '%' . $email . '%'));
    }

    public function bulkActions(): array
    {
        return [
            'activate' => 'Activate',
            'deactivate' => 'Deactivate',
            //'deleteSelected' => 'Delete',
            //'exportSelected' => 'Export',
            //'exportAll' => 'Export All',
        ];
    }

    public function activate()
    {
        User::whereIn('id', $this->getSelected())->update(['active' => true]);

        $this->clearSelected();
    }

    public function deactivate()
    {
        User::whereIn('id', $this->getSelected())->update(['active' => false]);

        $this->clearSelected();
    }

    public function mount()
    {
        $this->authorize('read-user');
        $this->user = new User();
        $this->roles = Role::query()->where('name', '<>', 'Super Admin')
            ->pluck('name', 'id')->toArray();
    }

    protected function rules()
    {
        return [
            'user.email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id)
            ],
            //'password' => $this->isEditMode ? 'nullable' : $this->passwordRules(),
            'role' => 'required',
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.last_name'  => ['required', 'string', 'max:255'],
            'user.birth_date' => [
                'nullable', 'date',
                /*function ($attribute, $value, $fail) {
                    $years = Date::create($value)->diffInYears(now());
                    if ($years < 18)
                        $fail(__('The minimum age of an employee is 18 years').'.');
                }*/
            ],
            'user.birth_place'  => ['nullable', 'string', 'max:255'],
            'user.phone_number' => ['nullable', 'string', 'max:255'],
            'user.address'      => ['nullable', 'string', 'max:255'],
        ];
    }

    public function openEditModal($userId, $modalId = null)
    {
        try {
            $this->user = User::find($userId);
            $this->role = $this->user->has('roles') ? $this->user->roles()->first()->id : null;
            $this->dispatchBrowserEvent('open-'.$modalId);
            $this->isEditMode = true;
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $password = Str::random(8);

            DB::beginTransaction();
                if (!$this->isEditMode) {
                    $user = User::create(
                        array_merge($this->user->toArray(), ['password' => Hash::make($password)])
                    );
                    $user->syncRoles([$this->role]);
                } else {
                    $this->user->save();
                    $this->user->syncRoles([$this->role]);
                }
            DB::commit();

            $this->closeModal('userFormModal');
            $this->alert('success', __('The user has been created successfully.'));

            if (!$this->isEditMode && $user) {
                $user->password = $password;
                $user->sendEmailVerificationNotification();
            }
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function closeModal($modalId = null)
    {
        $this->dispatchBrowserEvent('close-'.$modalId);
        $this->isEditMode = false;
        $this->user = new User();
        $this->role = null;
        //$this->password = $this->password_confirmation = '';
    }

    public function customView(): string
    {
        return 'users.form-modal';
    }
}
