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
        $this->authorize('view-role');

        $this->role = $role->name;
        $this->rolePermissions = $role->permissions()->pluck('id')->toArray();

        $permissions = Permission::all()->filter(function ($item) {
            if (!Str::contains($item->name, ['folder', 'add'])){
                return $item;
            }
            return null;
        })->pluck('name', 'id')->toArray();

        $tables = array_map(function ($item) {
            return Str::after($item,'-');
        }, $permissions);

        $this->permissions = array_flip($permissions);
        $this->tables = array_unique($tables);
        $this->groupPermissions = [
            'dashboard'   => 'Tableau de bord',
            'user'        => 'Gestion des utilisateurs',
            'role'        => 'Gestion des rôles',
            'settings'    => 'Gestion des paramètres',
            'customer'    => 'Gestion des clients',
            'transporter' => 'Gestion des transporteurs',
            'expense'     => 'Gestion des dépenses',
            'invoice'     => 'Gestion des clients',
            'folder'      => 'Gestion des dossiers',
            'pending-folder'  => 'Gestion des dossiers',
            'progress-folder' => 'Gestion des dossiers',
            'closed-folder'   => 'Gestion des dossiers',
        ];
    }

    public function render()
    {
        return view('users.role-show');
    }
}
