<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleShow extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;

    public $role;
    public array $rolePermissions;
    public array $permissions;
    public array $tables;

    public $redirect = '/admin/roles';
    /**
     * @var string[]
     */
    public array $groupPermissions;

    public function mount(Role $role)
    {
        $this->authorize('read-role');

        $this->role = $role->name;
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
            'charge'     => 'Gestion des charges',
            'invoice'     => 'Gestion des factures',
            'folder'      => 'Gestion des dossiers',
        ];
        $this->tables = ['user', 'role', 'customer', 'transporter', 'charge', 'invoice', 'folder'];
    }

    public function render()
    {
        return view('users.role-show');
    }
}
