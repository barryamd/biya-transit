<?php

namespace App\LivewireTables\Views;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class YesNoFilter extends SelectFilter
{
    public static function make(string $name, string $key = null, ?array $attributes = []): Filter
    {
        if ($key == null)
            $key = str_lower($name);
        return parent::make($name, $key)
            ->setFilterPillValues([
                '1' => 'Active',
                '0' => 'Inactive',
            ])
            ->options([
                ''    => __('All'),
                '1' => __('Yes'),
                '0'  => __('No'),
            ])
            ->filter(function(Builder $builder, string $value) use ($key) {
                if ($value === '1') {
                    $builder->where($key, true);
                } elseif ($value === '0') {
                    $builder->where($key, false);
                }
            });
    }
}
