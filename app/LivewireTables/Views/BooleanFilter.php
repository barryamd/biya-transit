<?php

namespace App\LivewireTables\Views;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class BooleanFilter extends SelectFilter
{
    public static function make(string $name, string $key = null, ?array $attributes = []): Filter
    {
        return parent::make($name, $key)
            //->setFilterPillTitle('User Status')
            ->setFilterPillValues([
                '1' => 'Active',
                '0' => 'Inactive',
            ])
            ->options([
                ''    => __('All'),
                'yes' => __('Yes'),
                'no'  => __('No'),
            ])
            ->filter(function(Builder $builder, string $value) {
                if ($value === '1') {
                    $builder->where('active', true);
                } elseif ($value === '0') {
                    $builder->where('active', false);
                }
            });
    }
}
