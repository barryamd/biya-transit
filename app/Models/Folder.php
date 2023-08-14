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
        'bcm',
        'bct'
    ];

    protected array $searchableFields = ['*'];

    public function generateUniqueNumber()
    {
//        $lastFolder = Folder::query()->latest()->get()->first();
//        if ($lastFolder) {
//            $id = $lastFolder->id + 1;
//        } else {
//            $id = 1;
//        }
        $id = Folder::query()->count() + 1;
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

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function ddiOpening(): HasOne
    {
        return $this->hasOne(DdiOpening::class);
    }

    public function exonerations(): HasMany
    {
        return $this->hasMany(Exoneration::class);
    }

    public function declarations(): HasMany
    {
        return $this->hasMany(Declaration::class);
    }

    public function deliveryFiles(): HasMany
    {
        return $this->hasMany(DeliveryFile::class);
    }

    public function deliveryDetails(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
