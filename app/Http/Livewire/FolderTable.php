<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class FolderTable extends DataTableComponent
{
    protected $model = Folder::class;
    protected array $createButtonParams = [
        'title' => 'Nouveau dossier',
        'route' => 'folders.create',
        'permission' => 'create-folder',
    ];
    public string|null $status = null;
    public int|null $customerId = null;

    public function mount()
    {
        $this->authorize('read-folder');

        $user = Auth::user();
        if ($user->customer) {
            $this->customerId = $user->customer->id;
        }
    }

    public function columns(): array
    {
        $user = Auth::user();
        return [
            Column::make('number')->hideIf(true)->searchable(),
            Column::make('bcm')->hideIf(true)->searchable(),
            Column::make('bct')->hideIf(true)->searchable(),
            Column::make('number')->hideIf(true)->searchable(),
            LinkColumn::make("Numero du dossier")
                ->title(fn($row) => $row->number)
                ->location(fn($row) => route('folders.show', $row))
                ->sortable(),
            Column::make("Type de dossier", 'type')
                ->sortable(),
            Column::make("Numero CNT", "num_cnt")
                ->sortable()->searchable(),
            Column::make("Pays d'origine", 'country')
                ->format(fn($value) => __($value))
                ->sortable()->searchable(),
            Column::make("Port", "harbor")
                ->sortable()->searchable(),
            Column::make("Status", "status")
                ->sortable()->hideIf((bool)$this->status),
            DateColumn::make("Date d'ouverture", "created_at")
                ->sortable(),
            Column::make("Client", "customer.nif")
                ->format(fn($value, $row) => $row->customer?->user?->full_name),
            Column::make("Entreprise", "customer.name"),
            Column::make("Autheur", "user.first_name")
                ->format(fn($value, $row) => $row->user?->full_name),
            Column::make('Actions', 'id')
                ->format(fn($value, $row) => view('folders.action-buttons',
                    ['row' => $row, 'status' => $this->status])),
            Column::make('', 'id')
                ->searchable(function(Builder $query, $searchTerm) {
                    $query->orWhereRelation('declarations', 'number', $searchTerm)
                        ->orWhereRelation('declarations', 'receipt_number', $searchTerm);
                })->hideIf(true),
//            ButtonGroupColumn::make('Actions')
//                ->attributes(fn($row) => ['class' => 'btn-group btn-group-sm'])
//                ->buttons([
//                    $this->viewButton('folders.show')->hideIf(!$user->can('read-folder')),
//                    $this->editButton('folders.edit')->hideIf(!$user->can('update-folder')),
//                    $this->deleteButton()->hideIf(!$user->can('delete-folder'))
//                ]),
        ];
    }

    public function builder(): Builder
    {
        return Folder::query()->with('customer.user', 'user')->select('folders.*')
            ->when(is_null($this->status), fn(Builder $query, $status) => $query->where('status', '<>', 'Fermé'))
            ->when($this->status, fn(Builder $query, $status) => $query->where('status', '=', $status))
            ->when($this->customerId, fn(Builder $query, $customerId) => $query->where('customer_id', '=', $customerId));
    }
}
