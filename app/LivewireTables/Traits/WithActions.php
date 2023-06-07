<?php

namespace App\LivewireTables\Traits;

use Jantinnerezo\LivewireAlert\LivewireAlert;
//use Maatwebsite\Excel\Excel;

trait WithActions
{
    use LivewireAlert;

    public $rowId;

    /*public function delete(int $id)
    {
        $this->rowId = $id;
    }

    public function destroy()
    {
        try {
            $this->model::query()->where('id', $this->rowId)->delete();
            $this->alert('success', 'Resource Deleted Successfully.');
            $this->dispatchBrowserEvent('close-modal');
            $this->emit('refreshDatatable');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('close-modal');
            $this->alert('warning', $exception->getMessage());
        }
    }*/

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
                } elseif ($this->getSelectedCount() > 0) {
                    $models = $this->model::whereIn('id', $this->getSelected())->get();
                    foreach ($models as $model) {
                        $model->delete();
                    }
                    $this->clearSelected();
                    $this->alert('success', __('Resources deleted successfully.'));
                }
                // $this->resetAll(); // Réinitialisez tous les filtres et critères.
            } catch (\Exception $exception) {
                $message = "Impossible de supprimer ce enregstrement car il y'a des energistremenst qui dependent de lui.
                                 Veuillez supprimer ces enregistrements d'abord.";
                $this->alert('error', $message);
            }
        } else $this->alert('error', 'Error! Vous avez pas ajouter le model.');
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
        if ($this->model && $this->getSelectedCount() > 0) {
            $models = $this->model::onlyTrashed()->whereIn('id', $this->getSelected())->get();

            foreach ($models as $model) {
                $model->forceDelete();
            }
        }

        $this->clearSelected();
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
        if ($this->model && $this->getSelectedCount() > 0) {
            $this->model::withTrashed()->whereIn('id', $this->getSelected())->restore();
        }

        $this->clearSelected();
    }

    public function restore($id)
    {
        if ($this->model) {
            $this->model::onlyTrashed()->find($id)->restore();
        }
        $this->emit('refreshDatatable');
    }

    //------------------------------------------------------------------------------------------------------------------

    public function activate($name)
    {
        if ($this->model) {
            $this->model::whereIn('id', $this->getSelected())->update([$name => 1]);

            $this->clearSelected();
        }
    }

    public function deactivate($name)
    {
        if ($this->model) {
            $this->model::whereIn('id', $this->getSelected())->update([$name => 0]);

            $this->clearSelected();
        }
    }

    //------------------------------------------------------------------------------------------------------------------

//    public function exportSelected($writerType = 'DOMPDF')
//    {
//        // XLSX; CSV ; TSV; ODS; XLS; MPDF; DOMPDF; TCPDF
//        if ($this->exportClass && $this->getSelectedCount() > 0) {
//            $exportModel = new $this->exportClass($this->getSelected());
//            $this->clearSelected();
//
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

//    public function exportAll($writerType = 'XLSX')
//    {
//        // XLSX; CSV ; TSV; ODS; XLS; MPDF; DOMPDF; TCPDF
//        if ($this->exportClass) {
//            $exportClass = new $this->exportClass();
//            if ($writerType == 'XLSX') {
//                return $exportClass->download($this->tableName.'.xlsx', Excel::XLSX);
//            } elseif ($writerType == 'CSV') {
//                return $exportClass->download($this->tableName.'.csv', Excel::CSV);
//            } elseif ($writerType == 'DOMPDF') {
//                return $exportClass->download($this->tableName.'.pdf', Excel::DOMPDF);
//            }
//        }
//        return null;
//    }


    //------------------------------------------------------------------------------------------------------------------

    public function printAll()
    {
        if ($this->model) {
            $models = $this->model::all();

            redirect($this->printView)->withData($models);
        }
    }

    public function printSelected()
    {
        if ($this->model) {
            $models = $this->model::whereIn('id', $this->getSelected())->get();

            redirect($this->printView)->withData($models);
        }

        $this->clearSelected();
    }
}
