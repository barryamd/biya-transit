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
//use Spatie\MediaLibrary\InteractsWithMedia;

class Folder extends Model
{
    use HasFactory;
    //use InteractsWithMedia;
    use HasFile;
    use Searchable;

    public const PATH = 'folders';

    protected $fillable = [
        'customer_id',
        'number',
        'num_cnt',
        'ship',
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

    public function purchaseInvoices(): HasMany
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public function exoneration(): HasOne
    {
        return $this->hasOne(Exoneration::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentDvt(): HasOne
    {
        return $this->hasOne(Payment::class)->where('type', 'DVT');
    }

    public function paymentDdi(): HasOne
    {
        return $this->hasOne(Payment::class)->where('type', 'DDI');
    }
    public function paymentTm(): HasOne
    {
        return $this->hasOne(Payment::class)->where('type', 'TM');
    }

    public function paymentCt(): HasOne
    {
        return $this->hasOne(Payment::class)->where('type', 'CT');
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
