<?php

namespace App\LivewireTables\Traits;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

//use Maatwebsite\Excel\Excel;

trait WithCrudActions
{
    use LivewireAlert;

    public bool $isEditMode = false;
    public int|null $rowId = null;
    public string $resourceName = 'Resource';

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

    public function openEditModal(int $id, $modalId)
    {
        try {
            $model = $this->model::findOrFail($id);
            $this->rowId = $id;
            $this->fillInputs($model);
            $this->dispatchBrowserEvent('open-'.$modalId);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
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

//    public function deleteAll(): void
//    {
//        if ($this->model) {
//            $models = $this->model::all();
//
//            foreach ($models as $model) {
//                $model->delete();
//            }
//        }
//        $this->emit('refreshDatatable');
//    }
//
//    public function deleteSelected(): void
//    {
//        $this->confirm(__('Are you sure you want to delete the selected resources?'), [
//            'confirmButtonText' => __('Yes'),
//            'cancelButtonText' => __('No'),
//            'onConfirmed' => 'confirmed',
//        ]);
//    }
//
//    public function delete($id): void
//    {
//        $this->rowId = (int)$id;
//        $this->confirm(__('Are you sure you want to delete this resource?'), [
//            'confirmButtonText' => __('Yes'),
//            'cancelButtonText' => __('No'),
//            'onConfirmed' => 'confirmed',
//        ]);
//    }
//
//    public function confirmed()
//    {
//        if ($this->model) {
//            try {
//                if ($this->rowId) {
//                    if ($this->model::findOrFail($this->rowId)->delete()) {
//                        $this->emit('refreshDatatable');
//                        $this->alert('success', __('Resource deleted successfully.'));
//                        $this->rowId = null;
//                    }
//                } elseif ($this->selectedRowsQuery->count() > 0) {
//                    $models = $this->model::whereIn('id', $this->selectedKeys())->get();
//                    foreach ($models as $model) {
//                        $model->delete();
//                    }
//                    $this->resetBulk();
//                    $this->alert('success', __('Resources deleted successfully.'));
//                }
//                // $this->resetAll(); // Réinitialisez tous les filtres et critères.
//            } catch (\Exception $exception) {
//                $this->alert('error', 'Error! '.$exception->getMessage());
//            }
//        } else $this->alert('error', 'Error!');
//    }
//
//    //------------------------------------------------------------------------------------------------------------------
//
//    public function forceDeleteAll()
//    {
//        if ($this->model) {
//            $models = $this->model::onlyTrashed()->get();
//
//            foreach ($models as $model) {
//                $model->forceDelete();
//            }
//        }
//
//        $this->emit('refreshDatatable');
//    }
//
//    public function forceDeleteSelected()
//    {
//        if ($this->model && $this->selectedRowsQuery->count() > 0) {
//            $models = $this->model::onlyTrashed()->whereIn('id', $this->selectedKeys())->get();
//
//            foreach ($models as $model) {
//                $model->forceDelete();
//            }
//        }
//
//        $this->resetBulk();
//    }
//
//    public function forceDelete($id, $attachedFilePath = null)
//    {
//        if ($this->model && $id) {
//            $model = $this->model::onlyTrashed()->find($id);
//            $model->forceDelete();
//        }
//
//        $this->emit('refreshDatatable');
//    }

    //------------------------------------------------------------------------------------------------------------------

//    public function restoreAll()
//    {
//        if ($this->model) {
//            $this->model::withTrashed()->restore();
//        }
//        $this->emit('refreshDatatable');
//    }
//
//    public function restoreSelected()
//    {
//        if ($this->model && $this->selectedRowsQuery->count() > 0) {
//            $this->model::withTrashed()->whereIn('id', $this->selectedKeys())->restore();
//        }
//
//        $this->resetBulk();
//    }
//
//    public function restore($id)
//    {
//        if ($this->model) {
//            $this->model::onlyTrashed()->find($id)->restore();
//        }
//        $this->emit('refreshDatatable');
//    }
}
