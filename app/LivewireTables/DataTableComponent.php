<?php

namespace App\LivewireTables;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

abstract class DataTableComponent extends \Rappasoft\LaravelLivewireTables\DataTableComponent
{
    use AuthorizesRequests;
    use LivewireAlert;

    protected array $createButtonParams = [];
    public bool $isEditMode = false;
    public int|null $rowDeletingId = null;
    public string|null $exportClass =  null;
    protected string|null $printView = null;

    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'confirmed',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setReorderDisabled()
            //->setDefaultReorderSort('created_at', 'desc')
            ->setSingleSortingDisabled()
            ->setHideReorderColumnUnlessReorderingEnabled()
            ->setFilterLayoutSlideDown()
            ->setRememberColumnSelectionDisabled()
            ->setTableAttributes([
                'class' => 'table table-striped table-sm projects'
            ])
            ->setSecondaryHeaderTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
                if ($column->isField('id')) {
                    return ['class' => 'text-red-500'];
                }
                return ['default' => true];
            })
            ->setFooterTrAttributes(function($rows) {
                return ['class' => 'bg-gray-100'];
            })
            ->setFooterTdAttributes(function(Column $column, $rows) {
                if ($column->isField('name')) {
                    return ['class' => 'text-green-500'];
                }
                return ['default' => true];
            })
            //->setUseHeaderAsFooterEnabled()
            ->setHideBulkActionsWhenEmptyEnabled()
            //->setEagerLoadAllRelationsEnabled()
            ->setConfigurableAreas([
                // 'before-tools' => 'path.to.my.view',
                // 'toolbar-left-start' => 'path.to.my.view',
                // 'toolbar-left-end' => 'path.to.my.view',
                // 'toolbar-right-start' => 'path.to.my.view',
                'toolbar-right-end' => [
                    'vendor.livewire-tables.includes.create-button', $this->createButtonParams,
                ],
                // 'before-toolbar' => 'path.to.my.view',
                // 'after-toolbar' => 'path.to.my.view',
                // 'before-pagination' => 'path.to.my.view',
                // 'after-pagination' => 'path.to.my.view',
            ])
            ->setHideConfigurableAreasWhenReorderingStatus(false);
    }

    public function bulkActions(): array
    {
        return [
            'deleteSelected' => __('Delete'),
        ];
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
        $this->rowDeletingId = (int)$id;
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
                if ($this->rowDeletingId) {
                    if ($this->model::findOrFail($this->rowDeletingId)->delete()) {
                        $this->emit('refreshDatatable');
                        $this->alert('success', __('Resource deleted successfully.'));
                        $this->rowDeletingId = null;
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

    //------------------------------------------------------------------------------------------------------------------

    public function enableOrDisable($id, $column)
    {
        try {
            $model = $this->model::findOrFail($id);
            $model->$column = !$model->$column;
            $model->save();
            $this->alert('success', "Le changement d'état a été enregistré avec succès.");
        } catch (\Exception $exception) {
            $this->alert('error', "Erreur! .".$exception->getMessage());
        }
    }

    public function enable()
    {
        if ($this->model) {
            $this->model::whereIn('id', $this->getSelected())->update(['enable' => true]);

            $this->clearSelected();
        }
    }

    public function disable()
    {
        if ($this->model) {
            $this->model::whereIn('id', $this->getSelected())->update(['enable' => false]);

            $this->clearSelected();
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    public function badge($text, $type = 'secondary', $margin = 0): string
    {
        return '<span class="badge badge-' . $type . ' ml-' . $margin . '">' . __($text) . '</span>';
    }

    public function button($route, $color, $icon, $title = '', $target = '_self'): Column|LinkColumn
    {
        return LinkColumn::make($title)
            ->title(fn($row) => "<i class='fa fa-$icon . '></i>")
            ->location(fn($row) => route($route, $row))
            ->attributes(function($row) use($title, $color, $target) {
                return [
                    'class' => "px-3 btn btn-xs btn-$color",
                    'title' => $title,
                    'target' => $target,
                ];
            });
    }

    public function viewButton($route): LinkColumn|Column
    {
        return LinkColumn::make('View')
            ->title(fn($row) => '<i class="fas fa-eye"></i>')
            ->location(fn($row) => route($route, $row))
            ->attributes(function($row) {
                return [
                    'class' => 'btn text-info text-lg',
                    'title' => __('View'),
                ];
            });
    }

    public function editButton($route, $modal = null): LinkColumn|Column
    {
        return LinkColumn::make('Edit')
            ->title(fn($row) => '<i class="fas fa-edit"></i>')
            ->location(fn($row) => $modal ? 'javascript:void(0)' : route($route, $row))
            ->attributes(function($row) use($route, $modal) {
                return [
                    'class' => 'btn text-primary text-lg',
                    'wire:click' => $this->model ? "openEditModal('$row->id', '$modal')" : null,
                    'title' => __('Edit'),
                ];
            });
    }

    public function deleteButton(): LinkColumn|Column
    {
        return LinkColumn::make('Delete')
            ->title(fn($row) => '<i class="fas fa-trash"></i>')
            ->location(fn($row) => 'javascript:void(0)')
            ->attributes(function($row) {
                return [
                    'class' => 'btn text-danger text-lg',
                    'wire:click' => "delete('$row->id')",
                    'title' => __('Delete'),
                ];
            });
    }
}
