<?php

namespace App\Models;

use App\Helpers\HasFile;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Folder extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'customer_id',
        'number',
        'num_cnt',
        'weight',
        'harbor',
        'observation',
        'status',
    ];

    protected array $searchableFields = ['*'];

    public function generateUniqueNumber()
    {
        $lastFolder = Folder::query()->latest()->get()->first();
        if ($lastFolder) {
            $id = $lastFolder->id + 1;
        } else {
            $id = 1;
        }
        $this->number = date('y') . str_pad($id, 3, '0', STR_PAD_LEFT) . '/IM' ;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function containers(): HasMany
    {
        return $this->hasMany(Container::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function ddiOpening(): HasOne
    {
        return $this->hasOne(DdiOpening::class);
    }

    public function exoneration(): HasOne
    {
        return $this->hasOne(Exoneration::class);
    }

    public function declaration(): HasOne
    {
        return $this->hasOne(Declaration::class);
    }

    public function deliveryNote(): HasOne
    {
        return $this->hasOne(DeliveryNote::class);
    }

    public function deliveryDetails(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }
}
