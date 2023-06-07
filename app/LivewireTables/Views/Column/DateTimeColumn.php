<?php

namespace App\LivewireTables\Views\Column;

use Illuminate\Support\Carbon;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DateTimeColumn extends Column
{
    public static function make(string $title, string $from = null): Column
    {
        return parent::make($title, $from)
            ->format(function ($value) {
                return view('vendor.livewire-tables.includes.columns.datetime', compact('value'));
            });
    }
}
