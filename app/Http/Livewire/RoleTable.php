<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;
    protected array $createButtonParams = [
        'title' => 'Nouveau role',
        'route' => 'roles.create',
        'permission' => 'create-role',
    ];

    public function mount()
    {
        $this->authorize('view-role');
    }

    public function columns(): array
    {
        return [
            Column::make('Nom', 'name')->sortable()->searchable(),
            Column::make('Actions', 'id')->view('users.role-actions')
                ->excludeFromColumnSelect()
        ];
    }

    public function builder(): Builder
    {
        return Role::query()->with('permissions')
            ->where('id', '<>', Auth::user()->id)->orWhere('name', '<>', 'Admin');
    }

//    public function filters(): array
//    {
//        return [
//            MultiSelectFilter::make('Roles')
//                ->options(Permission::query()->orderBy('name')->pluck('name','id')->toArray())
//                ->filter(function(Builder $builder, array $values) {
//                    $builder->whereHas('Permissions', fn($query) => $query->whereIn('Permissions.id', $values));
//                }),
//        ];
//    }
}
