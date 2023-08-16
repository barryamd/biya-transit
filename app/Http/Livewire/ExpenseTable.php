<?php

namespace App\Http\Livewire;

use App\LivewireTables\DataTableComponent;
use App\LivewireTables\Views\Column\DateColumn;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ExpenseTable extends DataTableComponent
{
    protected $model = Expense::class;
    protected array $createButtonParams = [
        'title' => 'Nouvelle depense',
        'modal' => 'expenseFormModal',
        'permission' => 'create-expense',
    ];
    public Expense $expense;

    public function mount()
    {
        $this->authorize('read-expense');

        $this->expense = new Expense();
    }

    public function columns(): array
    {
        return [
            Column::make("Numero du dossier", 'folder.number')
                ->sortable(),
            Column::make("Type de depense", "type")
                ->sortable()->searchable(),
            Column::make("Montant", "amount")
                ->sortable(),
            DateColumn::make("Date d'ajout", "created_at")
                ->sortable(),
            Column::make('Actions', 'id')
                ->view('expenses.action-buttons')
        ];
    }

    public function builder(): Builder
    {
        return Expense::with('folder');
    }

    protected function rules(): array
    {
        return [
            'expense.folder_id'   => 'required',
            'expense.type'        => ['required', 'string'],
            'expense.amount'      => ['required', 'numeric'],
            'expense.description' => ['nullable', 'string'],
        ];
    }

    public function openEditModal(int $id, $modalId = null)
    {
        try {
            $this->expense = $this->model::findOrFail($id);
            $this->isEditMode = true;
            $this->dispatchBrowserEvent('open-expenseFormModal');
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $this->expense->save();
            $this->closeModal();
            $this->alert('success', "La depense a été enregistré avec succès.");
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function closeModal($modalId = null)
    {
        $this->dispatchBrowserEvent('close-expenseFormModal');
        $this->emitSelf('refresh');
        $this->expense = new Expense();
        $this->isEditMode = false;
    }

    public function customView(): string
    {
        return 'expenses.form-modal';
    }
}
