<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transporter extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'numberplate',
        'marque',
        'driver_name',
        'driver_phone',
    ];

    protected array $searchableFields = ['*'];

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
