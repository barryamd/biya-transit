<?php

namespace App\LivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Column;

class ActionColumn
{
    public static function view($view)
    {
        return Column::make('Actions', 'id')
            ->format(fn($id) => view($view, ['id' => $id]))
            ->html()->unclickable();
    }

    public static function show($routeName, $name = 'id')
    {
        return Column::make('Show', $name)
            ->format(function($id) use ($routeName){
                $route = route($routeName, $id);
                $text = __('View');
                return "<a href='{$route}' class='btn btn-info btn-sm'><i class='fas fa-eye'></i> {$text}</a>";
            })
            ->html()->unclickable();
    }

    public static function edit($routeName, $name = 'id')
    {
        return Column::make('Edit', $name)
            ->format(function($id) use ($routeName){
                $route = route($routeName, $id);
                $text = __('Edit');
                return "<a href='{$route}' class='btn btn-primary btn-sm'><i class='fas fa-pencil-alt'></i> {$text}</a>";
            })
            ->html()->unclickable();
    }

    public static function delete($name = 'id')
    {
        return Column::make('Delete', $name)
            ->format(function($id) {
                $text = __('Delete');
                return "<a href='#' wire:click.prevent='delete({$id})' type='button' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> {$text}</a>";
            })
            ->html()->unclickable();
    }

    public static function actions($from = 'id', $editRouteName = null, $showRouteName = null)
    {
        return Column::make('Actions', $from)
            ->format(function($id) use ($editRouteName, $showRouteName){
                if ($editRouteName) {
                    $editRoute = route($editRouteName, $id);
                    $editButton = "<a href='{$editRoute}' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i></a>";
                } else $editButton = '';

                if ($showRouteName) {
                    $showRoute = route($showRouteName, $id);
                    $showButton = "<a href='{$showRoute}' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>";
                } else $showButton = '';
                return <<<blade
                    <div class="btn-group btn-group-sm">
                        $showButton
                        $editButton
                        <a href="#" wire:click.prevent="delete({$id})" type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                    </div>
                blade;
            })
            ->html()->unclickable();
    }

    public static function actions2($name = 'id', $editRouteName = null, $showRouteName = null)
    {
        return Column::make('Actions', $name)
            ->format(function($value, $column, $row) use ($editRouteName, $showRouteName){
                return view('livewire-tables.cells.actions',
                    ['id' => $value, 'editRouteName' => $editRouteName, 'showRouteName' => $showRouteName]
                );  // ->withUser($row);
            })
            ->html()->unclickable();
    }
}
