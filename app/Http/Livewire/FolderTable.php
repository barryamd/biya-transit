<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;
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
        $this->authorize('view-folder');

        $user = Auth::user();
        if ($user->hasRole('Customer')) {
            $this->customerId = $user->customer ? $user->customer->id : null;
        }
    }

    public function columns(): array
    {
        return [
            Column::make('number')->hideIf(true)->searchable(),
            LinkColumn::make("Numero du dossier")
                ->title(fn($row) => $row->number)
                ->location(fn($row) => route('folders.show', $row))
                ->sortable(),
            Column::make("Numero CNT", "num_cnt")
                ->sortable(),
            Column::make("Poids total", "weight")
                ->sortable(),
            Column::make("Port", "harbor")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable()->hideIf((bool)$this->status),
            DateColumn::make("Date d'ouverture", "created_at")
                ->sortable(),
            Column::make("Client", "customer.name")
                ->sortable(),
            Column::make('Actions', 'id')
                ->view('folders.action-buttons')
        ];
    }

    public function builder(): Builder
    {
        return Folder::query()
            ->when($this->status, fn(Builder $query, $status) => $query->where('status', '=', $status))
            ->when($this->customerId, fn(Builder $query, $customerId) => $query->where('customer_id', '=', $customerId));
    }
}
