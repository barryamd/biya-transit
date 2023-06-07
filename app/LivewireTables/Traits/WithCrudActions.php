<?php

namespace App\LivewireTables\Traits;

use Jantinnerezo\LivewireAlert\LivewireAlert;
//use Maatwebsite\Excel\Excel;

trait WithCrudActions
{
    use LivewireAlert;

    public $isEditMode = false;
    public $rowId = null;
    public $resourceName = 'Resource';

    public function save()
    {
        if ($this->rowId) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $validatedData = $this->validate();

        if (isset($this->repository))
            $this->repository->store($validatedData);
        else
            $this->model::create($validatedData);
        $this->dispatchBrowserEvent('close-modal');
        $this->alert('success', __($this->resourceName) . ' ' . __('messages.common.saved_successfully'));
        $this->resetInputs();
    }

    public function showEditModal(int $id, $editModalId)
    {
        $model = $this->model::find($id);

        if ($model) {
            $this->rowId = $id;
            $this->fillInputs($model);
            $this->dispatchBrowserEvent('open-'.$editModalId);
        }
    }

    public function update()
    {
        $validatedData = $this->validate();

        if (isset($this->repository))
            $this->repository->update($validatedData);
        else
            $this->model::where('id', $this->rowId)->update($validatedData);
        $this->dispatchBrowserEvent('close-modal');
        $this->alert('success', __($this->resourceName) . ' ' . __('messages.common.updated_successfully'));
        $this->resetInputs();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated($propertyName, $propertyValue): void
    {
        $this->validateOnly($propertyName);
    }

    public function closeModal($modalId)
    {
        $this->dispatchBrowserEvent('close-'.$modalId);
        $this->emitSelf('refresh');
        $this->resetInputs();
    }

    public function fillInputs($model)
    {
        unset($model->id);
        $this->fill($model->toArray());
    }

    public function resetInputs()
    {
        $this->rowId = null;
        $this->reset((new $this->model())->getFillable());
    }

    //------------------------------------------------------------------------------------------------------------------

    public function deleteAll(): void
    {
        if ($this->model) {
            $models = $this->model::all();

            foreach ($models as $model) {
                $model->delete();
            }
        }
        $this->emit('refreshDatatable');
    }

    public function deleteSelected(): void
    {
        $this->confirm(__('Are you sure you want to delete the selected resources?'), [
            'confirmButtonText' => __('Yes'),
            'cancelButtonText' => __('No'),
            'onConfirmed' => 'confirmed',
        ]);
    }

    public function delete($id): void
    {
        $this->rowId = (int)$id;
        $this->confirm(__('Are you sure you want to delete this resource?'), [
            'confirmButtonText' => __('Yes'),
            'cancelButtonText' => __('No'),
            'onConfirmed' => 'confirmed',
        ]);
    }

    public function confirmed()
    {
        if ($this->model) {
            try {
                if ($this->rowId) {
                    if ($this->model::findOrFail($this->rowId)->delete()) {
                        $this->emit('refreshDatatable');
                        $this->alert('success', __('Resource deleted successfully.'));
                        $this->rowId = null;
                    }
                } elseif ($this->selectedRowsQuery->count() > 0) {
                    $models = $this->model::whereIn('id', $this->selectedKeys())->get();
                    foreach ($models as $model) {
                        $model->delete();
                    }
                    $this->resetBulk();
                    $this->alert('success', __('Resources deleted successfully.'));
                }
                // $this->resetAll(); // Réinitialisez tous les filtres et critères.
            } catch (\Exception $exception) {
                $this->alert('error', 'Error! '.$exception->getMessage());
            }
        } else $this->alert('error', 'Error!');
    }

    //------------------------------------------------------------------------------------------------------------------

    public function forceDeleteAll()
    {
        if ($this->model) {
            $models = $this->model::onlyTrashed()->get();

            foreach ($models as $model) {
                $model->forceDelete();
            }
        }

        $this->emit('refreshDatatable');
    }

    public function forceDeleteSelected()
    {
        if ($this->model && $this->selectedRowsQuery->count() > 0) {
            $models = $this->model::onlyTrashed()->whereIn('id', $this->selectedKeys())->get();

            foreach ($models as $model) {
                $model->forceDelete();
            }
        }

        $this->resetBulk();
    }

    public function forceDelete($id, $attachedFilePath = null)
    {
        if ($this->model && $id) {
            $model = $this->model::onlyTrashed()->find($id);
            $model->forceDelete();
        }

        $this->emit('refreshDatatable');
    }

    //------------------------------------------------------------------------------------------------------------------

    public function restoreAll()
    {
        if ($this->model) {
            $this->model::withTrashed()->restore();
        }
        $this->emit('refreshDatatable');
    }

    public function restoreSelected()
    {
        if ($this->model && $this->selectedRowsQuery->count() > 0) {
            $this->model::withTrashed()->whereIn('id', $this->selectedKeys())->restore();
        }

        $this->resetBulk();
    }

    public function restore($id)
    {
        if ($this->model) {
            $this->model::onlyTrashed()->find($id)->restore();
        }
        $this->emit('refreshDatatable');
    }

    //------------------------------------------------------------------------------------------------------------------

//    public function exportSelected($writerType = 'DOMPDF')
//    {
//        // XLSX; CSV ; TSV; ODS; XLS; MPDF; DOMPDF; TCPDF
//        if ($this->exportModel && $this->selectedRowsQuery->count() > 0) {
//            $exportModel = new $this->exportModel($this->selectedRowsQuery);
//            if ($writerType == 'XLSX') {
//                return $exportModel->download($this->tableName.'.xlsx', Excel::XLSX);
//            } elseif ($writerType == 'CSV') {
//                return $exportModel->download($this->tableName.'.csv', Excel::CSV);
//            } elseif ($writerType == 'DOMPDF') {
//                return $exportModel->download($this->tableName.'.pdf', Excel::DOMPDF);
//            }
//        }
//        return null;
//    }
//
//    public function exportAll($writerType = 'XLSX')
//    {
//        // XLSX; CSV ; TSV; ODS; XLS; MPDF; DOMPDF; TCPDF
//        if ($this->exportModel) {
//            $exportModel = new $this->exportModel();
//            if ($writerType == 'XLSX') {
//                return $exportModel->download($this->tableName.'.xlsx', Excel::XLSX);
//            } elseif ($writerType == 'CSV') {
//                return $exportModel->download($this->tableName.'.csv', Excel::CSV);
//            } elseif ($writerType == 'DOMPDF') {
//                return $exportModel->download($this->tableName.'.pdf', Excel::DOMPDF);
//            }
//        }
//        return null;
//    }

    //------------------------------------------------------------------------------------------------------------------

    /*
    // Lignes cliquables
    public function getTableRowUrl($row): string
    {
        return route('my.edit.route', $row);
    }

    // Définition de la cible
    public function getTableRowUrlTarget($row): ?string
    {
        if ($row->type === 'this') {
            return '_blank';
        }

        return null;
    }

    public function getTableRowUrlTarget(): string
    {
        return '_blank';
    }*/

    /** Classes, ID et attributs
    public function setTableRowClass($row): ?string
    {
    return $row->isSuccess() ? 'bg-green-500' : null;
    }
    public function setTableRowClass($row): ?string
    {
    if ($row->active === false)  {
    if (config('livewire-tables.theme') === 'tailwind') {
    return '!bg-red-200';
    } else if (config('livewire-tables.theme') === 'bootstrap-4') {
    return 'bg-danger text-white';
    } else if(config('livewire-tables.theme') === 'bootstrap-5') {
    return 'bg-danger text-white';
    }
    }

    return null;
    }
    public function setTableRowId($row): ?string
    {
    return 'row-' . $row->id;
    }
    public function setTableRowAttributes($row): array
    {
    return $row->hasFailed() ? ['this' => 'that'] : [];
    }
    public function setTableDataClass(Column $column, $row): ?string
    {
    if ($column->column() === 'email' && ! $row->isVerified()) {
    return 'text-danger';
    }

    return null;
    }
    public function setTableDataId(Column $column, $row): ?string
    {
    if ($column->column() === 'email') {
    return 'user-email-' . $row->id;
    }

    return null;
    }
    public function setTableDataAttributes(Column $column, $row): array
    {
    if ($column->column() === 'email' && ! $row->isVerified()) {
    return ['this' => 'that'];
    }

    return [];
    }
    public function setFooterDataClass(Column $column, $rows): ?string
    {
    if ($column->column() === 'sales' && $rows->sum('sales') > 1000) {
    return 'bg-green-500 text-green-800';
    }

    return null;
    }*/

//    // To show/hide the modal
//    public bool $viewingModal = false;
//    // The information currently being displayed in the modal
//    public $currentModal;
//    /**
//     * Active le clic sur la ligne mais ne renvoyez pas d’URL.
//     * @return string
//     */
//    public function getTableRoUrl(): string
//    {
//        return '#';
//    }
//
//    /**
//     * Ajoute un attribut personnalisé avec un fil:cliquez sur
//     * Ajoute une méthode pour appeler avec la ligne sélectionnée qui affichera notre modal.
//     * @param $row
//     * @return string[]
//     */
//    public function setTableRowAttributes($row): array
//    {
//        return ['wire:click.prevent' => 'viewModal('.$row->id.')'];
//    }
//
//    public function viewModal($row)
//    {
//
//    }
//
//    /**
//     * implémente la méthode pour gérer le modal
//     * @param $modelId
//     */
//    public function viewHistoryModal($modelId): void
//    {
//        $this->viewingModal = true;
//        $this->currentModal = $this->model::findOrFail($modelId);
//    }
//
//    /**
//     * Ajoute une méthode pour réinitialiser le modal
//     */
//    public function resetModal(): void
//    {
//        $this->reset('viewingModal', 'currentModal');
//    }
//
//    /**
//     * Ajoute le balisage modal à l’aide de la méthode suivante
//     * @return string
//     */
//    public function modalsView(): string
//    {
//        return 'livewire-tables._includes.modal';
//        //return 'admin.livewire.my-model._includes.modal';
//    }
}
