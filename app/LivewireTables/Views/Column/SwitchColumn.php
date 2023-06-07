<?php

namespace App\LivewireTables\Views\Column;

use Illuminate\Support\Carbon;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SwitchColumn extends Column
{
    public static function make(string $title, string $from = null): Column
    {
        return parent::make($title, $from)
            ->format(function ($value, $row, $column) use ($from) {
                $from = array_reverse(explode('.', $from))[0];
                return view('vendor.livewire-tables.includes.columns.status',
                    compact('value', 'row', 'from'));
            });
    }
}
