<?php

namespace App\LivewireTables\Traits;

use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithDefaultConfigs
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setReorderEnabled()
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
            ;
    }

    public function bulkActions(): array
    {
        return [
            'deleteSelected' => 'Delete',
        ];
    }

    public function reorder($items): void
    {
        if ($this->model) {
            foreach ($items as $item) {
                $this->model::find((int)$item['value'])->update(['sort' => (int)$item['order']]);
            }
        }
    }
}
