<?php

namespace App\LivewireTables\Views\Column;

use Illuminate\Support\Carbon;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SwitchColumn extends Column
{
    public static function make(string $title, string $from = null): Column
    {
        return parent::make($title, $from)
            ->format(function ($value, $row, $column) {
                $column = array_reverse(explode('.', $column->field))[0];
                return view('vendor.livewire-tables.includes.columns.switch',
                    compact('value', 'row', 'column'));
            });
    }
}
