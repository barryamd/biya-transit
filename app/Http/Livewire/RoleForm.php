<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleForm extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;

    public Role $role;
    public array $rolePermissions;
    public array $permissions;
    public array $tables;

    public $redirect = '/admin/roles';
    /**
     * @var string[]
     */
    public array $groupPermissions;

    protected function rules()
    {
        return [
            'role.name' => ['required', 'string',
                ($this->role->id)
                    ? Rule::unique('roles', 'name')->ignore($this->role->id)
                    : Rule::unique('roles', 'name')
            ],
            'rolePermissions' => 'required',
        ];
    }

    public function mount(Role $role)
    {
        $action = $role->id ? 'edit' : 'create';
        $this->authorize($action.'-role');

        $this->role = $role;
        $this->rolePermissions = $role->permissions()->pluck('id')->toArray();

        $permissions = Permission::all()->pluck('name', 'id')->toArray();
        $this->permissions = array_flip($permissions);
        $this->groupPermissions = [
            'dashboard'   => 'Tableau de bord',
            'user'        => 'Gestion des utilisateurs',
            'role'        => 'Gestion des rôles',
            'settings'    => 'Gestion des paramètres',
            'customer'    => 'Gestion des clients',
            'transporter' => 'Gestion des transporteurs',
            'expense'     => 'Gestion des dépenses',
            'invoice'     => 'Gestion des factures',
            'folder'      => 'Gestion des dossiers',
        ];
        $this->tables = ['user', 'role', 'customer', 'transporter', 'expense', 'invoice'];
    }

    public function save()
    {
        $this->validate();

        $this->role->guard_name = 'web';

        try {
            $this->role->saveOrFail();
            $this->role->syncPermissions($this->rolePermissions);

            $message = "L'enregistrement a été effectué avec succès.";
            if ($this->redirect) {
                $this->flash('success', $message);
                redirect()->route("roles.show", $this->role);
            } else {
                $this->role = new Role();
                $this->alert('success', $message);
            }
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function render()
    {
        return view('users.role-form');
    }
}
